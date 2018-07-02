<?php

namespace App\Http\Controllers;

use App\DataTables\LeaseDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLeaseRequest;
use App\Http\Requests\UpdateLeaseRequest;
use App\Jobs\SendSms;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\CustomerAccount;
use App\Models\CustomerMessage;
use App\Models\EventMessage;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\UnitServiceBill;
use App\Repositories\LeaseRepository;
use Carbon\Carbon;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class LeaseController extends AppBaseController
{
    /** @var  LeaseRepository */
    private $leaseRepository;

    public function __construct(LeaseRepository $leaseRepo)
    {
        $this->middleware('auth');
        $this->leaseRepository = $leaseRepo;
    }

    /**
     * Display a listing of the Lease.
     *
     * @param LeaseDataTable $leaseDataTable
     * @return Response
     */
    public function index(LeaseDataTable $leaseDataTable)
    {
        return $leaseDataTable->render('leases.index',[
            'properties'=>Property::where('status',true)->get(),
            'tenants'=>Masterfile::where('b_role',tenant)->get(),
        ]);
    }

    /**
     * Show the form for creating a new Lease.
     *
     * @return Response
     */
    public function create()
    {
        return view('leases.create');
    }

    /**
     * Store a newly created Lease in storage.
     *
     * @param CreateLeaseRequest $request
     *
     * @return Response
     */
    public function store(CreateLeaseRequest $request)
    {
        $this->validate($request,[
           'property'=>'required',
            'house_number'=>'required',
            'tenant_id'=>'required'
        ]);
        $input = $request->all();
        $input['unit_id'] = $request->house_number;
        $input['property_id'] = $request->property;
        $unitBills = UnitServiceBill::where('unit_id',$input['unit_id'])->where('status',true)->get();
        if(!count($unitBills)){
            Flash::error('Failed! You must attach atleast one service bill(rent) to this house.');

            return redirect(route('leases.index'));
        }

        DB::transaction(function()use ($input,$unitBills){
            $lease = $this->leaseRepository->create($input);

            $bill = Bill::create([
               'lease_id'=>$lease->id,
               'tenant_id'=>$input['tenant_id'],
               'property_id'=> $input['property_id'],
               'description'=> 'Lease Creation',
                'total'=>$unitBills->sum('amount')
            ]);
            if(count($unitBills)){
                foreach ($unitBills as $unitBill){
                    $billDetail = BillDetail::create([
                        'bill_id'=> $bill->id,
                        'service_bill_id'=> $unitBill->service_bill_id,
                        'amount'=>$unitBill->amount,
                        'balance'=>$unitBill->amount,
                        'status'=>false,
                        'bill_date'=>$input['start_date']
                    ]);
                }
            }

            $customerAccount = CustomerAccount::create([
                'tenant_id'=>$input['tenant_id'],
                'lease_id'=>$lease->id,
                'unit_id'=> $input['unit_id'],
                'bill_id'=>$bill->id,
                'transaction_type'=>credit,
                'amount'=>$unitBills->sum('amount'),
                'balance'=>$unitBills->sum('amount'),
                'date'=>$input['start_date']
            ]);
        });
        $mf = Masterfile::find($input['tenant_id']);
        $unit = PropertyUnit::find($input['unit_id']);

        if(!is_null($mf->phone_number) && !empty($mf->phone_number)){
            $message = EventMessage::where('code',lease_creation)->first();
            if(!is_null($message)){
                $mess = str_replace([
                    '@name',
                    '@house_number',
                ], [
                    explode(' ',$mf->full_name)[0],
                    $unit->unit_number
                ], $message->message);

                SendSms::dispatch($mess,$mf->phone_number,$mf);
                //saves sms

            }
        }



        Flash::success('Lease saved successfully.');

        return redirect(route('leases.index'));
    }

    /**
     * Display the specified Lease.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $lease = $this->leaseRepository->findWithoutFail($id);

        if (empty($lease)) {
            Flash::error('Lease not found');

            return redirect(route('leases.index'));
        }

        return view('leases.show')->with('lease', $lease);
    }

    /**
     * Show the form for editing the specified Lease.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $lease = $this->leaseRepository->findWithoutFail($id);

        if (empty($lease)) {
            Flash::error('Lease not found');

            return redirect(route('leases.index'));
        }

        return view('leases.edit')->with('lease', $lease);
    }

    /**
     * Update the specified Lease in storage.
     *
     * @param  int              $id
     * @param UpdateLeaseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLeaseRequest $request)
    {
        $lease = $this->leaseRepository->findWithoutFail($id);

        if (empty($lease)) {
            Flash::error('Lease not found');

            return redirect(route('leases.index'));
        }

        $lease = $this->leaseRepository->update($request->all(), $id);

        Flash::success('Lease updated successfully.');

        return redirect(route('leases.index'));
    }

    /**
     * Remove the specified Lease from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $lease = Lease::find($id);

        if (empty($lease)) {
            Flash::error('Lease not found');

            return redirect(route('leases.index'));
        }

        $lease->status = false;
        $lease->state = 'Terminated';
        $lease->reversed_by = Auth::id();
        $lease->save();

        Flash::success('Lease terminated successfully.');

        return redirect(route('leases.index'));
    }

    public function getUnits($id){
        $unitsWithActiveLease = Lease::query()
            ->select('leases.unit_id')
            ->leftJoin('property_units','property_units.id','=','leases.unit_id')
            ->where('leases.status',true)->where('property_units.property_id',$id)->get()->toArray();
        $units = PropertyUnit::where('property_id',$id)
            ->whereNotIn('id',$unitsWithActiveLease)
            ->get();
        return response()->json($units);
    }

    public function getBills($id){
        $bills = UnitServiceBill::query()
            ->select(['period','name','amount'])
            ->leftJoin('service_options','service_options.id','=','unit_service_bills.service_bill_id')
            ->where([['unit_service_bills.unit_id',$id],['service_options.status',true]])->get();

        return response()->json($bills);
    }

    public function reverse($id){


        DB::transaction(function()use ($id){
            $lease = Lease::find($id);
            $lease->status = false;
            $lease->is_reversed = true;
            $lease->reversed_by = Auth::id();
            $lease->state = 'Reversed';
            $lease->save();
            $bill = Bill::where([['lease_id',$id],['description','Lease Creation']])->first();

            if(!is_null($bill)){
                //create a negative bill
                $reversal = Bill::create([
                    'lease_id'=> $id,
                    'tenant_id'=> $bill->id,
                    'property_id'=>$bill->tenant_id,
                    'description'=> 'Lease reversal',
                    'ref_number'=>$bill->id,
                    'total'=>-$bill->total,
                ]);
                $billDetails = BillDetail::where('bill_id',$bill->id)->get();
                if(count($billDetails)){
                    foreach ($billDetails as $billDetail){
                        BillDetail::create([
                            'bill_id'=>$reversal->id,
                            'service_bill_id'=>$billDetail->service_bill_id,
                            'amount'=> -$billDetail->amount,
                            'balance' => -$billDetail->amount,
                            'status'=>true
                        ]);
                    }
                }

                //customer account
                $customerAccount = CustomerAccount::create([
                    'tenant_id'=>$bill->tenant_id,
                    'lease_id'=>$id,
                    'unit_id'=> $lease->unit_id,
                    'bill_id'=>$reversal->id,
                    'transaction_type'=>credit,
                    'amount'=>- $bill->total,
                    'balance'=>-$bill->total,
                    'date'=>Carbon::now()
                ]);
            }
        });
        Flash::success('Lease reversed successfully.');

        return redirect(route('terminatedLeases.index'));
    }
}

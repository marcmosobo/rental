<?php

namespace App\Http\Controllers;

use App\DataTables\LeaseDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLeaseRequest;
use App\Http\Requests\UpdateLeaseRequest;
use App\Models\Lease;
use App\Models\Masterfile;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\UnitServiceBill;
use App\Repositories\LeaseRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
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

        DB::transaction(function()use ($input){
            $lease = $this->leaseRepository->create($input);
        });



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
        $lease = $this->leaseRepository->findWithoutFail($id);

        if (empty($lease)) {
            Flash::error('Lease not found');

            return redirect(route('leases.index'));
        }

        $this->leaseRepository->delete($id);

        Flash::success('Lease deleted successfully.');

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
}

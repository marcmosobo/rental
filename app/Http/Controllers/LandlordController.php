<?php

namespace App\Http\Controllers;

use App\DataTables\LandlordDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLandlordRequest;
use App\Http\Requests\UpdateLandlordRequest;
use App\Jobs\ImportTenants;
use App\Models\Masterfile;
use App\Models\Role;
use App\Models\User;
use App\Repositories\LandlordRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Illuminate\Queue\Jobs\Job;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use League\Csv\Statement;
use Response;

class LandlordController extends AppBaseController
{
    /** @var  LandlordRepository */
    private $landlordRepository;

    public function __construct(LandlordRepository $landlordRepo)
    {
        $this->middleware('auth');
        $this->landlordRepository = $landlordRepo;
    }

    /**
     * Display a listing of the Landlord.
     *
     * @param LandlordDataTable $landlordDataTable
     * @return Response
     */
    public function index(LandlordDataTable $landlordDataTable)
    {
        return $landlordDataTable->render('landlords.index');
    }

    /**
     * Show the form for creating a new Landlord.
     *
     * @return Response
     */
    public function create()
    {
        return view('landlords.create');
    }

    /**
     * Store a newly created Landlord in storage.
     *
     * @param CreateLandlordRequest $request
     *
     * @return Response
     */
    public function store(CreateLandlordRequest $request)
    {
        $input = $request->all();
        $input['client_id'] = Auth::user()->client_id;
        $input['b_role'] = landlord;
        $input['created_by'] = Auth::user()->mf_id;

        DB::transaction(function() use ($input){
            $landlord = $this->landlordRepository->create($input);

            $acc = User::create([
                'name'=> $input['full_name'],
                'email'=>$input['email'],
                'password'=> bcrypt(123456),
                'mf_id' => $landlord->id,
                'role_id'=> Role::where('code',landlord)->first()->id,
                'created_by'=> $input['created_by'],
                'password_changed'=>false,
                'account_status'=>true,
                'client_id'=>$input['client_id']
            ]);
        });



        Flash::success('Landlord created successfully.');

        return redirect(route('landlords.index'));
    }

    /**
     * Display the specified Landlord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $landlord = $this->landlordRepository->findWithoutFail($id);

        if (empty($landlord)) {
            Flash::error('Landlord not found');

            return redirect(route('landlords.index'));
        }

        return response()->json($landlord);
    }

    /**
     * Show the form for editing the specified Landlord.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $landlord = $this->landlordRepository->findWithoutFail($id);

        if (empty($landlord)) {
            Flash::error('Landlord not found');

            return redirect(route('landlords.index'));
        }

        return view('landlords.edit')->with('landlord', $landlord);
    }

    /**
     * Update the specified Landlord in storage.
     *
     * @param  int              $id
     * @param UpdateLandlordRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLandlordRequest $request)
    {
        $landlord = $this->landlordRepository->findWithoutFail($id);

        if (empty($landlord)) {
            Flash::error('Landlord not found');

            return redirect(route('landlords.index'));
        }

        $landlord = $this->landlordRepository->update($request->all(), $id);

        Flash::success('Landlord updated successfully.');

        return redirect(route('landlords.index'));
    }

    /**
     * Remove the specified Landlord from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $landlord = $this->landlordRepository->findWithoutFail($id);

        if (empty($landlord)) {
            Flash::error('Landlord not found');

            return redirect(route('landlords.index'));
        }

        $this->landlordRepository->delete($id);

        Flash::success('Landlord deleted successfully.');

        return redirect(route('landlords.index'));
    }

    public function import(){
        return view('landlords.uploads');
    }

    public function importMasterfiles(Request $request){

//        var_dump($request->file('import_file')->path());die;
        $stream = fopen($request->file('import_file')->path(), 'r');
        $csv = Reader::createFromStream($stream);
        $csv->setDelimiter(',');
        $csv->setHeaderOffset(0);

        $stmt = (new Statement());
//            ->offset(10)
//            ->limit(25);

        //query your records from the document
        $records = $stmt->process($csv);
//        echo count($records);die;



        if($request->type == 'landlords'){
            $b_role =landlord;
        }else{
            $b_role = tenant;
        }

        foreach ($records as $record){
            if(is_null(Masterfile::where('full_name',$record['name'])->first())){
                $phone_number ='';
                if(!empty($record['phone_number'])){
//                        var_dump($record['phone_number']);die;
                    $phone_number = explode('/',$record['phone_number'])[0];

                    if($phone_number[0] ==='O'){
                        $phone_number = '0'.ltrim($phone_number,'O');
                    }else{
                        $phone_number = '0'.$phone_number;
                    }
                }
                ImportTenants::dispatch($record,$phone_number,$b_role);
            }
        }
    }
}

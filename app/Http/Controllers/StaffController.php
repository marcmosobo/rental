<?php

namespace App\Http\Controllers;

use App\DataTables\StaffDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateStaffRequest;
use App\Http\Requests\UpdateStaffRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\StaffRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class StaffController extends AppBaseController
{
    /** @var  StaffRepository */
    private $staffRepository;

    public function __construct(StaffRepository $staffRepo)
    {
        $this->middleware('auth');
        $this->staffRepository = $staffRepo;
    }

    /**
     * Display a listing of the Staff.
     *
     * @param StaffDataTable $staffDataTable
     * @return Response
     */
    public function index(StaffDataTable $staffDataTable)
    {
        return $staffDataTable->render('staff.index',[
            'roles'=>Role::where('code','<>',sys_admin)->get()
        ]);
    }

    /**
     * Show the form for creating a new Staff.
     *
     * @return Response
     */
    public function create()
    {
        return view('staff.create');
    }

    /**
     * Store a newly created Staff in storage.
     *
     * @param CreateStaffRequest $request
     *
     * @return Response
     */
    public function store(CreateStaffRequest $request)
    {
        $input = $request->all();

        DB::transaction(function ()use ($input){
            $input['b_role']= staff;
            $input['created_by'] = Auth::user()->mf_id;
            $input['client_id'] = Auth::user()->client_id;
            $staff = $this->staffRepository->create($input);

            $account = User::create([
                'name'=>$input['full_name'],
                'email'=> $input['email'],
                'password'=>bcrypt(123456),
                'mf_id'=> $staff->id,
                'role_id'=>$input['user_role'],
                'created_by'=>$input['created_by'],
                'password_changed'=>false,
                'email_confirmed'=>false,
                'client_id'=>$input['client_id']
            ]);
        });


        Flash::success('Staff saved successfully.');

        return redirect(route('staff.index'));
    }

    /**
     * Display the specified Staff.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $staff = $this->staffRepository->findWithoutFail($id);

        if (empty($staff)) {
            Flash::error('Staff not found');

            return redirect(route('staff.index'));
        }

        return response()->json($staff);
    }

    /**
     * Show the form for editing the specified Staff.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $staff = $this->staffRepository->findWithoutFail($id);

        if (empty($staff)) {
            Flash::error('Staff not found');

            return redirect(route('staff.index'));
        }

        return view('staff.edit')->with('staff', $staff);
    }

    /**
     * Update the specified Staff in storage.
     *
     * @param  int              $id
     * @param UpdateStaffRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateStaffRequest $request)
    {
        $staff = $this->staffRepository->findWithoutFail($id);

        if (empty($staff)) {
            Flash::error('Staff not found');

            return redirect(route('staff.index'));
        }

        $staff = $this->staffRepository->update($request->all(), $id);

        Flash::success('Staff updated successfully.');

        return redirect(route('staff.index'));
    }

    /**
     * Remove the specified Staff from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $staff = $this->staffRepository->findWithoutFail($id);

        if (empty($staff)) {
            Flash::error('Staff not found');

            return redirect(route('staff.index'));
        }

        $this->staffRepository->delete($id);

        Flash::success('Staff deleted successfully.');

        return redirect(route('staff.index'));
    }
}

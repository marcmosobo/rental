<?php

namespace App\Http\Controllers;

use App\DataTables\LandlordBankDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLandlordBankRequest;
use App\Http\Requests\UpdateLandlordBankRequest;
use App\Models\LandlordBank;
use App\Models\Masterfile;
use App\Repositories\LandlordBankRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LandlordBankController extends AppBaseController
{
    /** @var  LandlordBankRepository */
    private $landlordBankRepository;

    public function __construct(LandlordBankRepository $landlordBankRepo)
    {
        $this->middleware('auth');
        $this->landlordBankRepository = $landlordBankRepo;
    }

    /**
     * Display a listing of the LandlordBank.
     *
     * @param LandlordBankDataTable $landlordBankDataTable
     * @return Response
     */
    public function index(LandlordBankDataTable $landlordBankDataTable)
    {
        return $landlordBankDataTable->render('landlord_banks.index',[
            'landlords'=>Masterfile::where('b_role',landlord)->get()
        ]);
    }

    /**
     * Show the form for creating a new LandlordBank.
     *
     * @return Response
     */
    public function create()
    {
        return view('landlord_banks.create');
    }

    /**
     * Store a newly created LandlordBank in storage.
     *
     * @param CreateLandlordBankRequest $request
     *
     * @return Response
     */
    public function store(CreateLandlordBankRequest $request)
    {
        $input = $request->all();

        $landlordBank = $this->landlordBankRepository->create($input);

        Flash::success('Landlord Bank saved successfully.');

        return redirect(route('landlordBanks.index'));
    }

    /**
     * Display the specified LandlordBank.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $landlordBank = $this->landlordBankRepository->findWithoutFail($id);

        if (empty($landlordBank)) {
            Flash::error('Landlord Bank not found');

            return redirect(route('landlordBanks.index'));
        }

        return response()->json($landlordBank);
    }

    /**
     * Show the form for editing the specified LandlordBank.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $landlordBank = $this->landlordBankRepository->findWithoutFail($id);

        if (empty($landlordBank)) {
            Flash::error('Landlord Bank not found');

            return redirect(route('landlordBanks.index'));
        }

        return view('landlord_banks.edit')->with('landlordBank', $landlordBank);
    }

    /**
     * Update the specified LandlordBank in storage.
     *
     * @param  int              $id
     * @param UpdateLandlordBankRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLandlordBankRequest $request)
    {
        $landlordBank = $this->landlordBankRepository->findWithoutFail($id);

        if (empty($landlordBank)) {
            Flash::error('Landlord Bank not found');

            return redirect(route('landlordBanks.index'));
        }

        $landlordBank = $this->landlordBankRepository->update($request->all(), $id);

        Flash::success('Landlord Bank updated successfully.');

        return redirect(route('landlordBanks.index'));
    }

    /**
     * Remove the specified LandlordBank from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $landlordBank = $this->landlordBankRepository->findWithoutFail($id);

        if (empty($landlordBank)) {
            Flash::error('Landlord Bank not found');

            return redirect(route('landlordBanks.index'));
        }

        $this->landlordBankRepository->delete($id);

        Flash::success('Landlord Bank deleted successfully.');

        return redirect(route('landlordBanks.index'));
    }

    public function getLandBanks($id){
        return response()->json(LandlordBank::where('landlord_id',$id)->get());
    }
}

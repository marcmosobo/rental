<?php

namespace App\Http\Controllers;

use App\DataTables\LandlordRemittanceDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLandlordRemittanceRequest;
use App\Http\Requests\UpdateLandlordRemittanceRequest;
use App\Models\Masterfile;
use App\Repositories\LandlordRemittanceRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

class LandlordRemittanceController extends AppBaseController
{
    /** @var  LandlordRemittanceRepository */
    private $landlordRemittanceRepository;

    public function __construct(LandlordRemittanceRepository $landlordRemittanceRepo)
    {
        $this->middleware('auth');
        $this->landlordRemittanceRepository = $landlordRemittanceRepo;
    }

    /**
     * Display a listing of the LandlordRemittance.
     *
     * @param LandlordRemittanceDataTable $landlordRemittanceDataTable
     * @return Response
     */
    public function index(LandlordRemittanceDataTable $landlordRemittanceDataTable)
    {
        return $landlordRemittanceDataTable->render('landlord_remittances.index',[
            'landlords' => Masterfile::where('b_role',landlord)->get()
        ]);
    }

    /**
     * Show the form for creating a new LandlordRemittance.
     *
     * @return Response
     */
    public function create()
    {
        return view('landlord_remittances.create');
    }

    /**
     * Store a newly created LandlordRemittance in storage.
     *
     * @param CreateLandlordRemittanceRequest $request
     *
     * @return Response
     */
    public function store(CreateLandlordRemittanceRequest $request)
    {
        $input = $request->all();
        $input['remitted_by'] = Auth::user()->mf_id;

        $landlordRemittance = $this->landlordRemittanceRepository->create($input);

        Flash::success('Landlord Remittance saved successfully.');

        return redirect(route('landlordRemittances.index'));
    }

    /**
     * Display the specified LandlordRemittance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)

    {
        $landlordRemittance = $this->landlordRemittanceRepository->findWithoutFail($id);

        if (empty($landlordRemittance)) {
            Flash::error('Landlord Remittance not found');

            return redirect(route('landlordRemittances.index'));
        }

        return response()->json($landlordRemittance);
    }
    /**
     * Show the form for editing the specified LandlordRemittance.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $landlordRemittance = $this->landlordRemittanceRepository->findWithoutFail($id);

        if (empty($landlordRemittance)) {
            Flash::error('Landlord Remittance not found');

            return redirect(route('landlordRemittances.index'));
        }

        return view('landlord_remittances.edit')->with('landlordRemittance', $landlordRemittance);
    }

    /**
     * Update the specified LandlordRemittance in storage.
     *
     * @param  int              $id
     * @param UpdateLandlordRemittanceRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLandlordRemittanceRequest $request)
    {
        $landlordRemittance = $this->landlordRemittanceRepository->findWithoutFail($id);

        if (empty($landlordRemittance)) {
            Flash::error('Landlord Remittance not found');

            return redirect(route('landlordRemittances.index'));
        }

        $landlordRemittance = $this->landlordRemittanceRepository->update($request->all(), $id);

        Flash::success('Landlord Remittance updated successfully.');

        return redirect(route('landlordRemittances.index'));
    }

    /**
     * Remove the specified LandlordRemittance from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $landlordRemittance = $this->landlordRemittanceRepository->findWithoutFail($id);

        if (empty($landlordRemittance)) {
            Flash::error('Landlord Remittance not found');

            return redirect(route('landlordRemittances.index'));
        }

        $this->landlordRemittanceRepository->delete($id);

        Flash::success('Landlord Remittance deleted successfully.');

        return redirect(route('landlordRemittances.index'));
    }
}

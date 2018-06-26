<?php

namespace App\Http\Controllers;

use App\DataTables\LandlordSettlementDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateLandlordSettlementRequest;
use App\Http\Requests\UpdateLandlordSettlementRequest;
use App\Repositories\LandlordSettlementRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class LandlordSettlementController extends AppBaseController
{
    /** @var  LandlordSettlementRepository */
    private $landlordSettlementRepository;

    public function __construct(LandlordSettlementRepository $landlordSettlementRepo)
    {
        $this->landlordSettlementRepository = $landlordSettlementRepo;
    }

    /**
     * Display a listing of the LandlordSettlement.
     *
     * @param LandlordSettlementDataTable $landlordSettlementDataTable
     * @return Response
     */
    public function index(LandlordSettlementDataTable $landlordSettlementDataTable)
    {
        return $landlordSettlementDataTable->render('landlord_settlements.index');
    }

    /**
     * Show the form for creating a new LandlordSettlement.
     *
     * @return Response
     */
    public function create()
    {
        return view('landlord_settlements.create');
    }

    /**
     * Store a newly created LandlordSettlement in storage.
     *
     * @param CreateLandlordSettlementRequest $request
     *
     * @return Response
     */
    public function store(CreateLandlordSettlementRequest $request)
    {
        $input = $request->all();

        $landlordSettlement = $this->landlordSettlementRepository->create($input);

        Flash::success('Landlord Settlement saved successfully.');

        return redirect(route('landlordSettlements.index'));
    }

    /**
     * Display the specified LandlordSettlement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $landlordSettlement = $this->landlordSettlementRepository->findWithoutFail($id);

        if (empty($landlordSettlement)) {
            Flash::error('Landlord Settlement not found');

            return redirect(route('landlordSettlements.index'));
        }

        return view('landlord_settlements.show')->with('landlordSettlement', $landlordSettlement);
    }

    /**
     * Show the form for editing the specified LandlordSettlement.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $landlordSettlement = $this->landlordSettlementRepository->findWithoutFail($id);

        if (empty($landlordSettlement)) {
            Flash::error('Landlord Settlement not found');

            return redirect(route('landlordSettlements.index'));
        }

        return view('landlord_settlements.edit')->with('landlordSettlement', $landlordSettlement);
    }

    /**
     * Update the specified LandlordSettlement in storage.
     *
     * @param  int              $id
     * @param UpdateLandlordSettlementRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateLandlordSettlementRequest $request)
    {
        $landlordSettlement = $this->landlordSettlementRepository->findWithoutFail($id);

        if (empty($landlordSettlement)) {
            Flash::error('Landlord Settlement not found');

            return redirect(route('landlordSettlements.index'));
        }

        $landlordSettlement = $this->landlordSettlementRepository->update($request->all(), $id);

        Flash::success('Landlord Settlement updated successfully.');

        return redirect(route('landlordSettlements.index'));
    }

    /**
     * Remove the specified LandlordSettlement from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $landlordSettlement = $this->landlordSettlementRepository->findWithoutFail($id);

        if (empty($landlordSettlement)) {
            Flash::error('Landlord Settlement not found');

            return redirect(route('landlordSettlements.index'));
        }

        $this->landlordSettlementRepository->delete($id);

        Flash::success('Landlord Settlement deleted successfully.');

        return redirect(route('landlordSettlements.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\DataTables\TerminatedLeaseDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateTerminatedLeaseRequest;
use App\Http\Requests\UpdateTerminatedLeaseRequest;
use App\Repositories\TerminatedLeaseRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class TerminatedLeaseController extends AppBaseController
{
    /** @var  TerminatedLeaseRepository */
    private $terminatedLeaseRepository;

    public function __construct(TerminatedLeaseRepository $terminatedLeaseRepo)
    {
        $this->terminatedLeaseRepository = $terminatedLeaseRepo;
    }

    /**
     * Display a listing of the TerminatedLease.
     *
     * @param TerminatedLeaseDataTable $terminatedLeaseDataTable
     * @return Response
     */
    public function index(TerminatedLeaseDataTable $terminatedLeaseDataTable)
    {
        return $terminatedLeaseDataTable->render('terminated_leases.index');
    }

    /**
     * Show the form for creating a new TerminatedLease.
     *
     * @return Response
     */
    public function create()
    {
        return view('terminated_leases.create');
    }

    /**
     * Store a newly created TerminatedLease in storage.
     *
     * @param CreateTerminatedLeaseRequest $request
     *
     * @return Response
     */
    public function store(CreateTerminatedLeaseRequest $request)
    {
        $input = $request->all();

        $terminatedLease = $this->terminatedLeaseRepository->create($input);

        Flash::success('Terminated Lease saved successfully.');

        return redirect(route('terminatedLeases.index'));
    }

    /**
     * Display the specified TerminatedLease.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $terminatedLease = $this->terminatedLeaseRepository->findWithoutFail($id);

        if (empty($terminatedLease)) {
            Flash::error('Terminated Lease not found');

            return redirect(route('terminatedLeases.index'));
        }

        return view('terminated_leases.show')->with('terminatedLease', $terminatedLease);
    }

    /**
     * Show the form for editing the specified TerminatedLease.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $terminatedLease = $this->terminatedLeaseRepository->findWithoutFail($id);

        if (empty($terminatedLease)) {
            Flash::error('Terminated Lease not found');

            return redirect(route('terminatedLeases.index'));
        }

        return view('terminated_leases.edit')->with('terminatedLease', $terminatedLease);
    }

    /**
     * Update the specified TerminatedLease in storage.
     *
     * @param  int              $id
     * @param UpdateTerminatedLeaseRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateTerminatedLeaseRequest $request)
    {
        $terminatedLease = $this->terminatedLeaseRepository->findWithoutFail($id);

        if (empty($terminatedLease)) {
            Flash::error('Terminated Lease not found');

            return redirect(route('terminatedLeases.index'));
        }

        $terminatedLease = $this->terminatedLeaseRepository->update($request->all(), $id);

        Flash::success('Terminated Lease updated successfully.');

        return redirect(route('terminatedLeases.index'));
    }

    /**
     * Remove the specified TerminatedLease from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $terminatedLease = $this->terminatedLeaseRepository->findWithoutFail($id);

        if (empty($terminatedLease)) {
            Flash::error('Terminated Lease not found');

            return redirect(route('terminatedLeases.index'));
        }

        $this->terminatedLeaseRepository->delete($id);

        Flash::success('Terminated Lease deleted successfully.');

        return redirect(route('terminatedLeases.index'));
    }
}

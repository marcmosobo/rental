<?php

namespace App\Http\Controllers;

use App\DataTables\OfficeRevenueDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateOfficeRevenueRequest;
use App\Http\Requests\UpdateOfficeRevenueRequest;
use App\Models\OfficeExpenditure;
use App\Repositories\OfficeRevenueRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

class OfficeRevenueController extends AppBaseController
{
    /** @var  OfficeRevenueRepository */
    private $officeRevenueRepository;

    public function __construct(OfficeRevenueRepository $officeRevenueRepo)
    {
        $this->middleware('auth');
        $this->officeRevenueRepository = $officeRevenueRepo;
    }

    /**
     * Display a listing of the OfficeRevenue.
     *
     * @param OfficeRevenueDataTable $officeRevenueDataTable
     * @return Response
     */
    public function index(OfficeRevenueDataTable $officeRevenueDataTable)
    {
        return $officeRevenueDataTable->render('office_revenues.index',[
            'expenses'=>OfficeExpenditure::all()
        ]);
    }

    /**
     * Show the form for creating a new OfficeRevenue.
     *
     * @return Response
     */
    public function create()
    {
        return view('office_revenues.create');
    }

    /**
     * Store a newly created OfficeRevenue in storage.
     *
     * @param CreateOfficeRevenueRequest $request
     *
     * @return Response
     */
    public function store(CreateOfficeRevenueRequest $request)
    {
        $input = $request->all();

        $input['created_by'] = Auth::user()->mf_id;
        $input['transaction_type'] = credit;

        $officeRevenue = $this->officeRevenueRepository->create($input);

        Flash::success('Office Revenue saved successfully.');

        return redirect(route('officeRevenues.index'));
    }

    /**
     * Display the specified OfficeRevenue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $officeRevenue = $this->officeRevenueRepository->findWithoutFail($id);

        if (empty($officeRevenue)) {
            Flash::error('Office Revenue not found');

            return redirect(route('officeRevenues.index'));
        }

        return response()->json($officeRevenue);
    }

    /**
     * Show the form for editing the specified OfficeRevenue.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $officeRevenue = $this->officeRevenueRepository->findWithoutFail($id);

        if (empty($officeRevenue)) {
            Flash::error('Office Revenue not found');

            return redirect(route('officeRevenues.index'));
        }

        return view('office_revenues.edit')->with('officeRevenue', $officeRevenue);
    }

    /**
     * Update the specified OfficeRevenue in storage.
     *
     * @param  int              $id
     * @param UpdateOfficeRevenueRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOfficeRevenueRequest $request)
    {
        $officeRevenue = $this->officeRevenueRepository->findWithoutFail($id);

        if (empty($officeRevenue)) {
            Flash::error('Office Revenue not found');

            return redirect(route('officeRevenues.index'));
        }

        $officeRevenue = $this->officeRevenueRepository->update($request->all(), $id);

        Flash::success('Office Revenue updated successfully.');

        return redirect(route('officeRevenues.index'));
    }

    /**
     * Remove the specified OfficeRevenue from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $officeRevenue = $this->officeRevenueRepository->findWithoutFail($id);

        if (empty($officeRevenue)) {
            Flash::error('Office Revenue not found');

            return redirect(route('officeRevenues.index'));
        }

        $this->officeRevenueRepository->delete($id);

        Flash::success('Office Revenue deleted successfully.');

        return redirect(route('officeRevenues.index'));
    }
}

<?php

namespace App\Http\Controllers;

use App\DataTables\ServiceOptionDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateServiceOptionRequest;
use App\Http\Requests\UpdateServiceOptionRequest;
use App\Repositories\ServiceOptionRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Auth;
use Response;

class ServiceOptionController extends AppBaseController
{
    /** @var  ServiceOptionRepository */
    private $serviceOptionRepository;

    public function __construct(ServiceOptionRepository $serviceOptionRepo)
    {
        $this->middleware('auth');
        $this->serviceOptionRepository = $serviceOptionRepo;
    }

    /**
     * Display a listing of the ServiceOption.
     *
     * @param ServiceOptionDataTable $serviceOptionDataTable
     * @return Response
     */
    public function index(ServiceOptionDataTable $serviceOptionDataTable)
    {
        return $serviceOptionDataTable->render('service_options.index');
    }

    /**
     * Show the form for creating a new ServiceOption.
     *
     * @return Response
     */
    public function create()
    {
        return view('service_options.create');
    }

    /**
     * Store a newly created ServiceOption in storage.
     *
     * @param CreateServiceOptionRequest $request
     *
     * @return Response
     */
    public function store(CreateServiceOptionRequest $request)
    {
        $this->validate($request,[
            'name'=>'required|unique:service_options,name'
        ]);
        $input = $request->all();
        $input['created_by'] = Auth::user()->mf_id;
        $input['client_id']= Auth::user()->client_id;

        $serviceOption = $this->serviceOptionRepository->create($input);

        Flash::success('Service Option saved successfully.');

        return redirect(route('serviceOptions.index'));
    }

    /**
     * Display the specified ServiceOption.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $serviceOption = $this->serviceOptionRepository->findWithoutFail($id);

        if (empty($serviceOption)) {
            Flash::error('Service Option not found');

            return redirect(route('serviceOptions.index'));
        }

        return response()->json($serviceOption);
    }

    /**
     * Show the form for editing the specified ServiceOption.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $serviceOption = $this->serviceOptionRepository->findWithoutFail($id);

        if (empty($serviceOption)) {
            Flash::error('Service Option not found');

            return redirect(route('serviceOptions.index'));
        }

        return view('service_options.edit')->with('serviceOption', $serviceOption);
    }

    /**
     * Update the specified ServiceOption in storage.
     *
     * @param  int              $id
     * @param UpdateServiceOptionRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateServiceOptionRequest $request)
    {
        $serviceOption = $this->serviceOptionRepository->findWithoutFail($id);

        if (empty($serviceOption)) {
            Flash::error('Service Option not found');

            return redirect(route('serviceOptions.index'));
        }

        $serviceOption = $this->serviceOptionRepository->update($request->all(), $id);

        Flash::success('Service Option updated successfully.');

        return redirect(route('serviceOptions.index'));
    }

    /**
     * Remove the specified ServiceOption from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $serviceOption = $this->serviceOptionRepository->findWithoutFail($id);

        if (empty($serviceOption)) {
            Flash::error('Service Option not found');

            return redirect(route('serviceOptions.index'));
        }

        $this->serviceOptionRepository->delete($id);

        Flash::success('Service Option deleted successfully.');

        return redirect(route('serviceOptions.index'));
    }
}

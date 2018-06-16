<?php

namespace App\Http\Controllers;

use App\DataTables\ReminderDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateReminderRequest;
use App\Http\Requests\UpdateReminderRequest;
use App\Repositories\ReminderRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class ReminderController extends AppBaseController
{
    /** @var  ReminderRepository */
    private $reminderRepository;

    public function __construct(ReminderRepository $reminderRepo)
    {
        $this->middleware('auth');
        $this->reminderRepository = $reminderRepo;
    }

    /**
     * Display a listing of the Reminder.
     *
     * @param ReminderDataTable $reminderDataTable
     * @return Response
     */
    public function index(ReminderDataTable $reminderDataTable)
    {
        return $reminderDataTable->render('reminders.index');
    }

    /**
     * Show the form for creating a new Reminder.
     *
     * @return Response
     */
    public function create()
    {
        return view('reminders.create');
    }

    /**
     * Store a newly created Reminder in storage.
     *
     * @param CreateReminderRequest $request
     *
     * @return Response
     */
    public function store(CreateReminderRequest $request)
    {
        $input = $request->all();

        $reminder = $this->reminderRepository->create($input);

        Flash::success('Reminder saved successfully.');

        return redirect(route('reminders.index'));
    }

    /**
     * Display the specified Reminder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $reminder = $this->reminderRepository->findWithoutFail($id);

        if (empty($reminder)) {
            Flash::error('Reminder not found');

            return redirect(route('reminders.index'));
        }

        return response()->json($reminder);
    }

    /**
     * Show the form for editing the specified Reminder.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $reminder = $this->reminderRepository->findWithoutFail($id);

        if (empty($reminder)) {
            Flash::error('Reminder not found');

            return redirect(route('reminders.index'));
        }

        return view('reminders.edit')->with('reminder', $reminder);
    }

    /**
     * Update the specified Reminder in storage.
     *
     * @param  int              $id
     * @param UpdateReminderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateReminderRequest $request)
    {
        $reminder = $this->reminderRepository->findWithoutFail($id);

        if (empty($reminder)) {
            Flash::error('Reminder not found');

            return redirect(route('reminders.index'));
        }

        $reminder = $this->reminderRepository->update($request->all(), $id);

        Flash::success('Reminder updated successfully.');

        return redirect(route('reminders.index'));
    }

    /**
     * Remove the specified Reminder from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $reminder = $this->reminderRepository->findWithoutFail($id);

        if (empty($reminder)) {
            Flash::error('Reminder not found');

            return redirect(route('reminders.index'));
        }

        $this->reminderRepository->delete($id);

        Flash::success('Reminder deleted successfully.');

        return redirect(route('reminders.index'));
    }
}

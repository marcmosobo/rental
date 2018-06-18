<?php

namespace App\Http\Controllers;

use App\DataTables\EventMessageDataTable;
use App\Http\Requests;
use App\Http\Requests\CreateEventMessageRequest;
use App\Http\Requests\UpdateEventMessageRequest;
use App\Repositories\EventMessageRepository;
use Flash;
use App\Http\Controllers\AppBaseController;
use Response;

class EventMessageController extends AppBaseController
{
    /** @var  EventMessageRepository */
    private $eventMessageRepository;

    public function __construct(EventMessageRepository $eventMessageRepo)
    {
        $this->middleware('auth');
        $this->eventMessageRepository = $eventMessageRepo;
    }

    /**
     * Display a listing of the EventMessage.
     *
     * @param EventMessageDataTable $eventMessageDataTable
     * @return Response
     */
    public function index(EventMessageDataTable $eventMessageDataTable)
    {
        return $eventMessageDataTable->render('event_messages.index');
    }

    /**
     * Show the form for creating a new EventMessage.
     *
     * @return Response
     */
    public function create()
    {
        return view('event_messages.create');
    }

    /**
     * Store a newly created EventMessage in storage.
     *
     * @param CreateEventMessageRequest $request
     *
     * @return Response
     */
    public function store(CreateEventMessageRequest $request)
    {
        $input = $request->all();

        $eventMessage = $this->eventMessageRepository->create($input);

        Flash::success('Event Message saved successfully.');

        return redirect(route('eventMessages.index'));
    }

    /**
     * Display the specified EventMessage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $eventMessage = $this->eventMessageRepository->findWithoutFail($id);

        if (empty($eventMessage)) {
            Flash::error('Event Message not found');

            return redirect(route('eventMessages.index'));
        }

        return response()->json($eventMessage);
    }

    /**
     * Show the form for editing the specified EventMessage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $eventMessage = $this->eventMessageRepository->findWithoutFail($id);

        if (empty($eventMessage)) {
            Flash::error('Event Message not found');

            return redirect(route('eventMessages.index'));
        }

        return view('event_messages.edit')->with('eventMessage', $eventMessage);
    }

    /**
     * Update the specified EventMessage in storage.
     *
     * @param  int              $id
     * @param UpdateEventMessageRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateEventMessageRequest $request)
    {
        $eventMessage = $this->eventMessageRepository->findWithoutFail($id);

        if (empty($eventMessage)) {
            Flash::error('Event Message not found');

            return redirect(route('eventMessages.index'));
        }

        $eventMessage = $this->eventMessageRepository->update($request->all(), $id);

        Flash::success('Event Message updated successfully.');

        return redirect(route('eventMessages.index'));
    }

    /**
     * Remove the specified EventMessage from storage.
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $eventMessage = $this->eventMessageRepository->findWithoutFail($id);

        if (empty($eventMessage)) {
            Flash::error('Event Message not found');

            return redirect(route('eventMessages.index'));
        }

        if($eventMessage->code== lease_creation){
            Flash::error('Cannot delete this message since its being used by the system.');
        }else{
            $this->eventMessageRepository->delete($id);
            Flash::success('Event Message deleted successfully.');
        }



        return redirect(route('eventMessages.index'));
    }
}

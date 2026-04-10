<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTicketRequest;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->query('id');
        // get all tickets
        $ticket = Ticket::find($id);
        if ( is_null( $ticket ) || is_null($id) ) {
            return "ID was not provided or ticket with such id does not exist";
        }
        $customer = $ticket->customer;
        return response()->json([
            $ticket->getAttributes(),
            'customer' => $customer
        ]);
    }

    public function store(StoreTicketRequest $request)
    {
        $ticket = DB::transaction(function () use ($request) {
            $ticket = $this->ticketService->create($request->validated());

            if ( $request->hasFile('files') ) {
                foreach ($request->file('files') as $file) {
                    $ticket->addMedia($file)->toMediaCollection('attachments');
                }
            }

            return $ticket;
        });

        return response()->json([
            'id'     => $ticket->id,
            'status' => $ticket->status,
            'files'  => $ticket->getMedia('attachments')->map(fn ($file) => [
                'url'  => $file->getUrl(),
                'name' => $file->file_name,
            ]),
        ]);
    }
}

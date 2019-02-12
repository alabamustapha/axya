<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageRequest;
use App\Message;
use App\Appointment;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Active + Pending Appointments.
        $activeAppointments = auth()->user()->appointments()
                                     // ->hasActiveCorrespondence()
                                     ->paginate(10)
                                     ;

        // Inactive + Past Successful Appointments.
        $inactiveAppointments = auth()->user()->appointments()
                                     // ->hasInactiveCorrespondence()
                                     ->paginate(5)
                                     ;

        switch (request()->id) {

            case request()->id: 
                $messages = Message::with(['messageable'])
                         ->where('messageable_id', request()->id)
                         ->where('messageable_type', 'App\Appointment')
                         ->oldest()
                         ->paginate(25)
                         ; 
                break;
            default:
                if ($activeAppointments->count()) {
                    $messages = Message::with(['messageable'])
                         ->where('user_id', auth()->id())
                         ->where('messageable_type', 'App\Appointment')
                         ->latest()
                         ->first()
                         ;
                }
                break;
        }

        if (request()->id) {
            $appointment = Appointment::find(request()->id);
        }
        // dd($appointment->id);

        // return view('appointments.index', compact('user','appointments'));
        return view('messages.index', compact('messages', 'appointment', 'activeAppointments', 'inactiveAppointments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request)
    {dd($request->all());
        $this->authorize('create', Message::class);        

        $request->merge(['user_id' => auth()->id()]);
        
        $message = Message::create($request->all());

        if ($message) {
            $msg = 'Message added successfully';

            if (request()->expectsJson()) {
                return response(['status' => $msg]);
            }
        }

        return back();//redirect()->route('messages.index', ['id' => $message->messageable->id]);
        return redirect()->route('appointments.show', $message->messageable);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);

        $message->delete();
        $msg = 'Message deleted successfully';

        // if ($message->delete()) {
        //     if ($request->expectsJson()) {
        //         return response(['message' => $msg]);
        //     }
        // }

        flash($msg)->info();
        return redirect()->route('appointments.show', $message->messageable);
    }
}

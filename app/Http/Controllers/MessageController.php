<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\Http\Requests\MessageRequest;
use App\Message;
use App\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        // $this->middleware('patient');
        $this->middleware('doctor')->only('drindex');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Appointment $appointment)
    {
        // Active + Pending Appointments.
        $activeAppointments = $user->appointments()
                                     // ->hasActiveCorrespondence()
                                     ->paginate(10)
                                     ;

        // Inactive + Past Successful Appointments.
        $inactiveAppointments = $user->appointments()
                                     // ->hasInactiveCorrespondence()
                                     ->paginate(5)
                                     ;
        
        $messages = Cache::rememberForever('messages.paginate', function() use($appointment) {
            return $appointment->messages()
                 ->oldest()
                 ->paginate(50)
                 ; 
            });
        // dd(Cache::has('messages.paginate'));
        return view('messages.index', compact('messages', 'appointment', 'activeAppointments', 'inactiveAppointments'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function drindex(Doctor $doctor, Appointment $appointment)
    {
        // Active + Pending Appointments.
        $activeAppointments = $doctor->appointments()
                                     // ->hasActiveCorrespondence()
                                     ->paginate(10)
                                     ;

        // Inactive + Past Successful Appointments.
        $inactiveAppointments = $doctor->appointments()
                                     // ->hasInactiveCorrespondence()
                                     ->paginate(5)
                                     ;
        
        $messages = Cache::rememberForever('messages.paginate', function() use($appointment) {
            return $appointment->messages()
                 ->oldest()
                 ->paginate(50)
                 ;
            }); 

        // dd($messages, Cache::has('messages.paginate'));
        return view('messages.index', compact('doctor', 'messages', 'appointment', 'activeAppointments', 'inactiveAppointments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request, Appointment $appointment)
    {
        $this->authorize('create', Message::class);        

        $request->merge(['user_id' => auth()->id()]);
        
        // $message = Message::create($request->all());
        $message = $appointment->messages()->create($request->all());

        if ($message) {
            $msg = 'Message submitted successfully';

            if (request()->expectsJson()) {
                return response(['status' => $msg]);
            }
        }
        
        flash($msg)->success();
        return back();
        return redirect()->route('messages.index', [ 'user' => auth()->user(), 'appointment' => $appointment]);
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

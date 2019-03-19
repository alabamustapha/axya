<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\User;
use App\Http\Requests\AppointmentRequest;
use App\Http\Requests\AppointmentUpdateRequest;
use App\Notifications\Applications\ApplicationReceivedNotification;
use App\Notifications\Appointments\AppointmentBookedNotification;
use App\Traits\TimeScheduleTrait;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    use TimeScheduleTrait;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('patient')->only('index');
        $this->middleware('doctor')->only('drindex');
        // $this->middleware('admin')->only('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $appointments = Appointment::with(['doctor','doctor.specialty'])->where('user_id', $user->id)
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        $active_appointments = $user->appointments()
                 ->hasActiveCorrespondence()
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        $upcoming_appointments = $user->appointmentsAwaitingAppointmentTime()
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        $pending_appointments = Appointment::with(['doctor','doctor.specialty'])
                 ->where('user_id', $user->id)
                 ->whereIn('status', ['0','2'])
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        $past_appointments = $user->appointmentsCompleted()
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        return view('appointments.index', 
            compact(
                'user',
                'appointments',
                'active_appointments',
                'upcoming_appointments', // Paid for, awaiting schedule time
                'pending_appointments',  // Still processing
                'past_appointments'      // Done!
            ));
    }
    
    /**
     * Display a listing of the appointments resource for a doctor.
     *
     * @return \Illuminate\Http\Response
     */
    public function drindex(Doctor $doctor)
    {
        $appointments = Appointment::where('doctor_id', $doctor->id)
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        $active_appointments = $doctor->appointments()
                 ->hasActiveCorrespondence()
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        $upcoming_appointments = $doctor->appointmentsAwaitingAppointmentTime()
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        $pending_appointments = Appointment::where('doctor_id', $doctor->id)
                 ->whereIn('status', ['0','2'])
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        $past_appointments = $doctor->appointmentsCompleted()
                 ->orderBy('day', 'desc')
                 ->paginate(25)
                 ;
        return view('appointments.index', compact(
                'doctor',
                'appointments',
                'active_appointments',
                'upcoming_appointments', // Paid for, awaiting schedule time
                'pending_appointments',  // Still processing
                'past_appointments'      // Done!
            ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AppointmentRequest $request)
    {
        $this->authorize('create', Appointment::class);

        $this->formatHourTo2400($request);
        // dd($request->all());//,

        $appointment = Appointment::create($request->all());

        if ($appointment){

            auth()->user()->notify(new AppointmentBookedNotification(auth()->user(), $appointment));

            $message = 'Appointment created successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            flash($message)->success();
            return redirect()->route('appointments.index', $appointment->user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $this->authorize('edit', $appointment);

        $messages = $appointment->messages()->get();
        $review   = $appointment->review()->first();

        return view('appointments.show', compact('appointment','messages','review'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentUpdateRequest $request, Appointment $appointment)
    {
        $this->authorize('edit', $appointment);

        $this->formatHourTo2400($request);

        // $request->merge(['user_id' => auth()->id()]);

        $appointment->status > '0' 
            ? $appointment->update($request->only(['description', 'illness_duration', 'illness_history'])) 
            : $appointment->update($request->all())
            ;

        // if ($appointment->update($request->all())){
            $message = 'Appointment updated successfully.';

            flash($message)->success();
            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            return back();
            return redirect()->route('appointments.show', $appointment);
        // }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $this->authorize('delete', $appointment);

        $appointment->delete();
        $message = 'Appointment deleted successfully';

        // if ($appointment->delete()) {
        //     if ($request->expectsJson()) {
        //         return response(['message' => $message]);
        //     }
        // }

        flash($message)->info();
        return redirect()->route('appointments.index');
    }
}

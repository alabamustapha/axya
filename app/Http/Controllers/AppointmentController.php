<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Http\Requests\AppointmentRequest;
use App\Notifications\Applications\ApplicationReceivedNotification;
use App\Notifications\Appointments\AppointmentBookedNotification;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        // $this->middleware('doctor');
        // $this->middleware('admin')->only('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $appointments = auth()->user()->appointments()->orderBy('day', 'desc')->paginate(25);

        // return view('appointments.index', compact('appointments'));

        $user = auth()->user();

        switch (request()->status) {
            case 'awaiting-confirmation': // 0.: New appointment, awaiting doctor's confirmation.
                $appointments = 
                    $user->appointmentsAwaitingConfirmation()
                    // $user->appointments()->where('status', '0')
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ; 
            case 'success': // 1. Appointment/Consultation completed successfully.
                $appointments = 
                    $user->appointmentsCompleted()
                    // $user->appointments()->where('status', '1')
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'confirmed': // 2. Confirmed, awaiting fees payment
                $appointments = 
                    $user->appointmentsConfirmed()
                    // $user->appointments()->where('status', '2')
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'schedule-change-suggestion': // 3. Schedule change suggestion by doctor
                $appointments = 
                    $user->appointmentsScheduleChangeSuggestion()
                    // $user->appointments()->where('status', '3')
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'rejected': // 4. Rejected by doctor!
                $appointments = 
                    $user->appointmentsRejected()
                    // $user->appointments()->where('status', '4')
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'other-doctor-recommendation': // 5. Another doctor recommended.
                $appointments = 
                    $user->appointmentsOtherDoctorRecommendation()
                    // $user->appointments()->where('status', '5')
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                     ;
                break;
            case 'cancelled': // 6. Cancelled by patient
                $appointments = 
                    $user->appointmentsCancelled()
                    // $user->appointments()->where('status', '6')
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'uncompleted': // All uncompleted Appointments.
                $appointments = 
                    $user->appointmentsUncompleted()
                    // $user->appointments()->where('status', '!=', '1')
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'awaiting-appointment-time': // Confirmed, payment made, awaiting appointment time.
                $appointments = 
                    $user->appointmentsAwaitingAppointmentTime()
                    // $user->appointments()->where('status', '!=', '1')
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            default:
                $appointments = $user->appointments()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
        }
        return view('appointments.index', compact('appointments'));
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

        $request->merge(['user_id' => auth()->id()]);

        $appointment = Appointment::create($request->all());

        if ($appointment){

            auth()->user()->notify(new AppointmentBookedNotification(auth()->user(), $appointment));

            $message = 'Appointment created successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            flash($message)->success();
            return redirect()->route('appointments.index');
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

        return view('appointments.show', compact('appointment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(AppointmentRequest $request, Appointment $appointment)
    {
        // $this->authorize('edit', $appointment);

        $request->merge(['user_id' => auth()->id()]);

        if ($appointment->update($request->all())){
            $message = 'Appointment updated successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            flash($message)->success();
            return redirect()->route('appointments.show', $appointment);
        }

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

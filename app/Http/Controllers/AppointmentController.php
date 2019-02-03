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
        // $user = auth()->user();

        switch (request()->status) {
            case 'awaiting-confirmation': // 0.: New appointment, awaiting doctor's confirmation.
                $appointments = $user->appointmentsAwaitingConfirmation()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ; 
            case 'success': // 1. Appointment/Consultation completed successfully.
                $appointments = $user->appointmentsCompleted()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'confirmed': // 2. Confirmed, awaiting fees payment
                $appointments = $user->appointmentsConfirmed()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'schedule-change-suggestion': // 3. Schedule change suggestion by doctor
                $appointments = $user->appointmentsScheduleChangeSuggestion()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'rejected': // 4. Rejected by doctor!
                $appointments = $user->appointmentsRejected()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'other-doctor-recommendation': // 5. Another doctor recommended.
                $appointments = $user->appointmentsOtherDoctorRecommendation()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                     ;
                break;
            case 'cancelled': // 6. Cancelled by patient
                $appointments = $user->appointmentsCancelled()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'uncompleted': // All uncompleted Appointments.
                $appointments = $user->appointmentsUncompleted()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'awaiting-appointment-time': // Confirmed, payment made, awaiting appointment time.
                $appointments = $user->appointmentsAwaitingAppointmentTime()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            default:
                $appointments // = $user->appointments()
                              = Appointment::with(['doctor','doctor.specialty'])->where('user_id', $user->id)
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
        }

        return view('appointments.index', compact('user','appointments'));
    }
    
    /**
     * Display a listing of the appointments resource for a doctor.
     *
     * @return \Illuminate\Http\Response
     */
    public function drindex(Doctor $doctor)
    {
        // $doctor = Doctor::find(auth()->id());

        switch (request()->status) {
            case 'awaiting-confirmation': // 0.: New appointment, awaiting doctor's confirmation.
                $appointments = $doctor->appointmentsAwaitingConfirmation()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ; 
            case 'success': // 1. Appointment/Consultation completed successfully.
                $appointments = $doctor->appointmentsCompleted()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'confirmed': // 2. Confirmed, awaiting fees payment
                $appointments = $doctor->appointmentsConfirmed()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'schedule-change-suggestion': // 3. Schedule change suggestion by doctor
                $appointments = $doctor->appointmentsScheduleChangeSuggestion()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'rejected': // 4. Rejected by doctor!
                $appointments = $doctor->appointmentsRejected()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'other-doctor-recommendation': // 5. Another doctor recommended.
                $appointments = $doctor->appointmentsOtherDoctorRecommendation()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                     ;
                break;
            case 'cancelled': // 6. Cancelled by patient
                $appointments = $doctor->appointmentsCancelled()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'uncompleted': // All uncompleted Appointments.
                $appointments = $doctor->appointmentsUncompleted()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            case 'awaiting-appointment-time': // Confirmed, payment made, awaiting appointment time.
                $appointments = $doctor->appointmentsAwaitingAppointmentTime()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
            default:
                $appointments = $doctor->appointments()
                         ->orderBy('day', 'desc')
                         ->paginate(25)
                         ;
                break;
        }
        return view('appointments.index', compact('doctor','appointments'));
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
        // $this->authorize('edit', $appointment);

        $this->formatHourTo2400($request);

        // $request->merge(['user_id' => auth()->id()]);
        // dd($request->all());//,
        // dd($appointment->update($request->all()));

        if ($appointment->update($request->all())){
            $message = 'Appointment updated successfully.';

            flash($message)->success();
            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
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

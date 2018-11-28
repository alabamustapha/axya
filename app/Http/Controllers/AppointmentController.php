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
        $appointments = auth()->user()->appointments()->orderBy('day', 'desc')->paginate(25);

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

<?php

namespace App\Http\Controllers;

use App\Day;
use App\Doctor;
use App\Http\Requests\ScheduleRequest;
use App\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('schedules', 'index'); // Index is for testing
        $this->middleware('doctor')->except('schedules', 'index'); // Index is for testing
    }

    public function index()
    {
        return view('doctors.forms.schedules.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {
        $this->authorize('create', Schedule::class);        
        /*
            $schedule = Schedule::create($request->all());

            if ($schedule) {
                $message = 'Schedule added successfully';

                if (request()->expectsJson()) {
                    return response(['status' => $message]);
                }

                flash($message)->success();
            }

            return redirect()->route('doctors.show', $schedule->doctor);
        */


        /** -------------- The New Approaches -------------- */
        $doctor = Doctor::findOrFail($request->doctor_id);

        /** -------------- Serialization Save -------------- */
        $doctor->saveSerializedSchedules($request);
        // return $doctor->schedules();

        /** -------------- Normal DB Save ------------------ */
        $doctor->saveSchedules($request);

        $message = 'Schedule serialized and saved successfully';

        return response(['status' => $message], 200);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(ScheduleRequest $request, Schedule $schedule)
    {
        $this->authorize('update', $schedule);

        if ($schedule->update($request->all())) {
            $message = 'Schedule updated successfully';

            if (request()->expectsJson()) {
                return response(['status' => $message]);
            }

            flash($message)->success();
        }

        return redirect()->route('doctors.show', $schedule->doctor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        $this->authorize('delete', $schedule);

        if ($schedule->delete()) {
            $message = 'Schedule deleted successfully';

            if (request()->expectsJson()) {
                return response(['status' => $message]);
            }

            flash($message)->success();
        }

        return redirect()->route('doctors.show', $schedule->doctor);
    }

    /**
     * Loads Doctor schedules in "ScheduleBase.vue@showSchedules()".
     *
     * @param  \App\Doctor  $doctor->id
     * @param  \App\Day     $day->id
     * @return \Illuminate\Http\Collection
     */ 
    public function schedulesByDay(Request $request, $doctorId, $dayId)
    {
        $doctor    = Doctor::findOrFail($doctorId);

        $schedules = $doctor->schedules()->where('day_id', $dayId)->get();

        return $schedules;   
    }       

    public function serializedSchedulesByDay(Request $request, $doctorId, $dayId)
    {
        $doctor    = Doctor::findOrFail($doctorId);
        return $doctor->serializedSchedules()[$dayId];
    }
}

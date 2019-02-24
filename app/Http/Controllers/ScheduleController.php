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
        $this->middleware('auth')->except('index'); // Index is for testing
        $this->middleware('doctor')->except('index'); // Index is for testing
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
        
        $schedule = Schedule::create($request->all());

        if ($schedule) {
            $message = 'Schedule added successfully';

            if (request()->expectsJson()) {
                return response(['status' => $message]);
            }

            flash($message)->success();
        }

        return redirect()->route('doctors.show', $schedule->doctor);
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



    public function schedules(Request $request, $doctor, $day)
    {
        $doctor    = Doctor::findOrFail($request->doctor);

        $schedules = $doctor->schedules()->where('day_id', $day)->get();

        return $schedules;
    }
}

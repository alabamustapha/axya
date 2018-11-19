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
        $this->middleware('auth');
        $this->middleware('doctor');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ScheduleRequest $request)
    {dd($request->all());
        $this->authorize('create', Schedule::class);
        
        $schedule = Schedule::create($request->all());

        if ($schedule){
            flash('Schedule added successfully')->success();
        }

        return redirect()->route('doctors.show', $schedule->doctor);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function show(Schedule $schedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Schedule $schedule)
    {
        // $this->authorize('update', $schedule);

        $request->validate([
            'start_at'  => 'required|date_format:H:i:s',
            'end_at'    => 'required|date_format:H:i:s',
        ]);

        $schedule->update($request->all());
        return ['message' => 'Schedule update successful'];
        // if ($schedule->update($request->all())){
        //     flash('Schedule was updated successfully')->success();
        // }

        // return redirect()->route('doctors.show', $schedule->doctor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Schedule  $schedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(Schedule $schedule)
    {
        //
    }



    public function schedules(Request $request, $doctor, $day)
    {
        $doctor    = Doctor::findOrFail($request->doctor);

        $schedules = $doctor->schedules()->where('day_id', $day)->get();

        return $schedules;
    }
}

<?php

namespace App\Http\Controllers;

use App\Application;
use App\Doctor;
use App\Notifications\Applications\ApplicationAcceptedNotification;
use App\Specialty;
use App\Workplace;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
        $this->middleware('application')->only('create');
        $this->middleware('verified')->only('create','store');
        // $this->middleware('doctor')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = Specialty::all();

        return view('doctors.create', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Sort Appl data to appropriate tables.
        $appl = Application::whereUserId($request->user_id)->first();

        // Doctor data
        $doctor = new Doctor;
        $doctor->id           = $appl->user_id;
        $doctor->user_id      = $appl->user_id;
        $doctor->specialty_id = $appl->specialty_id;
        $doctor->first_appointment = $appl->first_appointment;
        $doctor->slug         = $appl->user->slug;
        $doctor->verified_at  = Carbon::now();
        $doctor->verified_by  = auth()->id();
        
        if ($doctor->save()) {
            // Add a new entry into doctor_specialty intermediate table;
            // $doctor->specialties()->sync($appl->specialty_id);
            $doctor->user->updateRegistrationStatus('accepted_not_subscribed');
        }

        // Workplace data
        $workplace = new Workplace;
        $workplace->doctor_id  = $appl->user_id;
        $workplace->name       = $appl->workplace;
        $workplace->address    = $appl->workplace_address;
        $workplace->start_date = $appl->workplace_start;
        $workplace->save();

        // // Document data
        // $document = new Document;
        // $document->medical_college    = $appl->medical_college;
        // $document->specialist_diploma = $appl->specialist_diploma;
        // $document->competences        = $appl->competences;
        // $document->malpraxis          = $appl->malpraxis;
        // $document->medical_college_expiry = $appl->medical_college_expiry;
        // $document->save();

        // Delete Appl
        
        if ($appl->delete()) {
            // Notify About Acceptance and Access to Doctor's Dashboard
            $appl->user->notify(new ApplicationAcceptedNotification($appl->user));

            flash('Application accepted, Doctor <b>'. $appl->user->name .'</b> registered successfully')->important()->info();
        }

        return redirect()->route('applications.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        $workplaces = $doctor->workplaces()
                             ->orderBy('end_date', 'desc')
                             ->get()
                             ;

        return view('doctors.show', compact('doctor','workplaces'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        // Admin and Doctor
    }
}

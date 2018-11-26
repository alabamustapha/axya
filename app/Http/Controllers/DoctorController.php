<?php

namespace App\Http\Controllers;

use App\Application;
use App\Doctor;
use App\Document;
use App\Notifications\Applications\ApplicationAcceptedNotification;
use App\Schedule;
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
        // $this->middleware('verified')->only('create','store');
        // $this->middleware('doctor')->except('index','show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::orderBy('slug')->paginate(25);

        return view('doctors.index', compact('doctors'));
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
            $doctor->user->updateApplicationStatus('accepted_not_subscribed');
        }

        // // Schedule data for 7 days of the week.
        // $days = ['Mon'...'Sun'];
        // foreach($days as $day){
        //     $schedule = new Schedule;
        //     $schedule->day  = $day;
        //     $schedule->save();
        // }

        // Workplace data
        $workplace = new Workplace;
        $workplace->doctor_id  = $appl->user_id;
        $workplace->name       = $appl->workplace;
        $workplace->address    = $appl->workplace_address;
        $workplace->start_date = $appl->workplace_start;
        $workplace->save();

        // // Document data
        // $document = new Document;
        if ($appl->medical_college){
            Document::create([
                'user_id'       => $appl->user_id,
                'name'          => 'Medical College Certificate',
                'description'   => 'Doctor professional document',
                'documentable_id'   => $appl->user_id,
                'documentable_type' => 'App\Doctor',
                'issued_date'   => null,
                'expiry_date'   => $appl->medical_college_expiry,
                'url'           => $appl->medical_college,
            ]);
        }
        if ($appl->specialist_diploma){
            Document::create([
                'user_id'       => $appl->user_id,
                'name'          => 'Specialist Diploma Certificate',
                'description'   => 'Doctor professional document',
                'documentable_id'   => $appl->user_id,
                'documentable_type' => 'App\Doctor',
                'issued_date'   => null,
                'expiry_date'   => null,
                'url'           => $appl->specialist_diploma,
            ]);
        }
        if ($appl->competences){
            Document::create([
                'user_id'       => $appl->user_id,
                'name'          => 'Competences Certificate',
                'description'   => 'Doctor professional document',
                'documentable_id'   => $appl->user_id,
                'documentable_type' => 'App\Doctor',
                'issued_date'   => null,
                'expiry_date'   => null,
                'url'           => $appl->competences,
            ]);
        }
        if ($appl->malpraxis){
            Document::create([
                'user_id'       => $appl->user_id,
                'name'          => 'Malpraxis Certificate',
                'description'   => 'Doctor professional document',
                'documentable_id'   => $appl->user_id,
                'documentable_type' => 'App\Doctor',
                'issued_date'   => null,
                'expiry_date'   => null,
                'url'           => $appl->malpraxis,
            ]);
        }

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
        // To be refactored by grouping:: $schedules = $doctor->schedules()->groupBy('day_id')->get();
        $sun_schedules = $doctor->schedules()->where('day_id', '1')->get();
        $mon_schedules = $doctor->schedules()->where('day_id', '2')->get();
        $tue_schedules = $doctor->schedules()->where('day_id', '3')->get();
        $wed_schedules = $doctor->schedules()->where('day_id', '4')->get();
        $thu_schedules = $doctor->schedules()->where('day_id', '5')->get();
        $fri_schedules = $doctor->schedules()->where('day_id', '6')->get();
        $sat_schedules = $doctor->schedules()->where('day_id', '7')->get();

        $certificates = $doctor->documents()
                             ->where('description', 'Doctor professional document')
                             ->orderBy('expiry_date', 'desc')
                             ->orderBy('name', 'desc')
                             ->get()
                             ;
        $workplaces = $doctor->workplaces()
                             ->orderBy('end_date', 'desc')
                             ->get()
                             ;

        return view('doctors.show', compact('doctor','workplaces','certificates',
            'sun_schedules',
            'mon_schedules',
            'tue_schedules',
            'wed_schedules',
            'thu_schedules',
            'fri_schedules',
            'sat_schedules'
        ));
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
        // Include Schedule here
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

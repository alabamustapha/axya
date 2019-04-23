<?php

namespace App\Http\Controllers;

use App\Application;
use App\Doctor;
use App\Region;
use App\Document;
use App\Notifications\Applications\ApplicationAcceptedNotification;
use App\Schedule;
use App\Specialty;
use App\Review;
use App\Workplace;
use Carbon\Carbon;
use App\Http\Requests\DoctorUpdateRequest;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index','show');
        $this->middleware('application')->only('create');
        $this->middleware('verified')->except('index','show');
        $this->middleware('doctor')->only('edit','update','destroy');
        $this->middleware('doctoradmin')->only('dashboard','patients');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard(Doctor $doctor)
    {

        return view('doctors.dashboard', compact('doctor','reviews'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function patients(Doctor $doctor)
    {
        $patients = $doctor->patients();

        return view('doctors.patients', compact('doctor','patients'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctors = Doctor::with(['region','city'])
                         ->where('revoked', '0')
                         // ->whereHas('reviews')
                         // ->whereHas('schedules')
                         // ->orderBy('serialized_schedules', 'asc')
                         // ->orderBy('subscription_ends_at', 'desc')
                         ->orderBy('updated_at', 'desc')
                         ->orderBy('available', 'desc')
                         // ->whereHas(áppointments)->orderBy('AVERAGE_RATING')
                         ->paginate(25)
                         ;

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
        $regions = Region::all();

        return view('doctors.create', compact('specialties', 'regions'));
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
        $doctor->work_address = $appl->workplace_address;
        $doctor->slug         = $appl->user->slug;
        $doctor->verified_at  = Carbon::now();
        $doctor->verified_by  = auth()->id();
        $doctor->region_id    = $appl->region_id;
        $doctor->city_id      = $appl->city_id;
        
        if ($doctor->save()) {
            // Update user table as dcotor
            $doctor->user->is_doctor = '1';
            $doctor->user->save();

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
        $workplace->current    = '1';
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
        // $sun_schedules = $doctor->schedules()->where('day_id', '1')->get();
        // $mon_schedules = $doctor->schedules()->where('day_id', '2')->get();
        // $tue_schedules = $doctor->schedules()->where('day_id', '3')->get();
        // $wed_schedules = $doctor->schedules()->where('day_id', '4')->get();
        // $thu_schedules = $doctor->schedules()->where('day_id', '5')->get();
        // $fri_schedules = $doctor->schedules()->where('day_id', '6')->get();
        // $sat_schedules = $doctor->schedules()->where('day_id', '7')->get();

        $certificates = $doctor->documents()
                             ->where('description', 'Doctor professional document')
                             ->orderBy('expiry_date', 'desc')
                             ->orderBy('name', 'desc')
                             ->get()
                             ;
        $workplaces = $doctor->workplaces()
                             ->orderBy('start_date', 'desc')
                             ->orderBy('end_date', 'desc')
                             ->get()
                             ;
        $current_workplace = $doctor->currentWorkplace();
        $specialties = Specialty::all();
        $reviews     = Review::where('doctor_id', $doctor->id)
                             ->latest()
                             ->take(3)
                             ->get()
                             ;

        return view('doctors.show', compact('doctor','workplaces','certificates',
            'sun_schedules',
            'mon_schedules',
            'tue_schedules',
            'wed_schedules',
            'thu_schedules',
            'fri_schedules',
            'sat_schedules',
            'current_workplace',
            'specialties',
            'reviews'
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
        $specialties = Specialty::all();
        $current_workplace = $doctor->currentWorkplace();
        $workplaces  = $doctor->workplaces()
                             ->orderBy('start_date', 'desc')
                             ->orderBy('end_date', 'desc')
                             ->get()
                             ;

        return view('doctors.edit', compact('doctor','specialties','current_workplace','workplaces','states','countries','languages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(DoctorUpdateRequest $request, Doctor $doctor)
    {
        // $this->authorize('edit', $doctor);

        $doctor->updateCurrentWorkplace($request);   

        // $state   = State::find($request->state_id)->name;
        // $country = Country::find($request->country_id)->name;
        // $location= $state  .', '. $country;
        // $request->merge(['location' => $location]);

        if ($doctor->update($request->all())){
            flash('Offical profile updated successfully')->success();
        }

        return redirect()->route('doctors.show', $doctor);
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

        // Update user table as dcotor
        $doctor->user->is_doctor = '0';
        $doctor->user->save();
    }
}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicationRequest;
use App\User;
use App\Medication;
use App\Prescription;
use Illuminate\Http\Request;
use Carbon\Carbon;
class MedicationController extends Controller
{
    public function __construct(User $user)
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $user = auth()->user();

        $prescriptions = $this->activePrescriptions();
        // dd($prescriptions);

        $medications   = Medication::where('user_id', $user->id)
                                   ->latest()
                                   ->paginate(15)
                                   ;

        /**
         * This TEST is perfect here. A reference to Medication recurrence calculation
         * - Get the diff between the Start and End datetime,
         *   convert to minutes (smallest unit of recurrence type).
         * /
            $medication = Medication::first();

            // Get total span of medication (in mins).
            $medicationDuration = Carbon::parse($medication->start_time)->diffInMinutes($medication->end_date);  

            // Get base recurrence type (in mins).
            $recurrenceMinutes = $medication->reccurrenceInMinutes[$medication->recurrence_type]; 

            // Time between each recurrence (in mins). This gets next recurrence!
            $recurrenceDuration   = $recurrenceMinutes * $medication->recurrence;  

            // Get total count of recurrence.
            $recurrenceCount   = ceil($medicationDuration / $recurrenceDuration);  

            dd(
                $medicationDuration,
                $recurrenceMinutes,
                $recurrenceDuration,
                $recurrenceCount
            );
        */

        return view('medications.index', compact('medications', 'prescriptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicationRequest $request, User $user)
    {
        $this->authorize('create', Medication::class);
        // dd($request->prescription_id, $request->all());

        $appointmentId = $request->prescription_id
                            ? Prescription::find($request->prescription_id)->appointment_id
                            : null
                            ;

        $request->merge([
            'user_id' => auth()->id(),
            'appointment_id' => $appointmentId,
        ]);

        $medication = Medication::create($request->all());
            
        // Add all recurrence to the event table.
        $medication->user
                   ->calendar_events()
                   ->createMany(\App\CalendarEvent::medicationEventData($medication))
                   ;

        // return response()->json([status => 'Successfully created'], 201);

        return redirect(route('medications.index', $medication->user));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Medication $medication)
    {
        $this->authorize('edit', $medication);

        $user = auth()->user();

        $prescription = Prescription::find($medication->prescription_id) ?: null;/*findOrfail throws 404*/

        $prescriptions = $this->activePrescriptions();

        return view('medications.show', compact('medication', 'prescription', 'prescriptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function update(MedicationRequest $request, User $user, Medication $medication)
    {
        $this->authorize('edit', $medication);

        $medication->update($request->all());

        // return response()->json([status => 'Successfully updated'], 200);

        return redirect($medication->link);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Medication $medication)
    {
        $this->authorize('delete', $medication);
        //
    }

    /**
     * Get all prescriptions from active appointments.
     * Use this for the create/edit.
     *
     * @param  \App\Medication  $medication
     * @return \Illuminate\Http\Collection
     */
    public function activePrescriptions()
    {
        $user = auth()->user();

        $activeAppointments = 
            $user->appointments()
                 ->hasActiveCorrespondence()
                 ->pluck('id')
                 ;
        $prescriptions = 
            $user->prescriptions()
                 ->whereIn('appointment_id', $activeAppointments)
                 ->get()
                 ;

        return $prescriptions;
    }
}

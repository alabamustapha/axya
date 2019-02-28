<?php

namespace App\Http\Controllers;

use App\Http\Requests\MedicationRequest;
use App\Medication;
use App\Prescription;
use Illuminate\Http\Request;

class MedicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        $prescriptions = $this->activePrescriptions();
        // dd($prescriptions);

        $medications   = Medication::where('user_id', $user->id)
                                   ->latest()
                                   ->paginate(15)
                                   ;

        return view('medications.index', compact('medications', 'prescriptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MedicationRequest $request)
    {
        $this->authorize('create', Medication::class);

        $appointmentId = Prescription::find($request->prescription_id)->appointment_id;

        $request->merge([
            'user_id' => auth()->id(),
            'appointment_id' => $appointmentId ?: null,
        ]);

        $medication = Medication::create($request->all());

        // return response()->json([status => 'Successfully created'], 201);

        return redirect(route('medications.index', $medication->user));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function show(Medication $medication)
    {
        $this->authorize('edit', $medication);

        $user = auth()->user();

        $prescription = Prescription::findOrfail($medication->prescription_id);

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
    public function update(MedicationRequest $request, Medication $medication)
    {
        $this->authorize('edit', $medication);

        $medication->update($request->all());

        // return response()->json([status => 'Successfully updated'], 200);

        return redirect(route('medications.index', $medication->user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Medication  $medication
     * @return \Illuminate\Http\Response
     */
    public function destroy(Medication $medication)
    {
        $this->authorize('delete', $medication);
        //
    }

    /**
     * Get all prescriptions from active appointments.
     * se this for the create/edit.
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

<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Drug;
use App\Http\Requests\PrescriptionRequest;
use App\Message;
use App\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('doctor')->except('index','show');
        // $this->middleware('admin')->only('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        switch (request()->status) {
            case 'active': // Prescription is still active.
                $prescriptions = $user->prescriptions()
                         // ->where('status', '1')
                         ->latest()
                         ->paginate(25)
                         ;
                break;
            case 'canceled': // Prescription is canceled.
                $prescriptions = $user->prescriptions()
                         // ->where('status', '2')
                         ->latest()
                         ->paginate(25)
                         ;
                break;
            default:
                $prescriptions = $user->prescriptions()
                         ->latest()
                         ->paginate(25)
                         ;
                break;
        }

        return view('prescriptions.index', compact('prescriptions'));
    }
    public function drindex()
    {
        
        $doctor = Doctor::find(auth()->id());

        switch (request()->status) {
            case 'active': // Prescription is still active.
                $prescriptions = $doctor->prescriptions()
                         // ->where('status', '1')
                         ->latest()
                         ->paginate(25)
                         ;
                break;
            case 'canceled': // Prescription is canceled.
                $prescriptions = $doctor->prescriptions()
                         // ->where('status', '2')
                         ->latest()
                         ->paginate(25)
                         ;
                break;
            default:
                $prescriptions = $doctor->prescriptions()
                         ->latest()
                         ->paginate(25)
                         ;
                break;
        }

        return view('prescriptions.index', compact('prescriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PrescriptionRequest $request)
    {
        $this->authorize('create', Prescription::class);

        // $request->merge(['user_id' => auth()->id()]);

        $prescription = Prescription::create($request->all());

        if ($request->drugs){
            foreach ($request->drugs as $drug) {

                Drug::create([
                  'prescription_id' => $prescription->id,
                  'name'    => $drug['name'],
                  'texture' => $drug['texture'],
                  'dosage'  => $drug['dosage'],
                  'manufacturer' => $drug['manufacturer'],
                  'usage'   => $drug['usage'],
                ]);
            }
        }

        if ($prescription){
            Message::create([
                'user_id'         => auth()->id(),
                'body'            => 'View Prescription: '. $prescription->id,
                'messageable_id'  => $prescription->appointment_id,
                'messageable_type'=> get_class($prescription->appointment),
            ]);

            // auth()->user()->notify(new NewPrescriptonNotification($prescription->user, $prescription));

            $message = 'Prescription created successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            flash($message)->success();
            return redirect()->route('appointments.show', $prescription->appointment);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function show(Prescription $prescription)
    {
        $this->authorize('show', $prescription);

        return view('prescriptions.show', compact('prescription'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function edit(Prescription $prescription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function update(PrescriptionRequest $request, Prescription $prescription)
    {
        $this->authorize('edit', $prescription);

        if ($prescription->update($request->all())){
            // auth()->user()->notify(new PrescriptonUpdateNotification($prescription->user, $prescription));

            $message = 'Prescription updated successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            flash($message)->success();
            return redirect()->route('appointments.show', $prescription->appointment);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Prescription $prescription)
    {
        $this->authorize('delete', $prescription);

        $prescription->delete();
        $message = 'Prescription deleted successfully';

        // if ($prescription->delete()) {
        //     if ($request->expectsJson()) {
        //         return response(['message' => $message]);
        //     }
        // }

        flash($message)->info();
        return redirect()->route('appointments.show', $prescription->appointment);
    }
}

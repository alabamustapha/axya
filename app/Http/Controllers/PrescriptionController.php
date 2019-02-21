<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\Drug;
use App\Http\Requests\PrescriptionRequest;
use App\Message;
use App\Prescription;
use App\User;
use Illuminate\Http\Request;
use App\Notifications\Prescriptions\NewPrescriptionNotification;
use App\Notifications\Prescriptions\PrescriptionUpdateNotification;

class PrescriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('patient')->only('index');
        $this->middleware('doctor')->except('index','show');
        // $this->middleware('admin')->only('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        // $user = auth()->user();

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

        return view('prescriptions.index', compact('user','prescriptions'));
    }
    public function drindex(Doctor $doctor)
    {
        
        // $doctor = Doctor::find(auth()->id());

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

        return view('prescriptions.index', compact('doctor','prescriptions'));
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

            // Message::create([
            //     'user_id'         => auth()->id(),
            //     'body'            => 'View Prescription: '. $prescription->id,
            //     'messageable_id'  => $prescription->appointment_id,
            //     'messageable_type'=> get_class($prescription->appointment),
            // ]);
        $appointment = Appointment::find($request->appointment_id);

        if (intval(auth()->user()->doctor->id) !== intval($appointment->doctor_id)) {
            return abort(403, 'Unauthorized access');
        }

        $message = $appointment->messages()->create([
                'user_id'         => auth()->id(),
                'body'            => 'New Prescription: ',
            ]);


        // $request->merge(['user_id' => auth()->id()]);

        $request->merge(['message_id' => $message->id]);

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

            $prescription->appointment->user->notify(new NewPrescriptionNotification($prescription));

            $message = 'Prescription created successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            // flash($message)->success();
            // return back();
            // return redirect()->route('appointments.show', $prescription->appointment);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Prescription  $prescription
     * @return \Illuminate\Http\Response
     */
    public function update(PrescriptionRequest $request, Prescription $prescription)
    {
        $this->authorize('edit', $prescription);

        if (intval(auth()->user()->doctor->id) !== intval($prescription->appointment->doctor_id)) {
            return abort(403, 'Unauthorized access');
        }

        if ($prescription->update($request->all())){

            $drugsId    = $prescription->drugs()->pluck('id')->toArray();
            $reqDrugsId = collect($request->drugs)->pluck('id')->toArray();
            $removedDrugs = array_diff($drugsId, $reqDrugsId);

            // dd( $drugsId,
            //     $reqDrugsId,
            //     $removedDrugs
            // );

            foreach ($removedDrugs as $drugId) {
                // Drugs removed from list are removed from the DB.
                $drug = Drug::find($drugId);
                // dd($drug->delete());
                $drug->delete();
            }

            if($request->drugs){
                foreach ($request->drugs as $drug) {
                    // Previous drugs and new additions are persisted to the DB.
                    // dd($drug);
                    if (isset($drug['id'])){
                        $drg = Drug::find($drug['id']);

                        $drg->update([
                          // 'prescription_id' => $prescription->id,
                          'name'    => $drug['name'],
                          // 'texture' => $drug['texture'],
                          'dosage'  => $drug['dosage'],
                          'manufacturer' => $drug['manufacturer'],
                          'usage'   => $drug['usage'],
                          // 'comment'   => $drug['comment'],
                        ]);
                    }
                    else{
                        Drug::create([
                          'prescription_id' => $prescription->id,
                          'name'    => $drug['name'],
                          'texture' => $drug['texture'],
                          'dosage'  => $drug['dosage'],
                          'manufacturer' => $drug['manufacturer'],
                          'usage'   => $drug['usage'],
                          // 'comment'   => $drug['comment'],
                        ]);
                    }
                }
            }

            $prescription->appointment->user->notify(new PrescriptionUpdateNotification($prescription));

            $message = 'Prescription updated successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            flash($message)->success();
            return back();
            // return redirect()->route('appointments.show', $prescription->appointment);
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

        if ($prescription->delete()) {
            $message = 'Prescription deleted successfully';

            return response(['message' => $message], 204);
        }
    }
}

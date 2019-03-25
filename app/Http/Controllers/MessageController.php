<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\Http\Requests\MessageRequest;
use App\Http\Requests\DocumentUploadRequest;
use App\Message;
use App\Traits\FileProcessorTrait;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MessageController extends Controller
{
    use FileProcessorTrait;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('patient')->only('index');
        $this->middleware('doctor')->only('drindex');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Appointment $appointment)
    {
        // Active + Pending Appointments.
        $activeAppointments = $user->appointments()
                                     // ->hasPrescription()
                                     ->hasActiveCorrespondence()
                                     ->paginate(10)
                                     ;

        // Inactive + Past Successful Appointments.
        $inactiveAppointments = $user->appointments()
                                     // ->hasPrescription()
                                     ->hasInactiveCorrespondence()
                                     ->paginate(5)
                                     ;
        
        // $messages = $appointment->messages()
        //          ->oldest()
        //          ->paginate(150)
        //          ; 
        $prescriptions = $appointment->prescriptions()->pluck('message_id', 'created_at');

        $cachedChatName = 'chat_messages_'. $appointment->slug;
        $messages = Cache::rememberForever($cachedChatName, function() use($appointment) {
            return $appointment->messages()
                 ->oldest()
                 ->paginate(50)
                 ; 
            });
        // dd(Cache::has($cachedChatName), Cache::get($cachedChatName));
        return view('messages.index', 
            compact(
                'appointment', 
                'user', 
                'messages', 
                'activeAppointments', 
                'inactiveAppointments', 
                'prescriptions'
            ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function drindex(Doctor $doctor, Appointment $appointment)
    {
        // Active + Pending Appointments.
        $activeAppointments = $doctor->appointments()
                                     // ->hasPrescription()
                                     ->hasActiveCorrespondence()
                                     ->paginate(10)
                                     ;

        // Inactive + Past Successful Appointments.
        $inactiveAppointments = $doctor->appointments()
                                     // ->hasPrescription()
                                     ->hasInactiveCorrespondence()
                                     ->paginate(5)
                                     ;
        
        // $messages = $appointment->messages()
        //          ->oldest()
        //          ->paginate(50)
        //          ;
        $prescriptions = $appointment->prescriptions()->pluck('message_id', 'created_at');

        $cachedChatName = 'chat_messages_'. $appointment->slug;
        $messages = Cache::rememberForever($cachedChatName, function() use($appointment) {
            return $appointment->messages()
                 ->oldest()
                 ->paginate(50)
                 ;
            }); 

        // dd(Cache::has($cachedChatName), Cache::get($cachedChatName));
        return view('messages.index', 
            compact(
                'appointment', 
                'doctor', 
                'messages', 
                'activeAppointments', 
                'inactiveAppointments', 
                'prescriptions'
            ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MessageRequest $request, Appointment $appointment)
    {
        $this->authorize('create', Message::class);        

        $request->merge(['user_id' => auth()->id()]);
        
        // $message = Message::create($request->all());
        $message = $appointment->messages()->create($request->all());

        if ($message) {
            $msg = 'Message created';

            if (request()->expectsJson()) {
                return response(['status' => $msg]);
            }
        }
        
        flash($msg)->success();
        return back();
        return redirect()->route('messages.index', [ 'user' => auth()->user(), 'appointment' => $appointment]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        $this->authorize('delete', $message);

        // Could be thrown into 'deleting' Model Observer.
        if ($message->document) { 
            $this->fileDelete( $message );

            $message->forceDelete(); 
        }

        if ($message->prescription) { 
            // if ($message->forceDelete() exerted){
            //     $message->prescription->forceDelete();
            // }
            // if ($message->restore() exerted){
            //     $message->prescription->restore();
            // }
            $message->prescription->delete(); 
        }

        $message->delete();

        $msg = 'Message deleted successfully';

        // if ($message->delete()) {
        //     if ($request->expectsJson()) {
        //         return response(['message' => $msg]);
        //     }
        // }

        flash($msg)->info();
        return redirect()->back();
        //->route('appointments.show', $message->messageable);
        //->route('support_tickets.show', $message->messageable);
    }

    /**
     * Accepted file types:
     *
     * Image  : png, jpeg
     * Video  : mp4, 3gp,
     * Audio  : mp3, wav, ogg
     * Others : pdf, txt,
     */
    public function fileUpload(DocumentUploadRequest $request, Appointment $appointment) 
    {
        $uploadFile   = $request->uploadFile;

        $fileMimeType = $uploadFile[0]->getMimeType();
        $isImage      = starts_with($fileMimeType, 'image/');
        $isVideo      = starts_with($fileMimeType, 'video/');

        $message = $appointment->messages()->create([
                'user_id'         => auth()->id(),
                'body'            => $request->caption,
            ]);

        if ($isImage) {
            // $request->merge(['no_resize' => true]);

            $this->fileProcessor($request, $message);

            flash('Image was successfully uploaded.')->success();
        } 
        // elseif ($isVideo) {
        //     $this->videoProcessing($request, $message);

        //     flash('Video was successfully uploaded.')->success();
        // } 
        else {
            $request->merge([ 'description' => $request->caption]);
            unset($request->caption);

            $this->fileProcessor($request, $message);
            
            flash('File was successfully uploaded.')->success();
        }

        return back();
    }
}

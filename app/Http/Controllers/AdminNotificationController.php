<?php

namespace App\Http\Controllers;

use App\AdminNotification;
use App\Http\Requests\AdminNotificationRequest;
use App\Notifications\Admin\SendAdminNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AdminNotificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notifications = AdminNotification::orderBy('created_at', 'desc')->paginate(20);//latest();

        return view('admin.dashboard.notifications', compact('notifications'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminNotificationRequest $request)
    {
        $this->authorize('create', AdminNotification::class);

        $request->merge([
            'user_id'   => auth()->id(),
            'region_id' => ($request->region_id > 0) ? $request->region_id : null,
        ]);

        $notification = AdminNotification::create($request->all());

        if ($notification){

            // auth()->user()->notify(new SendAdminNotification(auth()->user(), $notification));
            $recipients = $this->recipients($notification);
            dd($recipients->pluck('name', 'email'));

            Notification::send($recipients, new SendAdminNotification($notification));

            $message = 'Admin Notification created successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            flash($message)->success();
            return redirect()->route('dashboard-notifications');
        }
    }

    public function recipients($notification)
    {
        $to         = $notification->to;
        $regionId   = $notification->region_id   ?: null;
        $cityId     = $notification->city_id     ?: null;
        # NB: A doctor's location and email is diff from user instance thus some confusing returned list. 
        # User profile (Region/Email) is used in this Admin Notif not Doctor table profiles.
        $rqEmails   = $notification->searchEmail ?: null;
        $recipients = null;
        // dd($regionId, $cityId, $rqEmails);

        switch ($to) {
            case 'Everyone':
                $recipients = User::all();
                break;

            case 'Admins':
                $recipients = User::whereIn('acl', [1,5])->get();
                break;

            case 'Doctors':
                if ($rqEmails) { 
                    // foreach found user collect()
                    // $recipients = User::where('email', $rqEmails)                    
                    dd('Email Thingy on DDDDDDDDoctors!!!!!');
                    $recipients = User::whereIn('email', $rqEmails)
                        ->get()
                        ;
                } 
                elseif ($regionId && ! $cityId) {
                    $recipients = User::whereHas('doctor')
                        ->where('region_id', $regionId)
                        ->get()
                        ;
                } 
                elseif ($cityId) {
                    $recipients = User::whereHas('doctor')
                        ->where('city_id', $cityId)
                        ->get()
                        ;
                } 
                else {
                    $recipients = User::whereHas('doctor')->get();
                }
                break;

            case 'Users':
                if ($rqEmails) { 
                    // foreach found user collect()
                    // $recipients = User::where('email', $rqEmails)                    
                    dd('Email Thingy on UUUUUsers!!!!!');
                    $recipients = User::whereIn('email', $rqEmails)
                        ->get()
                        ;
                } 
                elseif ($regionId && ! $cityId) {
                    $recipients = User::whereDoesntHave('doctor')
                        ->whereNotIn('acl', [1,5])
                        ->where('region_id', $regionId)
                        ->get()
                        ;
                } 
                elseif ($cityId) {
                    $recipients = User::whereDoesntHave('doctor')
                        ->whereNotIn('acl', [1,5])
                        ->where('city_id', $cityId)
                        ->get()
                        ;
                } 
                else {
                    $recipients = User::whereDoesntHave('doctor')
                        ->whereNotIn('acl', [1,5])
                        ->get()                    
                        ;
                }
                break;
        }
        
        return $recipients;
    }
}

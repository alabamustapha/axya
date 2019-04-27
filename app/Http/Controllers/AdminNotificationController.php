<?php

namespace App\Http\Controllers;

use App\AdminNotification;
use App\Http\Requests\AdminNotificationRequest;
use Illuminate\Http\Request;

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
        $notifications = AdminNotification::latest()->get();

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

            $message = 'Admin Notification created successfully.';

            if ($request->expectsJson()){
                return response(['message' => $message]);
            }
        
            flash($message)->success();
            return redirect()->route('dashboard-notifications');
        }
    }
}

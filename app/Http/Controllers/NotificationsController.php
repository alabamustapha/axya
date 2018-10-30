<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return auth()->user()->unreadNotifications()->get();
    }

    public function display()
    {
        $notifications = auth()->user()->unreadNotifications()->get();

        return view('notifications.index', compact('notifications'));
    }

    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
        // auth()->user()->notifications()->findOrFail($notificationId)->delete();
    }
}
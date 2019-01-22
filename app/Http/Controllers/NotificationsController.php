<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification as Notification;

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
        // $notifications = auth()->user()->unreadNotifications()->paginate(20);
        $dayStats = 
            // auth()->user()->notifications()->selectRaw(
            Notification::where('notifiable_id', auth()->id())->selectRaw(
                'year(created_at) year, 
                 month(created_at) monthNo, 
                 monthname(created_at) month, 
                 week(created_at) week, 
                 day(created_at) dayNo, 
                 dayname(created_at) day,
                 count(*) notif_count'
             )->groupBy(
                'year', 
                'month', 
                'monthNo', 
                'week', 
                'dayNo',
                'day'
            )
             ->orderByRaw('min(created_at) desc')
             // ->latest()
             ->get()
             // ->paginate(20)
             // ->toArray()
             ;
        // \Illuminate\Notifications\DatabaseNotification.php Housed the Icon Hack.
        return view('notifications.index', compact('notifications','dayStats', 'dailyNotifs'));
    }

    public function destroy(User $user, $notificationId)
    {
        auth()->user()->notifications()->findOrFail($notificationId)->markAsRead();
        // auth()->user()->notifications()->findOrFail($notificationId)->delete();
    }
}
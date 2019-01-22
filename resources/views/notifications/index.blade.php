@extends('layouts.master')  

@section('title', 'Notifications') 

@section('content')
  <div class="container"> 
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <h1><i class="fa fa-bell"></i> Your Notifications <span style="font-size:.57em;">({{Auth::user()->unreadNotifications()->count()}})</span></h1>

        @foreach ($dayStats as $notif)

          <div class="content">
            <div class="notification-block">
              <div class="notification-timeline">
                <div class="timeline-pill rounded-pill">
                  {{ 
                    \Carbon\Carbon::parse($notif->day)->format('d') == date('d') 
                        ? 'today'
                        : \Carbon\Carbon::parse($notif->year .'-'. $notif->monthNo .'-'.$notif->dayNo)->format('M d, Y')
                  }} 
                  <span class="badge badge-warning">{{ $notif->notif_count }}</span>
                  <span class="n-line"></span>
                </div>
              </div>

              @foreach (
                auth()->user()->notifications()
                  ->whereDay('created_at', $notif->dayNo)
                  // ->whereWeek('created_at', $notif->week)
                  ->whereMonth('created_at', $notif->monthNo)
                  ->whereYear('created_at', $notif->year)
                  ->get() 
                as 
                  $dNotif
                )
                <div class="notification-item first">
                  <span class="time">{{ $dNotif->created_at->format('h:ia') }}</span>

                  <span class="icon fa-lg"><i class="fas  fa-{{ $dNotif->icon() }}"></i></span>
                  <span class="notification-details">{!! $dNotif->data['message'] !!}</span>
              </div>
              @endforeach
            </div>
          </div>

        @endforeach 
      </div>      
    </div>
  </div>
@endsection
@extends('layouts.app')  
@section('title', 'Notifications') 

@section('content')
  <div class="container"> 
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <h1><i class="fa fa-bell"></i> Your Notifications <span style="font-size:.57em;">({{Auth::user()->unreadNotifications()->count()}})</span></h1>
        <hr>

        @forelse ($notifications as $notif)

          <p class="short-content-bg">- {!! $notif->data['message'] !!}</p><hr>

        @empty

          <p class="empty-list">0 notifications at this time.</p>

        @endforelse        
      </div>      
    </div>
  </div>
@endsection
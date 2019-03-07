@extends('layouts.master')

@section('title', 'Medical Doctors Index')
@section('page-title', 'Doctors Index')

@section('content')

  <!-- SEARCH LIST CONTAINER -->

  <div class="row">
    <div class="col-md-9">
      @forelse ($doctors as $doctor)
        <a href="{{route('doctors.show', $doctor)}}" class="search-item">
            <img src="{{ $doctor->avatar }}" height="60" class="rounded-circle doc-img" alt="doctor's image">
            
            {{-- $doctor->availability_status --}}
            @if ($doctor->is_active)
                <span class="bg-success doc-avail-indicator" title="Available"></span>
            @else
                <span class="bg-danger doc-avail-indicator" title="Unavailable"></span>
            {{-- @elseif ($doctor->is_suspended) { {
                <span class="bg-warning doc-avail-indicator" title="***"></span> --}}
            @endif

            <!-- personal detail -->
            <div id="p-d" class="search-cell">
                <span class="name">{{ $doctor->name }}</span>
                <span class="speciality">{{ $doctor->specialty->name }}</span>
            </div>

            <!-- work detail -->
            <div id="w-d" class="search-cell">
                <span class="name mb-2">{{ $doctor->work_address }}</span>
                <span class="fee">Appt. fee - <strong>{{setting('base_currency')}} {{ $doctor->rate }}</strong> </span>
            </div>

            <!-- schedule detail -->
            
            <div id="s-d" class="search-cell">
                <ul class="nav flex-sm-row">
                    <li class="nav-item {{$doctor->has_sunday_schedules ? 'has':''}}"   >S</li>
                    <li class="nav-item {{$doctor->has_monday_schedules ? 'has':''}}"   >M</li>
                    <li class="nav-item {{$doctor->has_tuesday_schedules ? 'has':''}}"  >T</li>
                    <li class="nav-item {{$doctor->has_wednesday_schedules ? 'has':''}}">W</li>
                    <li class="nav-item {{$doctor->has_thursday_schedules ? 'has':''}}" >T</li>
                    <li class="nav-item {{$doctor->has_friday_schedules ? 'has':''}}"   >F</li>
                    <li class="nav-item {{$doctor->has_saturday_schedules ? 'has':''}}" >S</li>
                </ul>
            </div>
            

            <!-- ratings -->
            <span class="ratings" class="search-cell">
              <span>
                @php
                  // Reduce queries by 7
                  $rating = $doctor->rating_digit;
                @endphp
                @for($i=1; $i <= $rating; $i++)
                  <i class="fa fa-star"></i>
                @endfor
              </span>
            </span>
        </a>
      @empty
        <div class="bg-white p-4 text-center">
          <div class="display-3"><i class="fa fa-user-md"></i></div> 

          <br>

          <p><strong>0</strong> doctors at this time.</p>
        </div> 
      @endforelse
    </div>
    <div class="col-md-3"></div>
  </div>

  <!-- END -->

@endsection
@extends('layouts.master')

@section('title', 'Medical Doctors Index')
@section('page-title', 'Doctors Index')

@section('content')

  <!-- SEARCH LIST CONTAINER -->

  <div class="row">
    <div class="col-md-9">
      @forelse ($doctors as $doctor)
        <a class="search-item">
            <img src="{{ $doctor->avatar }}" height="60" class="rounded-circle doc-img" alt="doctor's image">

            <!-- personal detail -->
            <div id="p-d" class="search-cell">
                <span class="name">{{ $doctor->name }}</span>
                <span class="speciality">{{ $doctor->specialty->name }}</span>
            </div>

            <!-- work detail -->
            <div id="w-d" class="search-cell">
                <span class="name">{{ $doctor->work_address }}</span>
                <span class="fee">Appt. fee - <strong>{{setting('currency')}}{{ $doctor->rate }}</strong> </span>
            </div>
            <!-- schedule detail -->
            <div id="s-d" class="search-cell">
                <ul class="nav flex-sm-row">
                    <li class="nav-item {{$doctor->hasSundaySchedule() ? 'has':''}}"   >S</li>
                    <li class="nav-item {{$doctor->hasMondaySchedule() ? 'has':''}}"   >M</li>
                    <li class="nav-item {{$doctor->hasTuesdaySchedule() ? 'has':''}}"  >T</li>
                    <li class="nav-item {{$doctor->hasWednesdaySchedule() ? 'has':''}}">W</li>
                    <li class="nav-item {{$doctor->hasThursdaySchedule() ? 'has':''}}" >T</li>
                    <li class="nav-item {{$doctor->hasFridaySchedule() ? 'has':''}}"   >F</li>
                    <li class="nav-item {{$doctor->hasSaturdaySchedule() ? 'has':''}}" >S</li>
                </ul>
            </div>

            <!-- ratings -->
            <span class="ratings" class="search-cell">
              <span>
                @for($i=1; $i <= $doctor->rating_digit; $i++)
                  <i class="fa fa-star"></i>
                @endfor
              </span>
              <span>{{$doctor->created_at}}</span>
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
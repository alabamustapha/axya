@extends('layouts.master')

@section('title', $doctor->user->name .' - Doctors')

@section('styles')    
    <link rel="stylesheet" href="{{asset('css/vendor/jquery.timepicker.css')}}"> 
@endsection

@section('content')

  <div>
    {{-- 
    <div class="profile-container">
      <div class="profile-img">
          <img src="{{ $doctor->avatar }}" alt="profile image" class="img-fluid">
          {{ $doctor->availability_status }}

          <div class="search-item">
            <!-- schedule detail -->
            <div id="s-d" class="search-cell w-100">
                <ul class="nav flex-sm-row">
                    <li class="nav-item mr-3">Available on:</li>
                    <li class="nav-item {{$doctor->hasSundaySchedule() ? 'has':''}}"   >S</li>
                    <li class="nav-item {{$doctor->hasMondaySchedule() ? 'has':''}}"   >M</li>
                    <li class="nav-item {{$doctor->hasTuesdaySchedule() ? 'has':''}}"  >T</li>
                    <li class="nav-item {{$doctor->hasWednesdaySchedule() ? 'has':''}}">W</li>
                    <li class="nav-item {{$doctor->hasThursdaySchedule() ? 'has':''}}" >T</li>
                    <li class="nav-item {{$doctor->hasFridaySchedule() ? 'has':''}}"   >F</li>
                    <li class="nav-item {{$doctor->hasSaturdaySchedule() ? 'has':''}}" >S</li>
                </ul>
            </div>
          </div>
      </div>
      <div class="profile-details bg-theme-gradient">
          <div class="fee-wrap">
              <div class="p-1 text-center">FEE</div>
              <span class="fee p-1">{{setting('base_currency')}} {{ $doctor->rate }}</span>
          </div>
          <div class="p-4">
              <div class="category">
                  <span class="cat-title">PROFILE</span>
                  <span class="name font-weight-bold">{{ $doctor->name }}</span>
                  <span class="degree">{{ $doctor->degree }}</span>
                  <span class="office-name">{{ $doctor->current_workplace ? $doctor->current_workplace->name : '' }}</span>
                  <span class="country">{{ $doctor->location }}</span>
              </div>
              <div class="category">
                  <span class="cat-title">speciality</span>
                  <div class="row mb-3 mt-2">
                      <div class="col-md-6 mb-2">
                          <a href="{{route('specialties.show', $doctor->specialty)}}" class="d-block p-2 rounded-pill spec">{{ $doctor->specialty->name }}</a>
                      </div>
                  </div>
              </div>
              <div class="category">
                  <span class="cat-title">experience</span>
                  <span>{{ $doctor->practice_years }}+ Years</span>
              </div>
              <div class="category">
                  <span class="cat-title">CONTACT</span>
                  <span>{{ $doctor->phone }}</span>
              </div>
              <div class="category">
                  <span class="cat-title">ADDRESS</span>
                  <span>{{ $doctor->work_address }}</span>
              </div>
          </div>
      </div>
    </div>
    --}}
    <div class="jumbotron bg-white">   

      <div class="row">
        <div class="col-md-3 text-center">
            <img class="rounded-circle" src="{{ $doctor->user->avatar }}" style="width:200px;" width="25">
            {{ $doctor->availability_status }}

            <br>

            @if ($doctor->user->isAccountOwner())
            <div class="tf-flex">
              <span class="mr-3" title="settings">
                <button id="navbarDropdown" class="btn btn-sm btn-dark dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog"></i> Settings
                </button>

                <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{route('doctors.edit', $doctor)}}">
                    <i class="fa fa-edit mr-1"></i>&nbsp; Edit Profile
                  </a>

                  <button class="dropdown-item" data-toggle="modal" data-target="#updateAvatarForm" title=" Update Avatar">
                    <i class="fa fa-upload"></i>&nbsp; Change Avatar
                  </button>
              
                  @if ($doctor->user->hasUploadedAvatar())
                      <a href="{{route('user.avatar.delete', $doctor->user)}}" class="dropdown-item" title="Remove Avatar" onclick="return confirm('Do you want to remove current avatar?');">
                      <i class="fa fa-trash"></i>&nbsp; Remove Avatar
                    </a>
                  @endif
                </div>
              </span>
              <span class="text-muted text-center">
                  
                <strong>{{$doctor->subscriptionStatus()}}</strong>

              </span>
            </div>
            @endif

            <hr>

            <div class="tf-flex mb-3">
              @auth  
                @if (Auth::id() !== $doctor->user_id)                 
                  <button class="btn btn-primary btn-sm btn-block col" data-toggle="modal" data-target="#appointmentForm" title="Book Appointment">
                    <i class="fa fa-calendar-check"></i>&nbsp; Book Appointment
                  </button>
                @else                 
                  <button class="btn btn-primary btn-sm btn-block col" title="Patient Appointment Booking: You cannot book an appointment as a patient with yourself.">
                    <i class="fa fa-calendar-check"></i>&nbsp; Appointment Booking
                  </button>
                @endif
              @else
                <a href="{{ route('login') }}"
                  id="login-trigger" class="btn btn-primary btn-sm btn-block col" 
                  onclick="alert('Log in now to book an appointment');return false;" 
                  data-toggle="modal" data-target="#regLoginForm" 
                  title="Log in now to book an appointment with {{$doctor->name}}">
                  <i class="fa fa-calendar-check"></i>&nbsp; Book Appointment
                </a>
              @endauth
            </div>

        </div>
        <div class="col-md-9">

          @include('doctors.partials._full-profile')

        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-md-7">
        @auth
          @if((Auth::id() === $doctor->id) && !Auth::user()->isAuthenticatedDoctor())
            <div class="p-2 mb-2 border-bottom bg-light text-sm">
              To edit your schedules <a href="{{ route('doctor.login') }}" class="btn btn-sm btn-primary"><i class="fa fa-sign-in-alt"></i> &nbsp; Sign in as doctor</a>
            </div>
          @endif
        @endauth

        <schedule-index 
            :doctor-id="{{ $doctor->id }}" 
            :is-doctor-owner="{{ intval( Auth::check() 
                                    && ( Auth::id() === $doctor->id ) 
                                    && ( Auth::user()->isAuthenticatedDoctor()) 
                                 ) }}"
        ></schedule-index>
          {{-- 
          @can ('edit', $doctor)
          
            <!-- Schedules/Available Hours Section -->
            @include('doctors.partials._schedules')
            
          @else
          
            @include('doctors.partials._schedules_users')
            
          @endcan --}}

          {{-- <schedule-list :doctor_id="{{$doctor->id}}"></schedule-list> --}}

          @include('doctors.partials._certifications')        
        
      </div>

      <div class="col-md-5" id="reviews">

        <!-- Reviews Section -->
        @include('doctors.partials._review-section')  
        <!-- /.card --> 

      </div>
    </div>

    <div>

      @include('doctors.forms.modals')

    </div>
  </div>

@endsection

@section('scripts')

  @include('appointments.partials.scripts')
  
@endsection
@extends('layouts.master')

@section('title', $doctor->user->name .' - Doctors')

@section('content')

  <div>

    <div class="jumbotron bg-white">    
      <div class="row">
        <div class="col-md-3 text-center">
            <img class="rounded-circle" src="{{ $doctor->user->avatar }}" style="width:200px;" width="25">

            <br>

            @if ($doctor->user->isAccountOwner())
            <div class="tf-flex">
              <span class="mr-3" title="settings">
                <button id="navbarDropdown" class="btn btn-sm btn-dark dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog"></i> Settings
                </button>

                <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                  <button class="dropdown-item" data-toggle="modal" data-target="#updateAvatarForm" title=" Update Avatar">
                    <i class="fa fa-upload"></i>&nbsp; Change Avatar
                  </button>

                  <button onclick="return false;" class="dropdown-item" title="Update Profile" data-toggle="modal" data-target="#updateProfessionalProfileForm">
                    <i class="fa fa-edit mr-1"></i>&nbsp; Edit Profile
                  </button>
              
                  @if ($doctor->user->hasUploadedAvatar())
                      <a href="{{route('user.avatar.delete', $doctor->user)}}" class="dropdown-item" title="Remove Avatar" onclick="return confirm('Do you want to remove current avatar?');">
                      <i class="fa fa-trash text-light"></i>
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
                <a href="#" class="btn btn-primary btn-sm btn-block col" data-toggle="modal" data-target="#appointmentForm" title="Book Appointment">
                  <i class="fa fa-calendar-check"></i>&nbsp; Book Appointment
                </a>
              @else
                <button class="btn btn-primary btn-sm btn-block col" onclick="alert('Log in now to book an appointment');" title="Book Appointment">
                  <i class="fa fa-calendar-check"></i>&nbsp; Book Appointment
                </button>
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

          @can ('edit', $doctor)
          
            <!-- Schedules/Available Hours Section -->
            @include('doctors.partials._schedules')
            
          @else
          
            @include('doctors.partials._schedules_users')
            
          @endcan

          {{-- <schedule-list :doctor_id="{{$doctor->id}}"></schedule-list> --}}

          @include('doctors.partials._certifications')        
        
      </div>

      <div class="col-md-5">

        <!-- Reviews Section -->
        <div class="card card-dark">
          <div class="card-header">
            <h3 class="card-title">Reviews</h3>
          </div>
          <div class="card-body box-profile">

            <ul class="list-group list-group-unbordered mb-0">
              <li class="list-group-item p-1">John Doe <span class="muted">Such a great professional. ****</span></li>
              <li class="list-group-item p-1">Jason Doe <span class="muted">The consultation was breathtaking. ****</span></li>
              <li class="list-group-item p-1">Jane Doe <span class="muted">I got good value for the money. ****</span></li>
            </ul>
          </div>
        </div>  
        <!-- /.card --> 

      </div>
    </div>

    <div>

      @include('doctors.forms.modals')

    </div>
  </div>

@endsection
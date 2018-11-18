@extends('layouts.master')

@section('title', $doctor->user->name .' - Doctors')

@section('content')

  <div class="container-fluid">

    <div class="jumbotron bg-white">    
      <div class="row">
        <div class="col-md-3 text-center">
            <img class="rounded-circle" src="{{ $doctor->user->avatar }}" style="width:200px;" width="25">

            <br>

            @if ($doctor->user->isAccountOwner())
            <div class="tf-flex">
              <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateAvatarForm" title=" Update Avatar">
                <i class="fa fa-upload text-light"></i>
              </button>

              
              @if ($doctor->user->hasUploadedAvatar())
                  <a href="{{route('user.avatar.delete', $doctor->user)}}" class="btn btn-sm btn-danger" title="Remove Avatar" onclick="return confirm('Do you want to remove current avatar?');">
                  <i class="fa fa-trash text-light"></i>
                </a>
              @endif
            </div>
            @endif

            <div>
              <p class="text-muted text-center">

                @if ($doctor->user->isAccountOwner())
                
                  <strong>{{$doctor->subscriptionStatus()}}</strong>

                @endif
              </p>

              @if ($doctor->user->isAccountOwner())
                <a onclick="return false;" class="btn btn-dark btn-block text-light" title="Update Profile" data-toggle="modal" data-target="#updateProfessionalProfileForm">
                  <i class="fa fa-edit mr-1"></i> 
                  <b>Edit Details</b>
                </a>
              @endif
            </div>

            <hr>

            <div class="tf-flex mb-3">                        
                <a href="#" class="btn btn-primary btn-sm btn-block col">
                  <i class="fa fa-calendar-check"></i>&nbsp; Make Appointment</a>
                <span>&nbsp;</span>
            </div>

        </div>
        <div class="col-md-9">
          <h1>
            {{$doctor->user->name}}
            <span {{$doctor->availabilityText()}}></span>
          </h1>
          <h3>
            <small><i class="fa fa-user-md"></i> {{ $doctor->specialty->name }}</small>
          </h3>
          
          <hr>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item p-2 px-3 border-top-0">
              <b class="d-inline-block w-25"><i style="width:25px;" class="fa fa-user-md"></i> Specialty</b> <a>{{ $doctor->specialty->name }}</a>
            </li>
            <li class="list-group-item p-1 px-3">
              <b class="d-inline-block w-25"><i style="width:25px;" class="fa fa-procedures"></i> Patients Served</b> <a>{{$doctor->patients->count()}}</a>
            </li>
            <li class="list-group-item p-1 px-3">
              <b class="d-inline-block w-25"><i style="width:25px;" class="fa fa-university"></i> Alma mater</b> <span>{{ $doctor->graduate_school }}</span>
            </li>
            <li class="list-group-item p-1 px-3">
              <b class="d-inline-block w-25"><i style="width:25px;" class="fa fa-calendar-alt"></i> Availabilty</b> <span>{{$doctor->available ? 'Available':'Unavailable'}}</span>
            </li>
            <li class="list-group-item p-1 px-3">
              <b class="d-inline-block w-25"><i style="width:25px;" class="fa fa-calendar"></i> Practice Years</b> <span>{{$doctor->practice_years}} yrs</span>
            </li>

            <li class="list-group-item p-1 px-3">
              <b class="d-inline-block w-25"><i style="width:25px;" class="fa fa-map-marker"></i> Location</b> <span>{{$doctor->user->address}}</span>
            </li>
            <li class="list-group-item p-1 px-3">
              <b class="d-inline-block w-25"><i style="width:25px;" class="fa fa-hospital-alt"></i> Place of Work</b> <span> {{-- $doctor->workplace }}, {{ $doctor->workplace_address --}}</span>
            </li>
            <li class="list-group-item p-1 px-3 border-bottom-0">
              <b class="d-inline-block w-25"><i style="width:25px;" class="fa fa-info-circle"></i> About</b> <span> {{ $doctor->about }}</span>
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="row">

      <div class="col-md-7">

        <!-- Schedules/Available Hours Section -->

          @include('doctors._schedules')

        <!-- /.card -->

        <!-- Certification And Work Records Section -->

          @include('doctors._certifications')

        <!-- /.card -->           
        
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

    @if ($doctor->user->isAccountOwner())
      <div class="modal" tabindex="-1" role="dialog" id="updateProfessionalProfileForm" style="display:none;" aria-labelledby="updateProfessionalProfileFormLabel" aria-hidden="true">
        <div class="modal-dialog{{--  modal-dialog-centered --}}" role="document">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">

              {{-- @include('doctors.forms.edit') --}}

            </div> <!-- modal-body -->    
          </div> <!-- modal-content -->    
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="createWorkplaceForm" style="display:none;" aria-labelledby="createWorkplaceFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered" role="document">
          <div class="modal-content px-0 pb-0 bg-transparent shadow-none">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body pb-0">

              @include('doctors.forms.workplace')

            </div>
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="updateAvatarForm" style="display:none;" aria-labelledby="updateAvatarFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
          <div class="modal-content px-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">
              <div class="text-center">
                <img class="img-fluid img-circle profile-img" src="{{$doctor->user->avatar}}" alt="{{$doctor->user->name}} profile picture">

                <div class="form-group text-center">
                  <label for="avatar" class="h5">Update Display Picture</label>
                </div>
              </div>

              <form action="{{route('user.avatar.upload', $doctor->user)}}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}  
                {{ method_field('PATCH') }}   

                <div class="form-group text-center">
                  <input type="file" name="avatar" id="avatar" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}" accept="image/*" required>

                  @if ($errors->has('avatar'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('avatar') }}</strong>
                      </span>
                  @endif
                </div> 

                <div class="form-group">
                  <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Upload Avatar</button>
                </div>
              </form> 
            </div>
          </div>
        </div>
      </div>

      <div class="modal" tabindex="-1" role="dialog" id="updateScheduleForm" style="display:none;" aria-labelledby="updateScheduleFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
          <div class="modal-content px-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">

              <form action="{{-- route('schedules.update', $schedule) --}}" method="post">
                {{ csrf_field() }}  
                {{ method_field('PUT') }}   

                <div class="form-group text-center">
                  <input type="hidden" name="schedule_id" required>
                  <input type="time" name="start_at" value="{{--$schedule->id--}}" placeholder="hh:mm am (23:15 am)" pattern="" id="start_at" class="form-control{{ $errors->has('start_at') ? ' is-invalid' : '' }}" required>

                  @if ($errors->has('start_at'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('start_at') }}</strong>
                      </span>
                  @endif

                  <input type="time" name="end_at" value="{{--$schedule->id--}}" placeholder="hh:mm am (23:15 am)" pattern="" id="end_at" class="form-control{{ $errors->has('end_at') ? ' is-invalid' : '' }}" required>

                  @if ($errors->has('end_at'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('end_at') }}</strong>
                      </span>
                  @endif
                </div> 

                <div class="form-group">
                  <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Update Schedule</button>
                </div>
              </form> 
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>

@endsection
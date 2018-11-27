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
              <span class="mr-3" title="settings">              
                <button id="navbarDropdown" class="btn btn-sm btn-dark dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-cog"></i>
                </button>

                <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                  <button class="dropdown-item" data-toggle="modal" data-target="#updateAvatarForm" title=" Update Avatar">
                    <i class="fa fa-upload"></i>&nbsp; Change Avatar
                  </button>

                  <button onclick="return false;" class="dropdown-item" title="Update Profile" data-toggle="modal" data-target="#updateProfessionalProfileForm">
                    <i class="fa fa-edit mr-1"></i>&nbsp; Edit Details
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
                <a href="#" class="btn btn-primary btn-sm btn-block col" data-toggle="modal" data-target="#appointmentForm" title="Book Appointment">
                  <i class="fa fa-calenda r-check"></i>&nbsp; Book Appointment
                </a>
            </div>

        </div>
        <div class="col-md-9">
          <h1>
            {{$doctor->user->name}} 
            <small style="font-size: 14px;" class="badge badge-secondary badge-pill">
              $100.00 / hour{{--$doctor->rate--}}
            </small>
            <span class="{{$doctor->availabilityText()}}"></span>
          </h1>
          <span class="h6">
            <ul class="list-unstyled">
              <li class="pb-1" title="Speicialty">
                <span>
                  <i class="fa fa-user-md" style="min-width:7%"></i> {{ $doctor->specialty->name }}
                </span>
              </li>

              @if(Auth::check() && (Auth::user()->can('edit', $doctor) || Auth::user()->is_admin))
              <li class="pb-1" title="Email">
                <span>
                  <i class="fa fa-at" style="min-width:7%"></i> {{$doctor->user->email}}
                </span>
              </li>
              <li class="pb-1" title="Phone">
                <span>
                  <i class="fa fa-mobile" style="min-width:7%"></i> {{$doctor->user->phone}}
                </span>
              </li>
              @endif
            </ul>
          </span>
          
          <hr>

          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item p-1 px-3 mt-0 border-top-0">
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

          @can ('edit', $doctor)
          
            @include('doctors.partials._schedules')
            
          @else
          
            @include('doctors.partials._schedules_users')
            
          @endcan
          {{-- <schedule-list :doctor_id="{{$doctor->id}}"></schedule-list> --}}

        <!-- /.card -->

        <!-- Certification And Work Records Section -->

          @include('doctors.partials._certifications')

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

    <div class="modal" tabindex="-1" role="dialog" id="appointmentForm" style="display:none;" aria-labelledby="appointmentFormLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content px-0 pb-0 bg-transparent shadow-none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
            <span aria-hidden="true">&times;</span>
          </button>
          <br>
          <div class="modal-body">

            <div class="card card-primary card-outline text-center shadow">
              <div class="card-header">
                <div class="card-title">
                  <i class="fa fa-tags"></i> {{$doctor->user->name}}
                  <br>

                  <span style="font-size:14px;font-weight:bold;">
                    <i class="fa fa-user-md red"></i> {{$doctor->specialty->name}}
                    <br>

                    <span class="badge badge-secondary badge-pill">
                      <b>$100.00 / hour</b>{{--$doctor->rate--}}
                    </span>
                  </span>
                </div>
              </div>

              <div class="card-body">

                <form action="{{ route('appointments.store') }}" method="post">
                  {{ csrf_field() }}  
                    
                  <div class="form-group text-center">
                    <div class="row">

                      <div class="col-md-6">
                        <label for="type">Type</label>
                        <select name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" required>
                          <option value="">Appointment Type</option>
                          <option value="Online" {{old('type') == 'Online' ? 'selected':''}}>Online</option>
                          <option value="Home" {{old('type') == 'Home' ? 'selected':''}}>Home</option>
                        </select>

                        @if ($errors->has('type'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('type') }}</strong>
                            </span>
                        @endif                    
                      </div>

                      <div class="col-md-6">
                        <label for="day">Select Day</label>
                        <input type="hidden" name="doctor_id" value="{{$doctor->id}}">
                        <input type="date" name="day" value="{{old('day')}}" placeholder="yyyy-mm-dd" pattern="" id="day" class="form-control{{ $errors->has('day') ? ' is-invalid' : '' }}" required>

                        @if ($errors->has('day'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('day') }}</strong>
                            </span>
                        @endif   
                      </div>
                    </div>
                  </div> 

                  <div class="form-group text-center">
                    <div class="row">

                      <div class="col-md-6">
                        <label for="from">Schedule time start</label>
                        <input type="time" name="from" minlength="8" maxlength="8" value="{{old('from')}}" placeholder="hh:mm:ss" pattern="" id="from" class="form-control{{ $errors->has('from') ? ' is-invalid' : '' }}" required>

                        @if ($errors->has('from'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('from') }}</strong>
                            </span>
                        @endif
                      </div>
                      <div class="col-md-6">
                        <label for="to">Schedule time end</label>
                        <input type="time" name="to" minlength="8" maxlength="8" value="{{old('to')}}" placeholder="hh:mm:ss" pattern="" id="to" class="form-control{{ $errors->has('to') ? ' is-invalid' : '' }}" required>

                        @if ($errors->has('to'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('to') }}</strong>
                            </span>
                        @endif                    
                      </div>
                    </div>
                  </div> 

                  <fieldset class="p-2 border-1">
                    <legend class="h5">Home Visitation</legend>

                    <div class="form-group text-center">
                      <label for="address">Address</label>
                      <input type="text" name="address" maxlength="255" value="{{old('address')}}" placeholder="address for home visit" id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" {{-- required --}}>

                      @if ($errors->has('address'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('address') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group text-center">
                      <label for="phone">Phone Contact</label>
                      <input type="tel" name="phone" maxlength="255" value="{{old('phone')}}" placeholder="phone for home visit" id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" {{-- required --}}>

                      @if ($errors->has('phone'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('phone') }}</strong>
                          </span>
                      @endif
                    </div>
                  </fieldset>

                  <div class="form-group text-center">
                    <textarea name="patient_info" id="patient_info" style="min-height: 120px;max-height: 150px;" placeholder="write your intention for booking an appointment with {{$doctor->user->name}}" class="form-control{{ $errors->has('patient_info') ? ' is-invalid' : '' }}" required>{{old('patient_info')}}</textarea>

                    @if ($errors->has('patient_info'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('patient_info') }}</strong>
                        </span>
                    @endif
                  </div> 

                  <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Submit</button>
                  </div>
                </form> 

              </div>

              <div class="card-footer">
                <span class="text-danger"><b>Make sure your medical history is properly created in your profile.</b></span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>

@endsection
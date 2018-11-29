
    @if ($doctor->user->isAccountOwner())
      <div class="modal" tabindex="-1" role="dialog" id="updateProfessionalProfileForm" style="display:none;" aria-labelledby="updateProfessionalProfileFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-md" role="document">
          <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">

              @include('doctors.forms.edit')

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

                    <span class="badge badge-secondary badge-pill text-bold">
                      ${{ $doctor->rate }} / hour
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
                        <label for="day">Select Day <small>(yyyy-mm-dd)</small></label>
                        <input type="hidden" name="doctor_id" value="{{$doctor->id}}">
                        <input type="date" name="day" maxlength="10" min="{{date('Y-m-d')}}"
                          value="{{old('day')}}" placeholder="yyyy-mm-dd" pattern="[0-9]{4}-[0-9]{2}-[0-9]{2}" 
                          id="day" class="form-control{{ $errors->has('day') ? ' is-invalid' : '' }}" 
                          required>

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
                        <label for="from">Start <small>(eg 11:30 or 11:30 AM)</small></label>
                        <input type="time" name="from" minlength="5" maxlength="5" min="00:00" max="23:59" 
                          value="{{old('from')}}" placeholder="hh:mm" pattern="[0-9]{2}:[0-9]{2}" 
                          id="from" class="form-control{{ $errors->has('from') ? ' is-invalid' : '' }}" 
                          required>

                        @if ($errors->has('from'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('from') }}</strong>
                            </span>
                        @endif
                      </div>
                      <div class="col-md-6">
                        <label for="to">End <small>(eg 22:15 or 10:15 PM)</small></label>
                        <input type="time" name="to" minlength="5" maxlength="5" min="00:00" max="23:59" 
                          value="{{old('to')}}" placeholder="hh:mm" pattern="[0-9]{2}:[0-9]{2}" 
                          id="to" class="form-control{{ $errors->has('to') ? ' is-invalid' : '' }}" 
                          required>

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
                <span class="text-danger text-small"><b>Make sure your medical history is properly created in your profile.</b></span>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
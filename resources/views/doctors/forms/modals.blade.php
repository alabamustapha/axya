
    @if ($doctor->user->isAccountOwner())
      <!-- Doctor Profile Update Form-->
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
      <!-- END - Doctor Profile Update Form-->

      <!-- New Workplace Form-->
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
      <!-- END - New Workplace Form-->

      <!-- Avatar Update Form-->
      <div class="modal" tabindex="-1" role="dialog" id="updateAvatarForm" style="display:none;" aria-labelledby="updateAvatarFormLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
          <div class="modal-content px-3">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
              <span aria-hidden="true">&times;</span>
            </button>
            <br>
            <div class="modal-body">
              <div class="text-center">
                <img class="img-fluid img-circle profile-img" src="{{$doctor->user->avatar}}" alt="{{$doctor->name}} profile picture">

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
      <!-- END - Avatar Update Form-->

      <!-- Schedule Update Form-->
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
      <!-- END - Schedule Update Form-->
    @endif

    <!-- Appointment Form-->
    @if (Auth::id() !== $doctor->user_id)
    <div class="modal" tabindex="-1" role="dialog" id="appointmentForm" style="display:none;" aria-labelledby="appointmentFormLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content px-0 pb-0 {{-- bg-transparent --}} shadow-none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
            <span aria-hidden="true">&times;</span>
          </button>
          <br>
          <div class="modal-body">

            {{-- @include('appointments.partials.form') --}}
            {{-- <appointment-form :doctor="{{$doctor}}"></appointment-form> --}}

              <div class="content">

                <!-- HEAD -->
                <div class="info-head bg-white shadow-sm">
                    <div class="media">
                        <img src="{{$doctor->avatar}}" class="align-self-center mr-3 rounded-circle" height="60" alt="{{$doctor->name}}">
                        <div class="media-body align-self-center">
                            {{$doctor->name}}
                        </div>
                    </div>
                </div>
               
                <div class="req-form my-3">
                  <form action="{{ route('appointments.store') }}" method="post">
                    {{ csrf_field() }} 
                    
                    <div class="form-row mb-2">
                      <div class="col-md-6">
                        <label for="appointment_type">Type*</label>
                        <select id="appointment_type" name="type" class="form-default form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" required>
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
                        <label for="day">Select Day*</label>
                        <input type="hidden" name="doctor_id" value="{{$doctor->id}}">
                        <input name="day" value="{{old('day')}}" 
                          type="text" id="datepicker"
                          {{-- type="date" id="day"  --}}
                          minlength="10" maxlength="15" min="{{date('Y-m-d')}}"
                          placeholder="{{date('Y-m-d')}}" autocomplete="off" 
                          class="form-default form-control{{ $errors->has('day') ? ' is-invalid' : '' }}" 
                          required>

                        @if ($errors->has('day'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('day') }}</strong>
                            </span>
                        @endif   
                      </div>
                    </div>


                    <div class="form-row mb-2" id="timepicker">
                      <div class="col-md-6">
                        <div class="input-group form-default">
                          <div class="input-group-prepend">
                            <span class="input-group-text">From</span>
                          </div>

                          <input id="from" type="text" name="from" minlength="5" maxlength="8" min="00:00" max="23:59" 
                          value="{{old('from')}}" placeholder="HH:MM AM"
                          id="from" class="time start form-control{{ $errors->has('from') ? ' is-invalid' : '' }}" 
                          required>

                          @if ($errors->has('from'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('from') }}</strong>
                              </span>
                          @endif
                        </div>
                      </div>
                      
                      <div class="col-md-6">
                        <div class="input-group form-default">
                          <div class="input-group-prepend">
                            <span class="input-group-text">To</span>
                          </div>

                          <input id="to" type="text" name="to" minlength="5" maxlength="8" min="00:00" max="23:59" 
                          value="{{old('to')}}" placeholder="HH:MM AM"
                          id="to" class="time end form-control{{ $errors->has('to') ? ' is-invalid' : '' }}" 
                          required>

                          @if ($errors->has('to'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('to') }}</strong>
                              </span>
                          @endif                    
                        </div>
                      </div>
                    </div>

                    <div id="deal" class="col-md-8 offset-md-2 mb-2 p-3 table-responsive text-center" style="border-radius:4px;border:1px solid #ccc;font-size: 12px;display: none;">
                      <div class="tf-flex">
                        <span class="border p-1 w-100">
                            <span class="text-muted" style="font-size: 1rem;">Fee:</span> <br>
                            <kbd>$<strong id="cost"></strong></kbd>
                        </span>
                        <span class="border p-1 w-100">
                            <span class="text-muted" style="font-size: 1rem;">Sessions:</span> <br>
                            <kbd><strong id="no_of_sessions"></strong></kbd>
                        </span>

                        <span class="border p-1 w-100">
                            <span class="text-muted" style="font-size: 1rem;">Duration:</span> <br>
                            <kbd><strong id="duration"></strong></kbd>
                        </span>
                        <!-- For jQuery Deal Calculation. -->
                        <input id="session" value="{{$doctor->session}}" type="hidden">
                        <input id="rate" value="{{$doctor->rate}}" type="hidden">
                      </div>
                    </div>

                    <div class="form-row mb-2">
                      <div class="col-md-12">
                        <label for="description">Description*</label>
                        <textarea name="description" id="description" style="min-height: 120px;max-height: 150px;" placeholder="Describe in details why you are requesting this appointment" class="form-default form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" required>{{old('description')}}</textarea>

                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                      </div> 
                    </div>

                    <fieldset id="home-visitation" class="p-3 mb-2 border-1" style="border-radius:4px;border:1px solid #ccc;display: none;">
                      <legend class="h5 py-1">Home Visitation</legend>

                      <div class="form-row">
                        <label for="address">Address*</label>
                        <input type="text" name="address" maxlength="255" value="{{old('address')}}" placeholder="address for home visit" id="address" class="form-default form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">

                        @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-row">
                        <label for="phone">Phone Contact*</label>
                        <input type="tel" name="phone" maxlength="255" value="{{old('phone')}}" placeholder="phone for home visit" id="phone" class="form-default form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}">

                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                      </div>
                    </fieldset>

                    <div class="form-row">
                      <div class="col-md-12">
                        <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Submit</button>
                      </div>
                    </div>


                    {{-- 
                        <div class="form-row">
                            <div class="col-md-6{{--  pr-5 pl-4 -}}">
                                
                                <div class="form-group">
                                    <label for="description">description*</label>
                                   <textarea name="description" id="description" rows="4" class="form-control form-default"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6 pl-5 pr-4">
                                
                                <div class="form-group">
                                    <label for="date">Select Date*</label>
                                    <input type="date" class="form-control form-default" name="date" id="date">
                                </div>
                                <div class="form-group">
                                    <label for="date">Time*</label>
                                    <input type="time" class="form-control form-default" name="time" id="time">
                                </div>
                            </div>
                        </div>

                        <div class="text-center my-4">
                            <span class="text-theme-blue small">other fields will be available once doctor receives appoitment</span>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6 pr-5 pl-4">
                        
                                <div class="form-group">
                                    <label for="history">History of Illness*</label>
                                    <textarea name="history" id="history" rows="4" class="form-control form-default"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="duration">Duration*</label>
                                    <select class="custom-select form-default">
                                       
                                        <option value="1" selected="">1week</option>
                                        <option value="2">2weeks</option>
                                        <option value="3">3weeks</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="duration">Pay Amount*</label>
                                    <input type="text" name="pay" id="pay" class="form-control form-default">
                                </div>
                            </div>
                            
                        </div>

                        <div class="text-center py-3">
                            <button type="submit" class="btn btn-lg bg-theme-blue">Submit</button>
                        </div> 
                    --}}

                  </form>
                </div>
                   

              </div>

          </div>
        </div>
      </div>
    </div>
    @endif
    <!-- END - Appointment Form-->
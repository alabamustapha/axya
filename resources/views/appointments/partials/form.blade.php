<div class="card card-primary card-outline text-center shadow">
              <div class="card-header">
                <div class="card-title">
                  <i class="fa fa-tags"></i> {{$doctor->name}}
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
                        <input type="text" name="day" minlength="10" maxlength="15" min="{{date('Y-m-d')}}"
                           id="datepicker" value="{{old('day')}}" placeholder="{{date('Y-m-d')}}" autocomplete="off" 
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
                    <div class="row" id="timepicker">
                      <div class="col-md-5">
                        <input type="text" name="from" minlength="5" maxlength="8" min="00:00" max="23:59" 
                        value="{{old('from')}}" placeholder="HH:MM AM"
                        id="from" class="time start form-control{{ $errors->has('from') ? ' is-invalid' : '' }}" 
                        required>

                        @if ($errors->has('from'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('from') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="col-xs-1 mx-auto p-0 m-0"> to </div>

                      <div class="col-md-6">
                        <input type="text" name="to" minlength="5" maxlength="8" min="00:00" max="23:59" 
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

                  <fieldset class="p-2 border-1">
                    <legend class="h5">Home Visitation</legend>

                    <div class="form-group text-center">
                      <label for="address">Address</label>
                      <input type="text" name="address" maxlength="255" value="{{old('address')}}" placeholder="address for home visit" id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">

                      @if ($errors->has('address'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('address') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group text-center">
                      <label for="phone">Phone Contact</label>
                      <input type="tel" name="phone" maxlength="255" value="{{old('phone')}}" placeholder="phone for home visit" id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}">

                      @if ($errors->has('phone'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('phone') }}</strong>
                          </span>
                      @endif
                    </div>
                  </fieldset>

                  <div class="form-group text-center">
                    <textarea name="patient_info" id="patient_info" style="min-height: 120px;max-height: 150px;" placeholder="write your intention for booking an appointment with {{$doctor->name}}" class="form-control{{ $errors->has('patient_info') ? ' is-invalid' : '' }}" required>{{old('patient_info')}}</textarea>

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
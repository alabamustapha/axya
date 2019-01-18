<div class="card card-primary text-center shadow">
              <div class="card-header">
                <div class="card-title">
                  <i class="fa fa-tags"></i> {{$doctor->name}}
                  <br>

                  <span style="font-size:14px;font-weight:bold;">
                    <i class="fa fa-user-md red"></i> {{$doctor->specialty->name}}
                    <br>

                    <span class="badge badge-secondary badge-pill text-bold">
                      ${{ $doctor->rate }} / session ({{$doctor->session}})
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
                        <label for="appointment_type">Type</label>
                        <select id="appointment_type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" required>
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
                        <input name="day" value="{{old('day')}}" 
                          type="text" id="datepicker"
                          {{-- type="date" id="day"  --}}
                          minlength="10" maxlength="15" min="{{date('Y-m-d')}}"
                          placeholder="{{date('Y-m-d')}}" autocomplete="off" 
                          class="form-control{{ $errors->has('day') ? ' is-invalid' : '' }}" 
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

                      <div class="col-xs-1 mx-auto p-0 m-0"> to </div>

                      <div class="col-md-6">
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

                    <div id="deal" class="my-2 p-2 table-responsive" style="border-radius:4px;border:1px solid #ccc;font-size: 12px;display: none;">
                      <div class="tf-flex">
                        <span class="border p-1">
                            <span class="text-muted" style="font-size: 1rem;">Fee:</span> <br>
                            <kbd>$<strong id="cost"></strong></kbd>
                        </span>
                        <span class="border p-1">
                            <span class="text-muted" style="font-size: 1rem;">Sessions:</span> <br>
                            <kbd><strong id="no_of_sessions"></strong></kbd>
                        </span>

                        <span class="border p-1">
                            <span class="text-muted" style="font-size: 1rem;">Duration:</span> <br>
                            <kbd><strong id="duration"></strong></kbd>
                        </span>
                        <input id="session" value="{{$doctor->session}}" type="hidden">
                        <input id="rate" value="{{$doctor->rate}}" type="hidden">
                      </div>
                    </div>
                  </div> 

                  <fieldset id="home-visitation" class="p-3 mb-2 border-1 bg-light" style="border-radius:4px;border:1px solid #ccc;display: none;">
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
                    <textarea name="description" id="description" style="min-height: 120px;max-height: 150px;" placeholder="Describe in details why you are requesting this appointment" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" required>{{old('description')}}</textarea>

                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
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
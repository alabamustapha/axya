<div class="card card-primary text-center shadow">
              <div class="card-header">
                <div class="card-title">
                  <i class="fa fa-tags"></i> {{$appointment->doctor->name}}
                  <br>

                  <span style="font-size:14px;font-weight:bold;">
                    <i class="fa fa-user-md red"></i> {{$appointment->doctor->specialty->name}}
                    <br>

                    <span class="badge badge-secondary badge-pill text-bold">
                      ${{ $appointment->doctor->rate }} / session ({{$appointment->doctor->session}})
                    </span>
                  </span>
                </div>
              </div>

              <div class="card-body">

                <form action="{{ route('appointments.update', $appointment) }}" method="post">
                  @csrf 
                  {{ method_field('PATCH') }} 
                  <input type="hidden" name="id" value="{{dechex($appointment->id)}}"> 
                    
                  @if ($appointment->status == '0')
                  <!-- If not accepted yet STATUS = 0 -->
                    <div class="form-group text-center">
                      <div class="row">

                        <div class="col-md-6">
                          <label for="appointment_type">Type</label>
                          <select id="appointment_type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" required>
                            <option value="">Appointment Type</option>
                            <option value="Online" {{(old('type') == 'Online' || $appointment->type == 'Online') ? 'selected':''}}>Online</option>
                            <option value="Home" {{(old('type') == 'Home' || $appointment->type == 'Home') ? 'selected':''}}>Home</option>
                          </select>

                          @if ($errors->has('type'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('type') }}</strong>
                              </span>
                          @endif                    
                        </div>

                        <div class="col-md-6">
                          <label for="day">Select Day</label>
                          <input type="hidden" name="doctor_id" value="{{$appointment->doctor_id}}">
                          <input name="day" value="{{old('day')?:$appointment->day_edit}}" 
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
                          <input type="text" name="from" minlength="5" maxlength="8" min="00:00" max="23:59" 
                          value="{{old('from')?:$appointment->start_time}}" placeholder="HH:MM AM"
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
                          value="{{old('to')?:$appointment->end_time}}" placeholder="HH:MM AM"
                          id="to" class="time end form-control{{ $errors->has('to') ? ' is-invalid' : '' }}" 
                          required>

                          @if ($errors->has('to'))
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $errors->first('to') }}</strong>
                              </span>
                          @endif                    
                        </div>
                      </div>

                      <div id="deal" class="my-2 p-2 table-responsive rounded" style="font-size: 12px;display: none;">
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
                          <input id="session" value="{{$appointment->doctor->session}}" type="hidden">
                          <input id="rate" value="{{$appointment->doctor->rate}}" type="hidden">
                        </div>
                      </div>
                    </div> 

                    <fieldset id="home-visitation" class="p-3 mb-2 border-1 bg-light rounded" style="display: none;">
                      <legend class="h5">Home Visitation</legend>

                      <div class="form-group text-center">
                        <label for="address">Address</label>
                        <input type="text" name="address" maxlength="255" value="{{old('address')?:$appointment->address}}" placeholder="address for home visit" id="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}">

                        @if ($errors->has('address'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('address') }}</strong>
                            </span>
                        @endif
                      </div>

                      <div class="form-group text-center">
                        <label for="phone">Phone Contact</label>
                        <input type="tel" name="phone" maxlength="255" value="{{old('phone')?:$appointment->phone}}" placeholder="phone for home visit" id="phone" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}">

                        @if ($errors->has('phone'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                      </div>
                    </fieldset>
                  @else 
                    <ul class="list-unstyled bg-light p-2 mb-2">
                      <li class="tf-flex p-1">
                        <span><i class="fa fa-calendar"></i> Date</span>
                        <span class="text-bold">{{$appointment->day}}</span>
                      </li>

                      <li class="tf-flex p-1">
                        <span><i class="fa fa-clock"></i> Time</span>
                        <span class="text-bold">{{$appointment->start_time}} - {{$appointment->end_time}}</span>
                      </li>

                      <li class="tf-flex p-1">
                        <span><i class="fa fa-stopwatch"></i> Duration</span>
                        <span class="text-bold"><span>{{ $appointment->duration }}</span></span>
                      </li>

                      <li class="tf-flex p-1">
                        <span><i class="fa fa-donate"></i> Fee</span>
                        <span class="text-bold">
                          <span style="font-size: 14px;" class="badge badge-secondary badge-pill">
                          ${{$appointment->fee}}
                          </span>
                        </span>
                      </li>

                      <hr>
                      <em title="Appointment status">{{$appointment->statusText()}}</em>
                    </ul>
                  @endif
                  <!-- END - If not accepted yet -->
                  <hr>

                  <div class="form-group text-center bg-info rounded p-2">
                    <label for="description" class="mb-0">Edit Description</label>
                    <textarea name="description" id="description" style="min-height: 120px;max-height: 150px;" placeholder="Describe in details why you are requesting this appointment" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" required>{{old('description')?:$appointment->description}}</textarea>

                    @if ($errors->has('description'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('description') }}</strong>
                        </span>
                    @endif
                  </div> 

                  @if ($appointment->status == '2')
                  <hr>
                  <h2 class="">Add More Details Below</h2>

                  <fieldset id="extra-details" class="p-3 mb-2 border-1 bg-info rounded">

                    <div class="form-group text-left">
                      <label for="illness_duration" class="mb-0 text-sm">Duration of Illness</label>
                      <input type="text" name="illness_duration" maxlength="255" value="{{old('illness_duration')?:$appointment->illness_duration}}" placeholder="eg 3 days, 1 week..." id="illness_duration" class="form-control{{ $errors->has('illness_duration') ? ' is-invalid' : '' }}">

                      @if ($errors->has('illness_duration'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('illness_duration') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="form-group text-left">
                      <label for="illness_history" class="mb-0 text-sm">History of Illness</label>
                      <textarea name="illness_history" id="illness_history" style="min-height: 120px;max-height: 150px;" placeholder="Short detail about when it starts, how often, medications used in the past etc..." class="form-control{{ $errors->has('illness_history') ? ' is-invalid' : '' }}">{{old('illness_history')?:$appointment->illness_history}}</textarea>

                      @if ($errors->has('illness_history'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('illness_history') }}</strong>
                          </span>
                      @endif
                    </div>
                  </fieldset>
                  @endif

                  <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Update</button>
                  </div>
                </form>

              </div>

              <div class="card-footer">
                <span class="text-danger text-small"><b>Make sure your medical history is properly created in your profile.</b></span>
              </div>
            </div>
<div class="card card-primary text-center shadow">
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
                        <select id="type" name="type" class="form-control{{ $errors->has('type') ? ' is-invalid' : '' }}" required>
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

                    <div id="deal" class="p-2 my-2 text-left" style="border-radius:4px;border:1px solid #ccc;font-size: 12px;display: none;">
                      <div>
                        <span class="border-bottom text-uppercase">Total Duration</span> <br>
                        <span class="tf-flex">
                          <strong id="duration"></strong>
                          <kbd><span id="no_of_sessions"></span> sessions @ {{$doctor->session}}mins/session</kbd>
                        </span>
                      </div>

                      <div>
                        <span class="border-bottom text-uppercase">Total Fee</span> <br>
                        <span class="tf-flex">
                          <span>$<strong id="cost"></strong></span>
                          <kbd>@ ${{$doctor->rate}}/session</kbd>
                        </span>
                      </div>
                      <input id="session" value="{{$doctor->session}}" type="hidden">
                      <input id="rate" value="{{$doctor->rate}}" type="hidden">
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
                    <textarea name="description" id="description" style="min-height: 120px;max-height: 150px;" placeholder="write your intention for booking an appointment with {{$doctor->name}}" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" required>{{old('description')}}</textarea>

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
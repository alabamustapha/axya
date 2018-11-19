<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      Schedules
    </h3>
  </div>
  <div class="card-body box-profile">
    <div class="table-responsive">

      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>Day</th>
            <th>Periods</th>
          </tr>
        </thead>

        <tbody>
          <!-- Sunday -->
          <tr>
            <th class="tf-flex">Sunday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor="{{ $doctor }}" :the_day="4" inline-template v-cloak>
                <table v-if="creating" class="w-100">
                  <tr>
                    <td class="tf-flex-ctrl">
                      <div>
                        <span class="d-inline-block">Start: <input type="time" maxlength="11" name="start_at" placeholder="eg 23:15 PM" pattern="" id="start_at" class="form-control" required></span>
                        
                        <span class="d-inline-block">End: <input type="time" maxlength="11" name="end_at" placeholder="eg 01:30 AM" pattern="" id="end_at" class="form-control" required></span>
                      </div>

                      @include('doctors.partials._schedule-controls')
                    </td>
                  </tr>
                </table>

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i> Add New</button>
                    </td>
                  </tr>
                  @forelse($sun_schedules as $sunschedule)
                    <tr>
                      <td class="w-100">

                        <!-- The Sub Template Section-->
                        <schedule :the_doctor="{{ $doctor }}" :the_schedule="{{ $sunschedule }}" inline-template v-cloak>
                          <div class="tf-flex-ctrl">
                            <div v-if="editing">
                              <span class="d-inline-block mr-2">
                                Start: <input value="{{$sunschedule->start_at}}" type="text" maxlength="8" name="start_at" placeholder="eg 23:15:00" style="width:100px;" pattern="" id="start_at" class="form-control" required>
                              </span>
                              
                              <span class="d-inline-block mr-2">
                                End: <input value="{{$sunschedule->end_at}}" type="text" maxlength="8" name="end_at" placeholder="eg 01:30:00" style="width:100px;" pattern="" id="end_at" class="form-control" required>
                              </span>
                            </div>

                            <div v-else>
                              <span>{{$sunschedule->start}} - {{$sunschedule->end}}</span>
                            </div>

                            @include('doctors.partials._schedule-controls')
                          </div>
                        </schedule>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="d-flex justify-content-center">
                        <span title="Not Available">-na-</span>
                      </td>
                    </tr>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Monday -->
          <tr>
            <th class="tf-flex">Monday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor="{{ $doctor }}" :the_day="4" inline-template v-cloak>
                <table v-if="creating" class="w-100">
                  <tr>
                    <td class="tf-flex-ctrl">
                      <div>
                        <span class="d-inline-block">Start: <input type="time" maxlength="11" name="start_at" placeholder="eg 23:15 PM" pattern="" id="start_at" class="form-control" required></span>
                        
                        <span class="d-inline-block">End: <input type="time" maxlength="11" name="end_at" placeholder="eg 01:30 AM" pattern="" id="end_at" class="form-control" required></span>
                      </div>

                      @include('doctors.partials._schedule-controls')
                    </td>
                  </tr>
                </table>

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i> Add New</button>
                    </td>
                  </tr>
                  @forelse($mon_schedules as $monschedule)
                    <tr>
                      <td class="w-100">

                        <!-- The Sub Template Section-->
                        <schedule :the_doctor="{{ $doctor }}" :the_schedule="{{ $monschedule }}" inline-template v-cloak>
                          <div class="tf-flex-ctrl">
                            <div v-if="editing">
                              <span class="d-inline-block mr-2">
                                Start: <input value="{{$monschedule->start_at}}" type="text" maxlength="8" name="start_at" placeholder="eg 23:15:00" style="width:100px;" pattern="" id="start_at" class="form-control" required>
                              </span>
                              
                              <span class="d-inline-block mr-2">
                                End: <input value="{{$monschedule->end_at}}" type="text" maxlength="8" name="end_at" placeholder="eg 01:30:00" style="width:100px;" pattern="" id="end_at" class="form-control" required>
                              </span>
                            </div>

                            <div v-else>
                              <span>{{$monschedule->start}} - {{$monschedule->end}}</span>
                            </div>

                            @include('doctors.partials._schedule-controls')
                          </div>
                        </schedule>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="d-flex justify-content-center">
                        <span title="Not Available">-na-</span>
                      </td>
                    </tr>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Tuesday -->
          <tr>
            <th class="tf-flex">Tuesday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor="{{ $doctor }}" :the_day="4" inline-template v-cloak>
                <table v-if="creating" class="w-100">
                  <tr>
                    <td class="tf-flex-ctrl">
                      <div>
                        <span class="d-inline-block">Start: <input type="time" maxlength="11" name="start_at" placeholder="eg 23:15 PM" pattern="" id="start_at" class="form-control" required></span>
                        
                        <span class="d-inline-block">End: <input type="time" maxlength="11" name="end_at" placeholder="eg 01:30 AM" pattern="" id="end_at" class="form-control" required></span>
                      </div>

                      @include('doctors.partials._schedule-controls')
                    </td>
                  </tr>
                </table>

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i> Add New</button>
                    </td>
                  </tr>
                  @forelse($tue_schedules as $tueschedule)
                    <tr>
                      <td class="w-100">

                        <!-- The Sub Template Section-->
                        <schedule :the_doctor="{{ $doctor }}" :the_schedule="{{ $tueschedule }}" inline-template v-cloak>
                          <div class="tf-flex-ctrl">
                            <div v-if="editing">
                              <span class="d-inline-block mr-2">
                                Start: <input value="{{$tueschedule->start_at}}" type="text" maxlength="8" name="start_at" placeholder="eg 23:15:00" style="width:100px;" pattern="" id="start_at" class="form-control" required>
                              </span>
                              
                              <span class="d-inline-block mr-2">
                                End: <input value="{{$tueschedule->end_at}}" type="text" maxlength="8" name="end_at" placeholder="eg 01:30:00" style="width:100px;" pattern="" id="end_at" class="form-control" required>
                              </span>
                            </div>

                            <div v-else>
                              <span>{{$tueschedule->start}} - {{$tueschedule->end}}</span>
                            </div>

                            @include('doctors.partials._schedule-controls')
                          </div>
                        </schedule>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="d-flex justify-content-center">
                        <span title="Not Available">-na-</span>
                      </td>
                    </tr>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Wednesday -->
          <tr>
            <th class="tf-flex">Wednesday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor="{{ $doctor }}" :the_day="4" inline-template v-cloak>
                <table v-if="creating" class="w-100">
                  <tr>
                    <td class="tf-flex-ctrl">
                      <div>
                        <span class="d-inline-block">Start: <input type="time" maxlength="11" name="start_at" placeholder="eg 23:15 PM" pattern="" id="start_at" class="form-control" required></span>
                        
                        <span class="d-inline-block">End: <input type="time" maxlength="11" name="end_at" placeholder="eg 01:30 AM" pattern="" id="end_at" class="form-control" required></span>
                      </div>

                      @include('doctors.partials._schedule-controls')
                    </td>
                  </tr>
                </table>

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i> Add New</button>
                    </td>
                  </tr>
                  @forelse($wed_schedules as $wedschedule)
                    <tr>
                      <td class="w-100">

                        <!-- The Sub Template Section-->
                        <schedule :the_doctor="{{ $doctor }}" :the_schedule="{{ $wedschedule }}" inline-template v-cloak>
                          <div class="tf-flex-ctrl">
                            <div v-if="editing">
                              <span class="d-inline-block mr-2">
                                Start: <input value="{{$wedschedule->start_at}}" type="text" maxlength="8" name="start_at" placeholder="eg 23:15:00" style="width:100px;" pattern="" id="start_at" class="form-control" required>
                              </span>
                              
                              <span class="d-inline-block mr-2">
                                End: <input value="{{$wedschedule->end_at}}" type="text" maxlength="8" name="end_at" placeholder="eg 01:30:00" style="width:100px;" pattern="" id="end_at" class="form-control" required>
                              </span>
                            </div>

                            <div v-else>
                              <span>{{$wedschedule->start}} - {{$wedschedule->end}}</span>
                            </div>

                            @include('doctors.partials._schedule-controls')
                          </div>
                        </schedule>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="d-flex justify-content-center">
                        <span title="Not Available">-na-</span>
                      </td>
                    </tr>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Thursday -->
          <tr>
            <th class="tf-flex">Thursday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor="{{ $doctor }}" :the_day="5" inline-template v-cloak>
                <table v-if="creating" class="w-100">
                  <tr>
                    <td class="tf-flex-ctrl">
                      <div>
                        <span class="d-inline-block">Start: <input type="time" maxlength="11" name="start_at" placeholder="eg 23:15 PM" pattern="" id="start_at" class="form-control" required></span>
                        
                        <span class="d-inline-block">End: <input type="time" maxlength="11" name="end_at" placeholder="eg 01:30 AM" pattern="" id="end_at" class="form-control" required></span>
                      </div>

                      @include('doctors.partials._schedule-controls')
                    </td>
                  </tr>
                </table>

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i> Add New</button>
                    </td>
                  </tr>
                  @forelse($thu_schedules as $thuschedule)
                    <tr>
                      <td class="w-100">

                        <!-- The Sub Template Section-->
                        <schedule :the_doctor="{{ $doctor }}" :the_schedule="{{ $thuschedule }}" inline-template v-cloak>
                          <div class="tf-flex-ctrl">
                            <div v-if="editing">
                              <span class="d-inline-block mr-2">
                                Start: <input value="{{$thuschedule->start_at}}" type="text" maxlength="8" name="start_at" placeholder="eg 23:15:00" style="width:100px;" pattern="" id="start_at" class="form-control" required>
                              </span>
                              
                              <span class="d-inline-block mr-2">
                                End: <input value="{{$thuschedule->end_at}}" type="text" maxlength="8" name="end_at" placeholder="eg 01:30:00" style="width:100px;" pattern="" id="end_at" class="form-control" required>
                              </span>
                            </div>

                            <div v-else>
                              <span>{{$thuschedule->start}} - {{$thuschedule->end}}</span>
                            </div>

                            @include('doctors.partials._schedule-controls')
                          </div>
                        </schedule>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="d-flex justify-content-center">
                        <span title="Not Available">-na-</span>
                      </td>
                    </tr>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Friday -->
          <tr>
            <th class="tf-flex">Friday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor="{{ $doctor }}" :the_day="6" inline-template v-cloak>
                <table v-if="creating" class="w-100">
                  <tr>
                    <td class="tf-flex-ctrl">
                      <div>
                        <span class="d-inline-block">Start: <input type="time" maxlength="11" name="start_at" placeholder="eg 23:15 PM" pattern="" id="start_at" class="form-control" required></span>
                        
                        <span class="d-inline-block">End: <input type="time" maxlength="11" name="end_at" placeholder="eg 01:30 AM" pattern="" id="end_at" class="form-control" required></span>
                      </div>

                      @include('doctors.partials._schedule-controls')
                    </td>
                  </tr>
                </table>

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i> Add New</button>
                    </td>
                  </tr>
                  @forelse($fri_schedules as $frischedule)
                    <tr>
                      <td class="w-100">

                        <!-- The Sub Template Section-->
                        <schedule :the_doctor="{{ $doctor }}" :the_schedule="{{ $frischedule }}" inline-template v-cloak>
                          <div class="tf-flex-ctrl">
                            <div v-if="editing">
                              <span class="d-inline-block mr-2">
                                Start: <input value="{{$frischedule->start_at}}" type="text" maxlength="8" name="start_at" placeholder="eg 23:15:00" style="width:100px;" pattern="" id="start_at" class="form-control" required>
                              </span>
                              
                              <span class="d-inline-block mr-2">
                                End: <input value="{{$frischedule->end_at}}" type="text" maxlength="8" name="end_at" placeholder="eg 01:30:00" style="width:100px;" pattern="" id="end_at" class="form-control" required>
                              </span>
                            </div>

                            <div v-else>
                              <span>{{$frischedule->start}} - {{$frischedule->end}}</span>
                            </div>

                            @include('doctors.partials._schedule-controls')
                          </div>
                        </schedule>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="d-flex justify-content-center">
                        <span title="Not Available">-na-</span>
                      </td>
                    </tr>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Saturday -->
          <tr>
            <th class="tf-flex">Saturday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor="{{ $doctor }}" :the_day="6" inline-template v-cloak>
                <table v-if="creating" class="w-100">
                  <tr>
                    <td class="tf-flex-ctrl">
                      <div>
                        <span class="d-inline-block">Start: <input type="time" maxlength="11" name="start_at" placeholder="eg 23:15 PM" pattern="" id="start_at" class="form-control" required></span>
                        
                        <span class="d-inline-block">End: <input type="time" maxlength="11" name="end_at" placeholder="eg 01:30 AM" pattern="" id="end_at" class="form-control" required></span>
                      </div>

                      @include('doctors.partials._schedule-controls')
                    </td>
                  </tr>
                </table>

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i> Add New</button>
                    </td>
                  </tr>
                  @forelse($sat_schedules as $satschedule)
                    <tr>
                      <td class="w-100">

                        <!-- The Sub Template Section-->
                        <schedule :the_doctor="{{ $doctor }}" :the_schedule="{{ $satschedule }}" inline-template v-cloak>
                          <div class="tf-flex-ctrl">
                            <div v-if="editing">
                              <span class="d-inline-block mr-2">
                                Start: <input value="{{$satschedule->start_at}}" type="text" maxlength="8" name="start_at" placeholder="eg 23:15:00" style="width:100px;" pattern="" id="start_at" class="form-control" required>
                              </span>
                              
                              <span class="d-inline-block mr-2">
                                End: <input value="{{$satschedule->end_at}}" type="text" maxlength="8" name="end_at" placeholder="eg 01:30:00" style="width:100px;" pattern="" id="end_at" class="form-control" required>
                              </span>
                            </div>

                            <div v-else>
                              <span>{{$satschedule->start}} - {{$satschedule->end}}</span>
                            </div>

                            @include('doctors.partials._schedule-controls')
                          </div>
                        </schedule>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td class="d-flex justify-content-center">
                        <span title="Not Available">-na-</span>
                      </td>
                    </tr>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>
          <!-- \. Saturday -->
        </tbody>
      </table>

    </div>
  </div>
</div>
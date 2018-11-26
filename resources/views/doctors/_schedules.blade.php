<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      Schedules
    </h3>
  </div>
  <div class="card-body box-profile">
    <div class="table-responsive">

      <table class="table table-sm">
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
              <schedule :the_doctor_id="{{ $doctor->id }}" :the_day_id="1" inline-template v-cloak>
                
                @include('doctors.partials._create-schedule')

                <table v-else class="w-100 table-borderless">
                  <tr>
                    <td rowspan="{{$sun_schedules->count()}}">                    
                      <button @click="create" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
                    </td>
                    <td>
                      <table class="w-100 table-striped">
                        @forelse($sun_schedules as $schedule)
                    
                          <tr>
                            @include('doctors.partials._show-schedule')
                          </tr>
                        @empty
                          <tr>
                            <td class="d-flex justify-content-center">
                              <span title="Not Available">-na-</span>
                            </td>
                          </tr>
                        @endforelse
                      </table>
                    </td>
                  </tr>
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Monday -->
          <tr>
            <th class="tf-flex">Monday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor_id="{{ $doctor->id }}" :the_day_id="2" inline-template v-cloak>
                
                @include('doctors.partials._create-schedule')

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
                    </td>
                    <td>
                      <table class="w-100 table-striped">
                        @forelse($mon_schedules as $schedule)
                    
                          <tr>
                            @include('doctors.partials._show-schedule')
                          </tr>
                        @empty
                          <tr>
                            <td class="d-flex justify-content-center">
                              <span title="Not Available">-na-</span>
                            </td>
                          </tr>
                        @endforelse
                      </table>
                    </td>
                  </tr>
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Tuesday -->
          <tr>
            <th class="tf-flex">Tuesday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor_id="{{ $doctor->id }}" :the_day_id="3" inline-template v-cloak>
                
                @include('doctors.partials._create-schedule')

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
                    </td>
                    <td>
                      <table class="w-100 table-striped">
                        @forelse($tue_schedules as $schedule)
                    
                          <tr>
                            @include('doctors.partials._show-schedule')
                          </tr>
                        @empty
                          <tr>
                            <td class="d-flex justify-content-center">
                              <span title="Not Available">-na-</span>
                            </td>
                          </tr>
                        @endforelse
                      </table>
                    </td>
                  </tr>
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Wednesday -->
          <tr>
            <th class="tf-flex">Wednesday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor_id="{{ $doctor->id }}" :the_day_id="4" inline-template v-cloak>
                
                @include('doctors.partials._create-schedule')

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
                    </td>
                    <td>
                      <table class="w-100 table-striped">
                        @forelse($wed_schedules as $schedule)
                    
                          <tr>
                            @include('doctors.partials._show-schedule')
                          </tr>
                        @empty
                          <tr>
                            <td class="d-flex justify-content-center">
                              <span title="Not Available">-na-</span>
                            </td>
                          </tr>
                        @endforelse
                      </table>
                    </td>
                  </tr>
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Thursday -->
          <tr>
            <th class="tf-flex">Thursday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor_id="{{ $doctor->id }}" :the_day_id="5" inline-template v-cloak>
                
                @include('doctors.partials._create-schedule')

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
                    </td>
                    <td>
                      <table class="w-100 table-striped">
                        @forelse($thu_schedules as $schedule)
                    
                          <tr>
                            @include('doctors.partials._show-schedule')
                          </tr>
                        @empty
                          <tr>
                            <td class="d-flex justify-content-center">
                              <span title="Not Available">-na-</span>
                            </td>
                          </tr>
                        @endforelse
                      </table>
                    </td>
                  </tr>
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Friday -->
          <tr>
            <th class="tf-flex">Friday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor_id="{{ $doctor->id }}" :the_day_id="6" inline-template v-cloak>
                
                @include('doctors.partials._create-schedule')

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
                    </td>
                    <td>
                      <table class="w-100 table-striped">
                        @forelse($fri_schedules as $schedule)
                    
                          <tr>
                            @include('doctors.partials._show-schedule')
                          </tr>
                        @empty
                          <tr>
                            <td class="d-flex justify-content-center">
                              <span title="Not Available">-na-</span>
                            </td>
                          </tr>
                        @endforelse
                      </table>
                    </td>
                  </tr>
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Saturday -->
          <tr>
            <th class="tf-flex">Saturday</th>
          
            <td>
              <!-- The Main Template -->
              <schedule :the_doctor_id="{{ $doctor->id }}" :the_day_id="7" inline-template v-cloak>
                
                @include('doctors.partials._create-schedule')

                <table v-else class="w-100">
                  <tr>
                    <td>                    
                      <button @click="creating = true" class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
                    </td>
                    <td>
                      <table class="w-100 table-striped">
                        @forelse($sat_schedules as $schedule)
                    
                          <tr>
                            @include('doctors.partials._show-schedule')
                          </tr>
                        @empty
                          <tr>
                            <td class="d-flex justify-content-center">
                              <span title="Not Available">-na-</span>
                            </td>
                          </tr>
                        @endforelse
                      </table>
                    </td>
                  </tr>
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
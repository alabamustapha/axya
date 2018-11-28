<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title"> Schedules </h3>

    <span class="card-tools">
      <button type="button" class="btn btn-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </span>
  </div>
  <div class="card-body box-profile" style="font-size:90%">
    <div class="table-responsive">

      <table class="table table-sm table-striped">
        <thead>
          <tr>
            <th>Day</th>
            <th>Available Between</th>
          </tr>
        </thead>

        <tbody>
          <!-- Sunday -->
          <tr>
            <th class="tf-flex">Sunday</th>
          
            <td>
                <table class="w-100">
                  @forelse($sun_schedules as $sunschedule)
                    <tr>
                      <td class="w-100">
                        
                        <span>{{$sunschedule->start}} - {{$sunschedule->end}}</span>
                        
                      </td>
                    </tr>
                  @empty
                    <td class="d-flex justify-content-center">
                      <span title="Not Available">-na-</span>
                    </td>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Monday -->
          <tr>
            <th class="tf-flex">Monday</th>
          
            <td>
                <table class="w-100">
                  @forelse($mon_schedules as $monschedule)
                    <tr>
                      <td class="w-100">
                        
                        <span>{{$monschedule->start}} - {{$monschedule->end}}</span>
                        
                      </td>
                    </tr>
                  @empty
                    <td class="d-flex justify-content-center">
                      <span title="Not Available">-na-</span>
                    </td>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Tuesday -->
          <tr>
            <th class="tf-flex">Tuesday</th>
          
            <td>
                <table class="w-100">
                  @forelse($tue_schedules as $tueschedule)
                    <tr>
                      <td class="w-100">
                        
                        <span>{{$tueschedule->start}} - {{$tueschedule->end}}</span>
                        
                      </td>
                    </tr>
                  @empty
                    <td class="d-flex justify-content-center">
                      <span title="Not Available">-na-</span>
                    </td>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Wednesday -->
          <tr>
            <th class="tf-flex">Wednesday</th>
          
            <td>
                <table class="w-100">
                  @forelse($wed_schedules as $wedschedule)
                    <tr>
                      <td class="w-100">
                        
                        <span>{{$wedschedule->start}} - {{$wedschedule->end}}</span>
                        
                      </td>
                    </tr>
                  @empty
                    <td class="d-flex justify-content-center">
                      <span title="Not Available">-na-</span>
                    </td>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Thursday -->
          <tr>
            <th class="tf-flex">Thursday</th>
          
            <td>
                <table class="w-100">
                  @forelse($thu_schedules as $thuschedule)
                    <tr>
                      <td class="w-100">
                        
                        <span>{{$thuschedule->start}} - {{$thuschedule->end}}</span>
                        
                      </td>
                    </tr>
                  @empty
                    <td class="d-flex justify-content-center">
                      <span title="Not Available">-na-</span>
                    </td>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Friday -->
          <tr>
            <th class="tf-flex">Friday</th>
          
            <td>
                <table class="w-100">
                  @forelse($fri_schedules as $frischedule)
                    <tr>
                      <td class="w-100">
                        
                        <span>{{$frischedule->start}} - {{$frischedule->end}}</span>
                        
                      </td>
                    </tr>
                  @empty
                    <td class="d-flex justify-content-center">
                      <span title="Not Available">-na-</span>
                    </td>
                  @endforelse
                </table>
              </schedule>
            </td>
          </tr>

          <!-- Saturday -->
          <tr>
            <th class="tf-flex">Saturday</th>
          
            <td>
                <table class="w-100">
                  @forelse($sat_schedules as $satschedule)
                    <tr>
                      <td class="w-100">
                        
                        <span>{{$satschedule->start}} - {{$satschedule->end}}</span>
                        
                      </td>
                    </tr>
                  @empty
                    <td class="d-flex justify-content-center">
                      <span title="Not Available">-na-</span>
                    </td>
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
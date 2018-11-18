<div class="card card-dark">
  <div class="card-header">
    <h3 class="card-title">
      Schedules
    </h3>
  </div>
  <div class="card-body box-profile">

    <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th>Day</th>
          <th>Periods</th>
        </tr>
      </thead>

      <tbody>
        <tr>
          <th>
            <span class="tf-flex">
              Sunday
              <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
            </th>
          </span>Sunday 
            @forelse($sun_schedules as $sunschedule)
              <td class="tf-flex">
                <span>{{$sunschedule->start}} - {{$sunschedule->end}}</span>
                <span class="w-25 tf-flex">
                  <span data-toggle="modal" data-target="#updateScheduleForm" title=" Update time">
                    <i class="fa fa-edit teal"></i> 
                  </span>
                  / 
                  <i class="fa fa-times red"></i>
                </span>
              </td>
            @empty
              <td class="d-flex justify-content-center">
                <span title="Not Available">-na-</span>
              </td>
            @endforelse
        </tr>
        <tr>
          <th>
            <span class="tf-flex">
              Monday 
              <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
            </span>
          </th>
            @forelse($mon_schedules as $monschedule)
              <td class="tf-flex">
                <span>{{$monschedule->start}} - {{$monschedule->end}}</span>
                <span class="w-25 tf-flex">
                  <span data-toggle="modal" data-target="#updateScheduleForm" title=" Update time">
                    <i class="fa fa-edit teal"></i> 
                  </span>
                  / 
                  <i class="fa fa-times red"></i>
                </span>
              </td>
            @empty
              <td class="d-flex justify-content-center">
                <span title="Not Available">-na-</span>
              </td>
            @endforelse
        </tr>
        <tr>
          <th>
            <span class="tf-flex">
              Tuesday 
              <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
            </span>
          </th>
            @forelse($tue_schedules as $tueschedule)
              <td class="tf-flex">
                <span>{{$tueschedule->start}} - {{$tueschedule->end}}</span>
                <span class="w-25 tf-flex">
                  <span data-toggle="modal" data-target="#updateScheduleForm" title=" Update time">
                    <i class="fa fa-edit teal"></i> 
                  </span>
                  / 
                  <i class="fa fa-times red"></i>
                </span>
              </td>
            @empty
              <td class="d-flex justify-content-center">
                <span title="Not Available">-na-</span>
              </td>
            @endforelse
        </tr>
        <tr>
          <th>
            <span class="tf-flex">
              Wednesday 
              <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
            </span>
          </th>
            @forelse($wed_schedules as $wedschedule)
              <td class="tf-flex">
                <span>{{$wedschedule->start}} - {{$wedschedule->end}}</span>
                <span class="w-25 tf-flex">
                  <span data-toggle="modal" data-target="#updateScheduleForm" title=" Update time">
                    <i class="fa fa-edit teal"></i> 
                  </span>
                  / 
                  <i class="fa fa-times red"></i>
                </span>
              </td>
            @empty
              <td class="d-flex justify-content-center">
                <span title="Not Available">-na-</span>
              </td>
            @endforelse
        </tr>
        <tr>
          <th>
            <span class="tf-flex">
              Thursday 
              <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
            </span>
          </th>
            @forelse($thu_schedules as $thuschedule)
              <td class="tf-flex">
                <span>{{$thuschedule->start}} - {{$thuschedule->end}}</span>
                <span class="w-25 tf-flex">
                  <span data-toggle="modal" data-target="#updateScheduleForm" title=" Update time">
                    <i class="fa fa-edit teal"></i> 
                  </span>
                  / 
                  <i class="fa fa-times red"></i>
                </span>
              </td>
            @empty
              <td class="d-flex justify-content-center">
                <span title="Not Available">-na-</span>
              </td>
            @endforelse
        </tr>
        <tr>
          <th>
            <span class="tf-flex">
              Friday 
              <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
            </span>
          </th>
            @forelse($fri_schedules as $frischedule)
              <td class="tf-flex">
                <span>{{$frischedule->start}} - {{$frischedule->end}}</span>
                <span class="w-25 tf-flex">
                  <span data-toggle="modal" data-target="#updateScheduleForm" title=" Update time">
                    <i class="fa fa-edit teal"></i> 
                  </span>
                  / 
                  <i class="fa fa-times red"></i>
                </span>
              </td>
            @empty
              <td class="d-flex justify-content-center">
                <span title="Not Available">-na-</span>
              </td>
            @endforelse
        </tr>
        <tr>
          <th>
            <span class="tf-flex">
              Saturday 
              <button class="btn btn-sm btn-primary p-1" title="Add New"><i class="fa fa-plus" style="font-size:10px;"></i></button>
            </span>
          </th>
            @forelse($sat_schedules as $satschedule)
              <td class="tf-flex">
                <span>{{$satschedule->start}} - {{$satschedule->end}}</span>
                <span class="w-25 tf-flex">
                  <span data-toggle="modal" data-target="#updateScheduleForm" title=" Update time">
                    <i class="fa fa-edit teal"></i> 
                  </span>
                  / 
                  <i class="fa fa-times red"></i>
                </span>
              </td>
            @empty
              <td class="d-flex justify-content-center">
                <span title="Not Available">-na-</span>
              </td>
            @endforelse
        </tr>
      </tbody>
    </table>
  {{-- 
    <hr>

    <table class="table table-sm table-striped">
      <thead>
        <tr>
          <th>Day</th>
          <th>Period 1</th>
          <th>Period 2</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Sunday</th>
          <td>9:00am - 12:15pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
          <td>6:30pm - 09:00pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
        </tr>
        <tr>
          <th>Monday</th>
          <td>9:00am - 12:15pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
          <td>6:30pm - 09:00pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
        </tr>
        <tr>
          <th>Tuesday</th>
          <td>9:00am - 12:15pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
          <td>6:30pm - 09:00pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
        </tr>
        <tr>
          <th>Wednesday</th>
          <td>9:00am - 12:15pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
          <td>6:30pm - 09:00pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
        </tr>
        <tr>
          <th>Thursday</th>
          <td>9:00am - 12:15pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
          <td>6:30pm - 09:00pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
        </tr>
        <tr>
          <th>Friday</th>
          <td>9:00am - 12:15pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
          <td>6:30pm - 09:00pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
        </tr>
        <tr>
          <th>Saturday</th>
          <td>9:00am - 12:15pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
          <td>
            6:30pm - 09:00pm
            <br>
            <span class="tf-flex"><i class="fa fa-edit teal"></i> / <i class="fa fa-times red"></i></span>
          </td>
        </tr>
      </tbody>
    </table> 
  --}}
  </div>
</div>
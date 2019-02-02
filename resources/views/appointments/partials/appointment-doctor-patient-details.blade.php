<div class="d-none d-sm-block">

  @if ($appointment->attendant_doctor)
    <div class="card">
      <div class="d-block" style="max-height: 180px;overflow: hidden;">
        <img class="card-img-top" src="{{Auth::user()->avatar}}" alt="Card image cap">
      </div>

      <div class="card-body p-3 px-sm-2">
        <h5 class="card-title border-bottom">Patient Details</h5>

        <dl>
          <dd>
              <span class="tf-flex">
                <span>Age:</span> <strong>{{$appointment->user->age()}}</strong>
              </span>
              <span class="tf-flex">
                <span>Gender:</span> <strong>{{$appointment->user->gender}}</strong>
              </span>
          </dd>

          <dt>Chronic Issues:</dt>
          <dd class="ml-2">{{$appointment->user->chronics}}</dd>

          <dt>Allergies:</dt>
          <dd class="ml-2">{{$appointment->user->allergies}}</dd>
        </dl>
      </div>

      <div class="card-footer">
        <a href="{{route('users.show', $appointment->user)}}" target="_blank" class="btn btn-sm btn-primary">
          <i style="width:25px;" class="fa fa-user"></i> Full Profile
        </a>
      </div>
    </div>
  @elseif ($appointment->creator)
    <div class="card">
      <div class="d-block" style="max-height: 180px;overflow: hidden;">

        <img class="card-img-top" src="{{$appointment->doctor->avatar}}" alt="Card image cap">

      </div>

      <div class="card-body p-3 px-sm-2">
        <h5 class="card-title border-bottom">Doctor Details</h5>

        <div class="card-text h6">
          <a class="text-dark text-bold" href="{{route('doctors.show', $appointment->doctor)}}" style="color:#6c757d !important;">{{$appointment->doctor->name}}</a>
        </div>

        <div class="card-text">
          <ul class="list-group list-group-unbordered mb-0">
            <li class="tf-flex list-group-item p-1 pr-3 mt-0 border-top-0" title="Specialty" title="Specialty" data-toggle="tooltip">
              <span>
                <i style="width:25px;" class="fa fa-user-md"></i> 
              </span>

              <a class="text-bold" href="{{route('specialties.show', $appointment->doctor->specialty)}}" style="color:#6c757d !important;">{{$appointment->doctor->specialty->name}}</a>
            </li>

            <li class="tf-flex list-group-item p-1 pr-3 mt-0" title="Patients Served" data-toggle="tooltip">
              <span class="d-block">
                <i style="width:25px;" class="fa fa-procedures"></i> 
              </span>
              <span>
                <span class="badge badge-primary badge-pill ">{{$appointment->doctor->patients->count()}}</span> Patients Served
              </span>
            </li>

            <li class="tf-flex list-group-item p-1 pr-3" title="Availabilty" data-toggle="tooltip">
              <span class="d-block">
                <i style="width:25px;" class="fa fa-calendar-alt"></i> 
              </span>
              <span class="text-bold">{{$appointment->doctor->available ? 'Available':'Unavailable'}}</span>
            </li>

            <li class="tf-flex p-1 pr-3" title="Practice Years" data-toggle="tooltip">
              <span class="d-block">
                <i style="width:25px;" class="fa fa-calendar"></i> 
              </span>
              <span class="text-bold">{{$appointment->doctor->practice_years}} Practice Years</span>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-footer">
        <a href="{{route('doctors.show', $appointment->doctor)}}" target="_blank" class="btn btn-sm btn-primary">
          <i style="width:25px;" class="fa fa-user-md"></i> Full Profile
        </a>
      </div>
    </div>
  @endif
</div>
<div class="list-group">

  <div class="list-group-item" title="You are {{$doctor->isActive() ? 'available for appointments':'unavailable for appointments'}} on this platform.">
    <div class="tf-flex border-bottom pb-2">
      <span class="font-weight-bold">YOUR STATUS: </span>
      <span class="d-inline-block bg-{{$doctor->isActive() ? 'success':'danger'}} avail-indicator"></span>
    </div>
    <span class="text-sm pt-2">
      <small>All the options below must be <strong class="text-success">green</strong> for you to be <strong>available</strong> for appoitnments.</small>
    </span>
  </div>
  
  <div class="list-group-item bg-light">
    <ul class="list-unstyled">

      <li class="border-bottom">
        <div class="tf-flex pt-2">
          <span class="font-weight-bold">
            <i class="fa fa-id-card fa-fw"></i>License </span>
          <span class="d-inline-block bg-{{$doctor->isSuspended() ? 'danger':'success'}} avail-indicator"></span>
        </div>

        <span class="text-sm text-left">
          <small class="text-{{$doctor->isSuspended() ? 'danger':''}}">
            Your license on this platform is {{$doctor->isSuspended() ? 'Revoked':'Active'}}.
            @if ($doctor->isSuspended()) 
              <a class="text-primary px-1" href="#">Contact support</a>
            @endif
          </small>
        </span>
      </li>

      <li class="border-bottom">
        <div class="tf-flex pt-2">
          <span class="font-weight-bold">
            <i class="fa fa-rss fa-fw"></i>Subscription </span>
          <span class="d-inline-block bg-{{$doctor->isSubscribed() ? 'success':'danger'}} avail-indicator"></span>
        </div>

        <span class="text-sm text-left">
          <small class="text-{{$doctor->isSubscribed() ? '':'danger'}}">
            You have {{$doctor->isSubscribed() ? 'Active':'Inactive'}} subscription on this platform. 
            <a class="text-primary px-1" href="{{ route('subscription_plans.index') }}" title="Extend your subscription">{{$doctor->isSubscribed() ? 'Extend subscription':'Subscribe now'}}</a>
          </small>
        </span>
      </li>

      <li class="border-bottom">
        <div class="tf-flex pt-2">
          <span class="font-weight-bold">
            <i class="fa fa-user-md fa-fw"></i>Availability </span>
          <span class="d-inline-block bg-{{$doctor->isAvailable() ? 'success':'danger'}} avail-indicator"></span>
        </div>

        <span class="text-sm text-left">
          <small class="text-{{$doctor->isAvailable() ? '':'danger'}}">
            You are {{$doctor->isAvailable() ? 'open':'not open'}} for appointments at this time. 
            <a class="text-primary px-1" href="{{ route('doctors.edit', $doctor) }}#available">Change Availability</a>
          </small>
        </span>
      </li>

      <li class="">
        <div class="tf-flex pt-2">
          <span class="font-weight-bold">
            <i class="fa fa-user-md fa-fw"></i>Schedules </span>
          <span class="d-inline-block bg-{{$doctor->hasSchedules() ? 'success':'danger'}} avail-indicator"></span>
        </div>

        <span class="text-sm text-left">
          <small class="text-{{$doctor->hasSchedules() ? '':'danger'}}">
            You have {{$doctor->hasSchedules() ? 'set':'no set'}} schedules. 
            <a class="text-primary px-1" href="{{ route('doctors.show', $doctor) }}#schedules">Edit schedules</a>
          </small>
        </span>
      </li>
    </ul>
  </div>

</div>
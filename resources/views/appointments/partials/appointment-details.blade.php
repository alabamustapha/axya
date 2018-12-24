
<div class="d-block m-auto text-center bg-white">

  <div class="text-left shadow-lg p-3 mb-3">
    <h6 title="appointment status">
      {{$appointment->statusTextOutput()}}
    </h6>

    <hr>
    
    <p>{{$appointment->patient_info}}</p>
  </div>
</div>

<div class="card">
  <div class="card-header bg-primary text-center p-2 mb-0">
    <span class="h4">Appointment Details</span>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="card-body p-2">
    <ul class="list-unstyled">
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
          ${{$appointment->doctor->rate}}
          </span>
        </span>
      </li>

      <hr>
      <p title="Appointment status">{{$appointment->statusText()}}</p>
    </ul>
  </div>
  <div class="card-footer">
    <ul class="list-unstyled">
      @if ($appointment->attendant_doctor)
        <li>
          <button class="btn btn-sm my-1 btn-primary">Accept & Confirm</button>
        </li>
        <li>
          <button class="btn btn-sm my-1 btn-danger">Reject</button>
        </li>
      @elseif ($appointment->creator)
        <li>
          <button class="btn btn-sm my-1 btn-primary">Pay Consultation Fee</button>
        </li>
        <li>
          <button class="btn btn-sm my-1 btn-danger">Cancel</button>
        </li>  
      @endif
      {{-- @if ($appointment->durationPassed()) --}}
        <li>
          <button class="btn btn-sm my-1 btn-secondary">Appointment Completed?</button>
        </li>

        @if ($appointment->creator)
        <li class="text-bold">
          <button class="btn btn-sm my-1 btn-info mb-3"><i class="fa fa-star"></i> Rate This Doctor</button>
          
          @include('doctors.partials.review-form')
        </li>
        @endif
      {{-- @endif --}}
    </ul>
  </div>
</div>
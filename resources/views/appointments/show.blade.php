@extends('layouts.master')

@section('title', $appointment->user->name .' Appointments - '. $appointment->day)

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-4 bg-primary text-secondary p-2 text-small" style="max-height: 80vh;display: block;overflow-y: scroll;">

      <div class="d-block m-auto text-center bg-white">

        {{-- <div class="row"> --}}
          <div class="text-left shadow-lg p-3 mb-3">
            <h4>{{$appointment->statusText()}}</h4>
            <hr>
             <p>{{$appointment->patient_info}}</p>
          </div>
        {{-- </div> --}}
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
              <span>Date</span>
              <span class="text-bold">{{$appointment->day}}</span>
            </li>

            <li class="tf-flex p-1">
              <span>Time</span>
              <span class="text-bold">{{$appointment->from}} - {{$appointment->to}}</span>
            </li>

            <li class="tf-flex p-1">
              <span>Duration</span>
              <span class="text-bold"><span class="badge badge-info">{{--$appointment->duration--}}</span></span>
            </li>

            <li class="tf-flex p-1">
              <span>Fee</span>
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
            @if (Auth::user() == $appointment->doctor)
              <li>
                <button class="btn btn-sm my-1 btn-primary">Accept & Confirm</button>
              </li>
              <li>
                <button class="btn btn-sm my-1 btn-info">Recommend Other</button>
              </li>
              <li>
                <button class="btn btn-sm my-1 btn-danger">Reject</button>
              </li>
            @elseif (Auth::user() == $appointment->user)
              <li>
                <button class="btn btn-sm my-1 btn-primary">Pay Consultation Fee</button>
              </li>
              <li>
                <button class="btn btn-sm my-1 btn-info">Change Time</button>
              </li>
              <li>
                <button class="btn btn-sm my-1 btn-danger">Cancel</button>
              </li>  
            @endif
              <li>
                <button class="btn btn-sm my-1 btn-secondary">Appointment Completed</button>
              </li>  
          </ul>
        </div>
      </div>

      <div class="d-none d-sm-block">

        {{-- @if (Auth::user() == $appointment->doctor) --}}
        {{-- @if ($appointment->attendantDoctor()) --}}
          <div class="card">
            <img class="card-img-top" src=".../100px180/" alt="Card image cap">
            <div class="card-header">
              <h5 class="card-title">Patient Details</h5>
            </div>

            <div class="card-body p-3 px-sm-2">
              <dl>
                <dt>Bio:</dt>
                <dd class="ml-2">
                  <span>
                    <span class="h5">{{$appointment->user->name}}</span> is a {{$appointment->user->age()}} years old {{$appointment->user->gender}}. Weighs {{$appointment->user->weight}} kg and is {{$appointment->user->height}}m in height.
                  </span>
                </dd>

                <dt>Chronic Issues:</dt>
                <dd class="ml-2"><span>{{$appointment->user->chronics}}</span></dd>

                <dt>Allergies:</dt>
                <dd class="ml-2"><span>{{$appointment->user->allergies}}</span></dd>
              </dl>
            </div>

            <div class="card-footer">
              <a href="{{route('users.show', $appointment->user)}}" target="_blank" class="btn btn-sm btn-primary">
                <i style="width:25px;" class="fa fa-user"></i> Full Profile
              </a>
            </div>
          </div>
        {{-- @elseif (Auth::user() == $appointment->user) --}}
          <div class="card">
            <img class="card-img-top" src=".../100px180/" alt="Card image cap">
            <div class="card-header">
              <h5 class="card-title">Doctor Details</h5>
            </div>
            <div class="card-body p-3 px-sm-2">
              <p class="card-text h5 text-dark">
                <a class="text-dark" href="{{route('doctors.show', $appointment->doctor)}}">{{$appointment->doctor->user->name}}</a>
              </p>
              <p class="card-text">
                <span style="font-size: 14px;" class="badge badge-secondary badge-pill">
                  ${{$appointment->doctor->rate}} / hour
                </span>
              </p>

              <p class="card-text">
                <ul class="list-group list-group-unbordered mb-0">
                  <li class="tf-flex list-group-item p-1 pr-3 mt-0 border-top-0" title="Specialty" title="Specialty" data-toggle="tooltip">
                    <span>
                      <i style="width:25px;" class="fa fa-user-md"></i> 
                    </span>

                    <a class="text-bold" href="{{route('specialties.show', $appointment->doctor->specialty)}}" style="color:inherit;">{{$appointment->doctor->name}}</a>
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

                  <li class="tf-flex list-group-item p-1 pr-3" title="Practice Years" data-toggle="tooltip">
                    <span class="d-block">
                      <i style="width:25px;" class="fa fa-calendar"></i> 
                    </span>
                    <span class="text-bold">{{$appointment->doctor->practice_years}} Practice Years</span>
                  </li>

                  <li class="tf-flex list-group-item p-1 pr-3 border-bottom-0" title="About" data-toggle="tooltip">
                    <span class="d-block">
                      <i style="width:25px;" class="fa fa-info-circle"></i> 
                    </span>
                    <span> {{ $appointment->doctor->about }}</span>
                  </li>

                </ul>
              </p>

            </div>
            <div class="card-footer">
              <a href="{{route('doctors.show', $appointment->doctor)}}" target="_blank" class="btn btn-sm btn-primary">
                <i style="width:25px;" class="fa fa-user-md"></i> Full Profile
              </a>
            </div>
          </div>
        {{-- @endif --}}
      </div>
    </div>
    <!-- /.col-sm-4 -->

    <div class="col-sm-8 bg-dark px-3 pb-0" style="height: 80vh;display: block;overflow-y: scroll;">
      <h3 class="text-center{{--  sticky-top bg-dark --}}">Chats</h3>

      <div class="container">
        @if(1 == 1) {{-- Subscription made and time is reached --}}
          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-warning direct-chat direct-chat-warning tp-scrollbar" style="height: 80vh;display: block;overflow-y: scroll;">
            <div class="box-body text-small">
              
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">

                @forelse ($appointment->messages as $message)
                  @if ($message->hasPrescription())
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg mb-3 pb-2 w-75">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">{{$message->user->name}}</span>
                        <span class="direct-chat-timestamp pull-right">{{$message->created_at}}</span>
                      </div>

                      <img class="direct-chat-img" src="{{$message->user->avatar}}" alt="{{$message->user->name}}" style="width: 40px;height: 40px;">

                      <div class="direct-chat-text">
                        <h6 class="pb-1 border-bottom">
                          <i class="fa fa-prescription"></i>
                          {{ $message->body }}
                        </h6>

                        @php 
                          $prescription = $message->displayPrescription();
                        @endphp

                        @include('prescriptions._card')
                      </div>
                    </div>
                    <!-- /.direct-chat-msg -->
                  @elseif ($message->isAppointmentDoctor())
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg mb-3 pb-2">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">{{$message->user->name}}</span>
                        <span class="direct-chat-timestamp pull-right">{{$message->created_at}}</span>
                      </div>

                      <img class="direct-chat-img" src="{{$message->user->avatar}}" alt="{{$message->user->name}}" style="width: 40px;height: 40px;">

                      <div class="direct-chat-text">
                        {{ $message->body }}
                      </div>
                    </div>
                    <!-- /.direct-chat-msg -->
                  @elseif ($message->isAppointmentAuthor())
                    <!-- Message to the right -->
                    <div class="direct-chat-msg right mb-3 pb-2">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-right">{{$message->user->name}}</span>
                        <span class="direct-chat-timestamp pull-left">{{$message->updated_at}}</span>
                      </div>

                      <img class="direct-chat-img" src="{{$message->user->avatar}}" alt="{{$message->user->name}}" style="width: 40px;height: 40px;">

                      <div class="direct-chat-text">
                        {{ $message->body }}
                      </div>
                    </div>
                    <!-- /.direct-chat-msg -->
                  @endif
                @empty
                  <div class="empty-list">0 messages at the moment.</div>
                @endforelse
              </div>
              <!--/.direct-chat-messages-->
            </div>
            <!-- /.box-body -->

            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->

          <div class="sticky-bottom mb-0 p-0 bg-dark">
            <form action="{{route('messages.store')}}" method="post" enctype="multipart/form">
              @csrf
              <input type="hidden" name="messageable_id" value="{{$appointment->id}}"><input type="hidden" name="messageable_type" value="App\Appointment">

              <div class="container">
                <div class="row">
                  <div class="col-sm-10">            
                    <textarea name="body" id="" class="form-control" style="max-height: 70px;min-height: 70px;width:100%;display: block;overflow-y: scroll;font-size: 12px;line-height: 1;" placeholder="type a message..."></textarea>
                  </div>
                  <div class="col-sm-2 pl-sm-0">

                    <div>
                      <span id="navbarDropdown" class="dropdown-toggle btn btn-sm btn-info btn-block m-1" 
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                        title="Prescription form, Upload form etc.">
                        <i class="fa fa-cogs"></i> 
                      </span>

                      <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                        @if($appointment->attendantDoctor())
                          <span class="dropdown-item" data-toggle="modal" data-target="#newPrescriptionForm" title="Create medication/drug prescription for this consultation.">
                            <i class="fa fa-prescription teal"></i>&nbsp; Make Prescription
                          </span>
                        @endif

                        <span class="dropdown-item" title="Upload image, video or other files.">
                          <i class="fa fa-file teal"></i>&nbsp; Image/File Uploads
                        </span>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary btn-block m-1">Post</button>
                  </div>
                </div>
              </div>
            </form>
          </div>


        @else

        <div class="text-center" style="clear: both;">
          <i class="fa fa-lock text-muted" style="font-size: 100px"></i> <br><br>
          <p class="text-muted">
            Messages disabled till consultation fee is confirmed and appointment start time: {{$appointment->from}}.
          </p>
        </div>
        @endif

      </div>
    </div>
    <!-- /.col-sm-8 -->
</div>

@if($appointment->attendantDoctor())
  <div class="modal bg-transparent" tabindex="-1" role="dialog" id="newPrescriptionForm" style="display:none;" aria-labelledby="newPrescriptionFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content px-0 pb-0 m-0 bg-transparent shadow-none">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
        <div class="modal-body">

          <div class="card card-primary card-outline shadow">
            <div class="card-header">
              <div class="card-title" title="{{$appointment->patient_info}}">
                <h5 class="border-bottom"><i class="fa fa-prescription"></i>&nbsp; Prescription for:</h5>
                <p style="font-size:11px;">{{substr($appointment->patient_info, 0, 150)}}</p>
              </div>
            </div>

            <div class="card-body">
              
              <form action="{{route('prescriptions.store')}}" method="post">
                <input type="hidden" name="appointment_id" value="{{$appointment->id}}">
                {{ csrf_field() }}

                <div class="form-group border">
                  <div class="table-responsive tp-scrollbar">
                    <table class="table table-sm">
                      <tr>
                        <td>Name</td>
                        <td>Texture</td>
                        <td>Dosage</td>
                        <td>Usage</td>
                        <td>Manufacturer</td>
                      </tr>
                      <tr>
                        <td>Chloroquine{{--$drug->name--}}</td>
                        <td>tablet</td>
                        <td>200mg{{--$drug->dosage--}}</td>
                        <td>2-2-2{{--$drug->usage--}}</td>
                        <td>Emzor</td>
                      </tr>
                      <tr>
                        <td>Piritin</td>
                        <td>syrup</td>
                        <td>1tp (15ml)</td>
                        <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic a ex unde laudantium? Animi eum sapiente adipisci, voluptas optio quia eligendi quam, ea dignissimos consectetur ipsa aut earum maiores vel.</td>
                        <td>Drugfield</td>
                      </tr>
                      <tr>
                        <td>Aspirin</td>
                        <td>capsule</td>
                        <td>20mg</td>
                        <td>1-0-1</td>
                        <td>May and Baker</td>
                      </tr>
                      <tr>
                        <td>Astimycin</td>
                        <td>capsule</td>
                        <td>10mg</td>
                        <td>1-0-0</td>
                        <td></td>
                      </tr>
                    </table>                    
                  </div>
                </div>

                <div class="form-group">
                  <label for="usage">Explain How To Use</label>
                  <textarea name="usage" class="form-control{{ $errors->has('usage') ? ' is-invalid' : '' }}"  style="min-height: 100px;max-height: 150px;" placeholder="explain how to use the medications" required>{{ old('usage') }}</textarea>

                  @if ($errors->has('usage'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('usage') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <label for="usage">More comments on this prescription</label>
                  <textarea name="comment" class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}"  style="min-height: 70px;max-height: 120px;" placeholder="more comments on this prescription">{{ old('comment') }}</textarea>

                  @if ($errors->has('comment'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('comment') }}</strong>
                      </span>
                  @endif
                </div>

                <button type="submit" class="btn btn-block btn-primary">Create Prescription</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endif

@endsection
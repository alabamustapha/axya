@extends('layouts.master')

@section('title', 'Appointment - '. $appointment->day)

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-sm-4 bg-primary text-secondary p-2" style="max-height: 80vh;display: block;overflow-y: scroll;">

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
                $100.00{{--{{$appointment->doctor->rate}}--}}
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
              <a href="{{route('users.show', $appointment->user)}}" class="btn btn-sm btn-primary">
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
                  $100.00 / hour{{--{{$appointment->doctor->rate}}--}}
                </span>
              </p>

              <p class="card-text">
                <ul class="list-group list-group-unbordered mb-0">
                  <li class="tf-flex list-group-item p-1 pr-3 mt-0 border-top-0" title="Specialty" title="Specialty" data-toggle="tootltip">
                    <span>
                      <i style="width:25px;" class="fa fa-user-md"></i> 
                    </span>

                    <a class="text-bold" href="{{route('specialties.show', $appointment->doctor->specialty)}}" style="color:inherit;">{{$appointment->doctor->specialty->name}}</a>
                  </li>

                  <li class="tf-flex list-group-item p-1 pr-3 mt-0" title="Patients Served" data-toggle="tootltip">
                    <span class="d-block">
                      <i style="width:25px;" class="fa fa-procedures"></i> 
                    </span>
                    <span>
                      <span class="badge badge-primary badge-pill ">{{$appointment->doctor->patients->count()}}</span> Patients Served
                    </span>
                  </li>

                  <li class="tf-flex list-group-item p-1 pr-3" title="Availabilty" data-toggle="tootltip">
                    <span class="d-block">
                      <i style="width:25px;" class="fa fa-calendar-alt"></i> 
                    </span>
                    <span class="text-bold">{{$appointment->doctor->available ? 'Available':'Unavailable'}}</span>
                  </li>

                  <li class="tf-flex list-group-item p-1 pr-3" title="Practice Years" data-toggle="tootltip">
                    <span class="d-block">
                      <i style="width:25px;" class="fa fa-calendar"></i> 
                    </span>
                    <span class="text-bold">{{$appointment->doctor->practice_years}} Practice Years</span>
                  </li>

                  <li class="tf-flex list-group-item p-1 pr-3 border-bottom-0" title="About" data-toggle="tootltip">
                    <span class="d-block">
                      <i style="width:25px;" class="fa fa-info-circle"></i> 
                    </span>
                    <span class="text-bold"> {{ $appointment->doctor->about }}</span>
                  </li>

                </ul>
              </p>

            </div>
            <div class="card-footer">
              <a href="{{route('doctors.show', $appointment->doctor)}}" class="btn btn-sm btn-primary">
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
          <div class="box box-warning direct-chat direct-chat-warning" style="height: 80vh;display: block;overflow-y: scroll;">
            <div class="box-body">
              
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">

                <!-- Message. Default to the left -->
                <div class="direct-chat-msg mb-3 pb-2">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">{{$appointment->doctor->user->name}}</span>
                    <span class="direct-chat-timestamp pull-right">{{$appointment->created_at}}</span>
                  </div>

                  <img class="direct-chat-img" src="{{$appointment->doctor->user->avatar}}" alt="{{$appointment->doctor->user->name}}" style="width: 40px;height: 40px;">

                  <div class="direct-chat-text">
                    Is this template really for free? That's unbelievable! <br>
                    I believed all that I was told, and acquired a conscience which has kept me working hard down to the present moment.
                  </div>
                </div>
                <!-- /.direct-chat-msg -->

                <!-- Message to the right -->
                <div class="direct-chat-msg right mb-3 pb-2">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">{{$appointment->user->name}}</span>
                    <span class="direct-chat-timestamp pull-left">{{$appointment->updated_at}}</span>
                  </div>

                  <img class="direct-chat-img" src="{{$appointment->user->avatar}}" alt="{{$appointment->user->name}}" style="width: 40px;height: 40px;">

                  <div class="direct-chat-text">
                    You better believe it! But although my conscience has controlled my actions, my opinions have undergone a revolution. I think that there is far too much work done in the world, that immense harm is caused by the belief that work is virtuous, and that what needs to be preached in modern industrial countries is quite different from what always has been preached.
                  </div>
                </div>

                <div class="direct-chat-msg right mb-3 pb-2">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-right">{{$appointment->user->name}}</span>
                    <span class="direct-chat-timestamp pull-left">{{$appointment->updated_at}}</span>
                  </div>

                  <img class="direct-chat-img" src="{{$appointment->user->avatar}}" alt="{{$appointment->user->name}}" style="width: 40px;height: 40px;">

                  <div class="direct-chat-text">
                    Everyone knows the story of the traveler in Naples who saw twelve beggars lying in the sun (it was before the days of Mussolini), and offered a lira to the laziest of them.
                  </div>
                </div>
                <!-- /.direct-chat-msg -->
                
                <div class="direct-chat-msg mb-3 pb-2">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">{{$appointment->doctor->user->name}}</span>
                    <span class="direct-chat-timestamp pull-right">{{$appointment->created_at}}</span>
                  </div>

                  <img class="direct-chat-img" src="{{$appointment->doctor->user->avatar}}" alt="{{$appointment->doctor->user->name}}" style="width: 40px;height: 40px;">

                  <div class="direct-chat-text">
                    But although my conscience has controlled my actions, my opinions have undergone a revolution. I think that there is far too much work done in the world, that immense harm is caused by the belief that work is virtuous, and that what needs to be preached in modern industrial countries is quite different from what always has been preached.
                  </div>
                </div>
                <!-- /.direct-chat-msg -->

                <div class="direct-chat-msg mb-3 pb-2">
                  <div class="direct-chat-info clearfix">
                    <span class="direct-chat-name pull-left">{{$appointment->doctor->user->name}}</span>
                    <span class="direct-chat-timestamp pull-right">{{$appointment->created_at}}</span>
                  </div>

                  <img class="direct-chat-img" src="{{$appointment->doctor->user->avatar}}" alt="{{$appointment->doctor->user->name}}" style="width: 40px;height: 40px;">

                  <div class="direct-chat-text">
                    What needs to be preached in modern industrial countries is quite different from what always has been preached.
                  </div>
                </div>
                <!-- /.direct-chat-msg -->
              </div>
              <!--/.direct-chat-messages-->
            </div>
            <!-- /.box-body -->

            {{-- <div class="box-footer">
              <form action="#" method="post">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                      <span class="input-group-btn">
                        <button type="submit" class="btn btn-primary btn-flat">Send</button>
                      </span>
                </div>
              </form>
            </div> --}}
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->

          <div class="sticky-bottom mb-0 p-0 bg-dark">
            <div class="container">
              <div class="row">
                <div class="col-sm-10">            
                  <textarea name="message" id="" class="form-control" style="max-height: 70px;min-height: 70px;width:100%;display: block;overflow-y: scroll;font-size: 12px;line-height: 1;" placeholder="type a message..."></textarea>
                </div>
                <div class="col-sm-2 pl-sm-0">

                    <button id="navbarDropdown" class="dropdown-toggle btn btn-sm btn-info btn-block m-1" 
                      data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
                      title="Prescription form, Upload form etc.">
                      <i class="fa fa-cogs"></i> 
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                  {{--@if(Auth::user()->isAttendantDoctor())--}}
                        <button class="dropdown-item" data-toggle="modal" data-target="#newPrescriptionForm" title="Create mdedication/drug prescription for this consultation.">
                          <i class="fa fa-prescription teal"></i>&nbsp; Make Prescription
                        </button>
                  {{--@endif--}}

                      <form action="">
                        <button class="dropdown-item" title="Upload image, video or other files.">
                          <i class="fa fa-file teal"></i>&nbsp; Image/File Uploads
                        </button>
                      </form>
                    </div>
                  <button class="btn btn-sm btn-primary btn-block m-1">Post</button>
                </div>
              </div>
            </div>
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
@endsection
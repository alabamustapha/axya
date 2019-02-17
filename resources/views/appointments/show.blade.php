@extends('layouts.master')

@section('title', $appointment->user->name .' Appointments - '. $appointment->day)

@section('styles')    
    <link rel="stylesheet" href="{{asset('css/vendor/jquery.timepicker.css')}}"> 
@endsection

@section('content')

<div class="container-fluid">
  <div class="row">
    
    <div class="col-sm-4 bg-primary text-secondary p-2 text-small" style="max-height: 80vh;display: block;overflow-y: scroll;">
      
      <div><!-- Appointment Details Section -->
        {{-- @include('appointments.partials.appointment-details') --}}

        <appointment-details :appointment="{{$appointment}}"></appointment-details>
      </div>

      <div><!-- Doctor/Patient Profile Section -->
        @include('appointments.partials.appointment-doctor-patient-details')
      </div>      
    </div>
    <!-- /.col-sm-4 -->

    <div class="col-sm-8 bg-dark px-0 pb-0" style="height: 80vh;display: block;overflow-y: scroll;">
      <h3 class="text-center">Chats</h3>

      <div class="container" id="appointment-chats">
        @if(1 == 1) {{-- Subscription made and time is reached --}}
          <!-- DIRECT CHAT PRIMARY -->
          <div class="box box-warning direct-chat direct-chat-warning" style="height: 80vh;display: block;overflow-y: scroll;">
            <div class="box-body text-small">
              
              <!-- Conversations are loaded here -->
              <div class="direct-chat-messages">

                @forelse ($messages as $message)
                  @if ($message->hasPrescription())
                    <!-- Message. Default to the left -->
                    <div class="direct-chat-msg mb-3 pb-2 w-90">
                      <div class="direct-chat-info clearfix">
                        <span class="direct-chat-name pull-left">{{$message->user->name}}</span>
                        <span class="direct-chat-timestamp pull-right">{{$message->created_at}}</span>
                      </div>

                      <img class="direct-chat-img" src="{{$message->user->avatar}}" alt="{{$message->user->name}}" style="width: 40px;height: 40px;">

                      <div class="direct-chat-text">
                        @php 
                          $prescription = $message->displayPrescription();
                        @endphp

                        <h6 class="pb-1 border-bottom tf-flex">
                          <span>
                            <i class="fa fa-prescription"></i>
                            {{ $message->body }}
                          </span>
                        </h6>

                        @if ($prescription)
                        <edit-prescription :prescription="{{ $prescription }}"><edit-prescription>

                          {{-- @include('prescriptions._card') --}}
                        @else
                          <div class="text-danger empty-list">Prescription is missing</div>
                        @endif
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
            <form action="{{route('messages.store', $appointment)}}" method="post" enctype="multipart/form">
              @csrf

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
                        @if($appointment->attendant_doctor)
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

  @if($appointment->attendant_doctor)
    <div class="modal bg-transparent" tabindex="-1" role="dialog" id="newPrescriptionForm" style="display:none;" aria-labelledby="newPrescriptionFormLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content px-0 pb-0 m-0 bg-transparent shadow-none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
            <span aria-hidden="true">&times;</span>
          </button>
          <br>
          <div class="modal-body">

            <prescription :appointment="{{$appointment}}"></prescription>

          </div>
        </div>
      </div>
    </div>
  @endif

  @if($appointment->creator)
    <!-- Appointment Form-->
    <div class="modal" tabindex="-1" role="dialog" id="appointmentForm" style="display:none;" aria-labelledby="appointmentFormLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content px-0 pb-0 shadow-none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
            <span aria-hidden="true">&times;</span>
          </button>
          <br>
          <div class="modal-body">

            @include('appointments.partials.edit-form')
            {{-- <appointment-form :doctor="{{$doctor}}"></appointment-form> --}}

          </div>
        </div>
      </div>
    </div>
    <!-- END - Appointment Form-->

    <!-- Appointment Transaction Form-->
    <div class="modal" tabindex="-1" role="dialog" id="appointmentTransactionForm" style="display:none;" aria-labelledby="appointmentTransactionFormLabel" aria-hidden="true">
      <div class="modal-dialog modal-md" role="document">
        <div class="modal-content px-0 pb-0 shadow-none">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
            <span aria-hidden="true">&times;</span>
          </button>
          <br>
          <div class="modal-body">

            @include('transactions.partials.create-form')

          </div>
        </div>
      </div>
    </div>
    <!-- END - Appointment Transaction Form-->
  @endif
</div>

@endsection

@section('scripts')

  @include('appointments.partials.scripts')
  
@endsection
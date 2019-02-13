@extends('layouts.master')

@section('title', 'User Messages Index')

@section('page-title')
  @if (Request::is('*/messages/*'))
    @if ($appointment->creator)
      <i class="fa fa-comments"></i>&nbsp; {{ __('Chats with') }} {{ $appointment->doctor->name }}
    @else
    <i class="fa fa-comments"></i>&nbsp; {{ __('Chats with') }} {{ $appointment->user->name }}
    @endif
  @else
    <i class="fa fa-comments"></i>&nbsp; {{ __('Chats') }}
  @endif
@endsection

@section('content')
  <div class="content">
    <div id="messaging">
      <div class="row">
        <div class="col-md-3 pr-0">
            <div class="msg-contact border ">
                <div class="msg-contact-head border-bottom clearfix">
                    <div class="head-main">
                        Conversation
                        <a class="contact-close float-right px-3"><i class="fas fa-arrow-right"></i></a>
                        <a class="msg-search-icon float-right "><i class="fas fa-search"></i></a>

                    </div>
          
                    
                    <form action="" method="post" class="msg-search">
                        <input type="search" class="form-default form-control" placeholder="search..">
                        <span class="search-close">
                            <i class="fas fa-arrow-right fa-sm"></i>
                        </span>
                    </form>
                </div>

                <div class="msg-contact-body scroll">
                  <h4 class="p-2 text-center">Active Correspondence</h4>

                  @forelse ($activeAppointments as $ac_appointment)
                    <!-- If Auth User is appointment creator, display doctor's name -->
                    @if ($ac_appointment->creator)
                      <a href="{{ route('messages.index', [ 'user' => Auth::user(), 'appointment' => $ac_appointment]) }}" class="msg-contact-list-item" title="{{ $ac_appointment->description_preview }}">
                        <div class="media align-items-center">
                          <img src="{{ $ac_appointment->doctor->avatar }}" height="45" class="mr-3 rounded-circle avatar" alt="Doctor image">
                          <div class="media-body">
                               
                            <span class="text-darker d-inline-block text-truncate name"> 
                              <span class="online-status online"></span>
                              {{ $ac_appointment->doctor->name }}
                                
                            </span>
                            <span id="msg-count" class="badge badge-danger">1</span>
                            <span id="last-online">2m</span>
                    
                          </div>
                        </div>
                      </a>
                    @else
                      <!-- If Auth User is appointment doctor, display patient's name -->
                      <a href="{{ route('dr_messages', [ 'doctor' => Auth::user()->doctor, 'appointment' => $ac_appointment]) }}" class="msg-contact-list-item" title="{{ $ac_appointment->description_preview }}">
                        <div class="media align-items-center">
                          <img src="{{ $ac_appointment->user->avatar }}" height="45" class="mr-3 rounded-circle avatar" alt="Doctor image">
                          <div class="media-body">
                             
                            <span class="text-darker d-inline-block text-truncate name"> 
                              <span class="online-status online"></span>
                              {{ $ac_appointment->user->name }}
                                
                            </span>
                            <span id="msg-count" class="badge badge-danger">1</span>
                            <span id="last-online">2m</span>
                    
                          </div>
                        </div>
                      </a>
                    @endif
                  @empty
                    <p class="text-center msg-contact-list-item">No active appointments at this time.</p>
                  @endforelse

                  <hr>

                  <!-- Past Appointments Chats: Inactive correspondence -->
                  <h4 class="p-2 text-center">Inactive/Past Correspondences</h4>

                  @forelse ($inactiveAppointments as $in_appointment)
                    <!-- If Auth User is appointment creator, display doctor's name -->
                    @if ($in_appointment->creator)
                      <a href="{{ route('messages.index', [ 'user' => Auth::user(), 'appointment' => $in_appointment]) }}" class="msg-contact-list-item" title="{{ $in_appointment->description_preview }}">
                        <div class="media align-items-center">
                            <img src="{{ $in_appointment->doctor->avatar }}" height="45" class="mr-3 rounded-circle avatar" alt="Doctor image">
                            <div class="media-body">
                                 
                              <span class="text-darker d-inline-block text-truncate name"> 
                                <span class="online-status online"></span>
                                {{ $in_appointment->doctor->name }}
                                  
                              </span>
                              <span id="msg-count" class="badge badge-danger">1</span>
                              <span id="last-online">2m</span>
                        
                            </div>
                        </div>
                     </a>
                    @else
                      <!-- If Auth User is appointment doctor, display patient's name -->
                      <a href="{{ route('dr_messages', [ 'doctor' => Auth::user()->doctor, 'appointment' => $in_appointment]) }}" class="msg-contact-list-item" title="{{ $in_appointment->description_preview }}">
                        <div class="media align-items-center">
                            <img src="{{ $in_appointment->user->avatar }}" height="45" class="mr-3 rounded-circle avatar" alt="Doctor image">
                            <div class="media-body">
                                 
                              <span class="text-darker d-inline-block text-truncate name"> 
                                <span class="online-status online"></span>
                                {{ $in_appointment->user->name }}
                                  
                              </span>
                              <span id="msg-count" class="badge badge-danger">1</span>
                              <span id="last-online">2m</span>
                        
                            </div>
                        </div>
                     </a>
                    @endif
                  @empty
                    <p class="text-center msg-contact-list-item">No past correspondence at this time</p>
                  @endforelse   
                </div>
            </div>
        </div>
        <div class="col-md-9 pl-0 position-relative">
           <div id="msg-contact-over" class="contact-over"></div>
            <div class="msg-chat border ">
              @if (Request::is('*/messages/*'))
                
                <div class="msg-chat-head border-bottom d-flex align-items-center justify-content-between">
                    <div class="media align-items-center">
                      @if ($appointment->creator)
                        <img src="{{ $appointment->doctor->avatar }}" height="45" class="mr-3 rounded-circle " alt="Doctor image">
                        <div class="media-body">
                            <h5 class="text-darker font-weight-bold">{{$appointment->doctor->name}}</h5>
                        </div>
                      @else
                        <img src="{{ $appointment->user->avatar }}" height="45" class="mr-3 rounded-circle " alt="Patient image">
                        <div class="media-body">
                            <h5 class="text-darker font-weight-bold">{{$appointment->user->name}}</h5>
                        </div>
                      @endif
                    
                    </div>

                    <div title="Appointment Details" class="bg-info">
                      <a id="navbarDropdown" class="float-right text-darker nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                      </a>

                      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right col" style="font-size:12px;" aria-labelledby="navbarDropdown">

                        <p class="{{-- dropdown-item --}} p-3 border-bottom tf-flex text-sm">
                          <span>{{$appointment->description}}</span>
                          @if ($appointment->creator && $appointment->schedule_period_pending)
                          <span class="p-2" style="cursor: pointer;" 
                            data-toggle="modal" data-target="#appointmentForm" 
                            title="Edit Appointment">
                            <i class="fa fa-edit"></i> Edit
                          </span>
                          @endif
                        <p>

                        <ul class="list-unstyled p-3 col-md-8 offset-md-2">
                          <li class="tf-flex">
                            <span class="text-bold">Status:</span> <span>{{$appointment->status_text}}</span>
                          </li>
                          <li class="tf-flex">
                            <span class="text-bold">Appointment Start:</span> <span>{{$appointment->from}}</span>
                          </li>
                          <li class="tf-flex">
                            <span class="text-bold">Correspondence Ends At:</span> <span>{{$appointment->correspondence_ends_at}}</span>
                          </li>
                        </ul>
                      </div>
                    </div>

                    <a href="" class="float-right msg-contact-toggle text-darker"><i class="fas fa-ellipsis-v fa-lg"></i></a>                      
                </div>

              @else

                <div class="msg-chat-head border-bottom d-flex align-items-center justify-content-between">
                  <h5 class="text-darker font-weight-bold">General Messaging Info</h5>

                  <a href="" class="float-right msg-contact-toggle text-darker"><i class="fas fa-ellipsis-v fa-lg"></i></a>                  
                </div>

              @endif


              <div class="msg-chat-body scroll">
                  <div class="chat clearfix">
                    @forelse ($messages as $message)
                      <div class="msg-bubble">
                        <div class="bubble
                            @if($message->owner())
                               bubble-sender 
                            @else 
                               bubble-receiver
                            @endif
                        ">
                            <span class="rounded px-1 text-info bg-white" style="font-size: 10px;">{{ $message->user->name }} - <em>{{ $message->created_at->diffForHumans() }}</em></span><br>
                            {{ $message->body }}
                        </div>
                      </div>
                    @empty

                      <div class="d-flex justify-content-center align-content-center">
                        <p class="text-center">
                          Green  - Active <br>
                          Yellow - Pending (Awaiting schedule time) <br>
                          Red    - Past
                        </p>
                      </div>

                    @endforelse  
                  </div>

                  @if (Request::is('*/messages/*'))
                    @if($appointment->chatable)
                      <form action="{{route('messages.store', $appointment)}}" method="post" class="msg-text-area" enctype="multipart/form">
                        @csrf

                        <textarea name="body" id="body" placeholder="write message..." maxlength="400" style="font-size:12px;" required></textarea>

                        @if($appointment->attendant_doctor)
                          <a class="float-right text-muted pr-2" data-toggle="modal" data-target="#newPrescriptionForm" title="Create drug prescription for this consultation.">
                            <i class="fas fa-prescription fa-lg"></i>
                          </a>
                        @endif

                        <a class="float-right text-muted" title="Upload files">
                            <i class="fas fa-paperclip fa-lg"></i>
                        </a>
                        <button type="submit" class="float-right send-btn" title="Submit message">
                            <i class="fas fa-paper-plane fa-lg"></i>
                        </button>                                

                      </form>
                    @else
                      <form class="msg-text-area text-center">

                        <textarea name="body" id="body" placeholder="{{ \Carbon\Carbon::now() < $appointment->from ? 'Chat active by '. $appointment->from:'Correspondence period has elapsed' }}" style="font-size:12px;" readonly disabled></textarea>

                        <span class="float-right send-btn" title="Submit message">
                          <i class="fas fa-lock fa-lg text-muted" style="font-size: 40px"></i>
                        </span>                                

                      </form>
                    @endif
                  @endif
                 
              </div>
            </div>
        </div>
      </div>
    </div>
  </div>



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
  @endif

  @if($appointment->attendant_doctor && $appointment->chatable)
    <div class="modal" tabindex="-1" role="dialog" id="newPrescriptionForm" style="display:none;" aria-labelledby="newPrescriptionFormLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content px-0 pb-0 m-0 shadow-none">
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

@endsection
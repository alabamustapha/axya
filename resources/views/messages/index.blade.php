@extends('layouts.master')

@section('title', 'User Messages Index')
@section('page-title')
    <i class="fa fa-comments"></i>&nbsp;  {{ __('Messages Dashboard') }}
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

                        @forelse ($activeAppointments as $appointment)
                         <a href="{{ route('messages.index', ['id' => $appointment->id]) }}" class="msg-contact-list-item">
                              <div class="media align-items-center">
                                  <img src="{{ $appointment->doctor->avatar }}" height="45" class="mr-3 rounded-circle avatar" alt="Doctor image">
                                  <div class="media-body">
                                       
                                      <span class="text-darker d-inline-block text-truncate name"> 
                                          <span class="online-status online"></span>
                                          {{ $appointment->doctor->name }}
                                          
                                      </span>
                                      <span id="msg-count" class="badge badge-danger">1</span>
                                      <span id="last-online">2m</span>
                              
                                  </div>
                              </div>
                         </a>
                        @empty
                          <p class="text-center msg-contact-list-item">No active appointments at this time.</p>
                        @endforelse

                        <hr>

                        <h4 class="p-2 text-center">Inactive/Past Correspondences</h4>
                        <!-- Past Appointments Chats: Inactive correspondence -->

                        @forelse ($inactiveAppointments as $in_appointment)
                         <a href="{{ route('messages.index', ['id' => $appointment->id]) }}" class="msg-contact-list-item">
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
                        @empty
                          <p class="text-center msg-contact-list-item">No past correspondence at this time</p>
                        @endforelse   
                      </div>
                  </div>
             </div>
             <div class="col-md-9 pl-0 position-relative">
                 <div id="msg-contact-over" class="contact-over"></div>
                  <div class="msg-chat border ">
                      <div class="msg-chat-head border-bottom d-flex align-items-center justify-content-between">
                          <div class="media align-items-center">
                              <img src="../images/a5.jpg" height="45" class="mr-3 rounded-circle " alt="Doctor image">
                              <div class="media-body">
                                  <h5 class="text-darker font-weight-bold">Dr. Bogdana Madalin</h5>
                              </div>
                          </div>
                          <a href="" class="float-right msg-contact-toggle text-darker"><i class="fas fa-ellipsis-v fa-lg"></i></a>
                      
                      </div>

                      <div class="msg-chat-body scroll">
                          <div class="chat clearfix">
                            @forelse ($messages as $message)
                              <div class="msg-bubble">
                                <div class="bubble
                                  @if ($message->ownerIsAppointmentOwner())
                                    @if($message->owner())
                                       bubble-sender 
                                    @else 
                                       bubble-receiver
                                    @endif

                                  @else

                                    @if($message->owner())
                                       bubble-sender 
                                    @else 
                                       bubble-receiver
                                    @endif
                                  @endif
                                ">
                                    <span class="rounded px-1 text-info bg-white" style="font-size: 10px;">{{ $message->user->name }} - <em>{{ $message->created_at->diffForHumans() }}</em></span><br>
                                    {{ $message->body }}
                                </div>
                              </div>
                            @empty
                              <p class="text-center msg-contact-list-item">No messages at this time</p>
                            @endforelse  
                          </div>

                       
                          <form action="{{route('messages.store')}}" method="post" class="msg-text-area" enctype="multipart/form">
                              @csrf
                              <input type="hidden" name="messageable_id" value="{{request()->id}}">
                              <input type="hidden" name="messageable_type" value="App\Appointment">

                              <textarea name="body" id="body" placeholder="write message..." maxlength="1500" required></textarea>

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
                         
                      </div>
                  </div>
             </div>
         </div>
      </div>
  </div>


  @if($appointment->attendant_doctor)
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
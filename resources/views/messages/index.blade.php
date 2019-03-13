@extends('layouts.master')

{{-- @section(, 'User Messages Index') --}}

@section('title')
  @if (Request::is('*/messages/*'))
    @if ($appointment->creator)
      {{ __('Chats with') }} {{ $appointment->doctor->name }}
    @else
      {{ __('Chats with') }} {{ $appointment->user->name }}
    @endif
  @else
    {{ __('Chats') }}
  @endif
@endsection

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

                  @forelse ($activeAppointments->load('user') as $ac_appointment)
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

                            <i class="fa {{ $ac_appointment->has_prescription ? 'fa-prescription':'' }}"></i>
                            
                            <span id="msg-count" class="badge badge-danger">1</span>

                            <span id="last-online">
                                <span>2m</span>
                            </span>
                    
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

                            <i class="fa {{ $ac_appointment->has_prescription ? 'fa-prescription':'' }}"></i>
                            
                            <span id="msg-count" class="badge badge-danger">1</span>

                            <span id="last-online">
                                <span>2m</span>
                            </span>
                    
                          </div>
                        </div>
                      </a>
                    @endif
                  @empty
                    <p class="text-center msg-contact-list-item">No active appointments at this time.</p>
                  @endforelse
                  {{-- 
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

                                <span id="last-online">
                                    <span class="tf-flex">
                                    <span>2m</span>
                                    <i class="fa {{ $in_appointment->has_prescription ? 'fa-prescription':'' }}"></i>
                                  </span>
                                </span>
                          
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

                                <span id="last-online">
                                    <span class="tf-flex">
                                    <span>2m</span>
                                    <i class="fa {{ $in_appointment->has_prescription ? 'fa-prescription':'' }}"></i>
                                  </span>
                                </span>
                          
                              </div>
                          </div>
                       </a>
                      @endif
                    @empty
                      <p class="text-center msg-contact-list-item">No past correspondence at this time</p>
                    @endforelse   
                  --}}
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

                        <div class="container">
                          <div class="border-bottom p-2 tf-flex">
                            <span class="font-weight-bold">
                              <i class="fa fa-info-circle"></i> Appointment Description
                            </span>

                            @if ($appointment->creator && $appointment->schedule_period_pending)
                            <span class="p-2" style="cursor: pointer;" 
                              data-toggle="modal" data-target="#appointmentForm" 
                              title="Edit Appointment">
                              <i class="fa fa-edit"></i> Edit
                            </span>
                            @endif
                          </div>
                          <div class="border-bottom py-3 text-sm">
                            <span>{{$appointment->description}}</span>
                          </div>

                          <div class="row">
                            <ul class="list-unstyled bg-dark p-3 col-md-7">
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

                            <ul class="list-unstyled bg-light p-3 col-md-5">
                              <li>
                                <span class="text-bold">Prescriptions:</span>
                              </li>
                              @if ($prescriptions)
                                <li>
                                  <ol>
                                    @foreach ($prescriptions as $key => $pr)
                                    {{--  class="btn btn-dark btn-sm btn-block text-white m-1" --}}
                                      <li class="p-1 m-1">
                                        <a href="#_{{ md5($pr) }}" class="py-1 px-2 m-1 bg-dark rounded">
                                          <span class="text-white">
                                            <span class="font-weight-bold">
                                              <i class="fa fa-prescription"></i>&nbsp;
                                              {{ \Carbon\Carbon::parse($key)->format('D, dS M, Y') }}
                                            </span>
                                             : View
                                          </span>
                                        </a>
                                      </li>
                                    @endforeach
                                  </ol>
                                </li>
                              @endif
                            </ul>
                          </div>
                        </div>
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
                    @forelse ($messages->load('prescription', 'image') as $message)
                      <div class="msg-bubble" id="_{{ md5($message->id) }}">
                        <div class="bubble
                            @if($message->owner())
                               bubble-sender 
                            @else 
                               bubble-receiver
                            @endif
                        ">
                          <span class="rounded px-1 text-info bg-white" style="font-size: 10px;">{{ $message->user->name }} - <em>{{ $message->created_at->diffForHumans() }}</em></span>
                          
                          <div class="text-left">
                            @if ($message->prescription)

                              <h6 class="pb-1 border-bottom">
                                <span>
                                  <i class="fa fa-prescription"></i>
                                  {{ $message->body }}
                                </span>
                              </h6>

                              <display-prescription :appointment="{{ $appointment }}" :prescription="{{ $message->prescription }}"><display-prescription>

                            @elseif ($message->image)

                              <div class="pt-1">
                                <img src="{{ $message->image->url }}" class="img-fluid">

                                <p class="pt-1">

                                    {{ $message->body }}

                                </p>
                              </div>

                            @elseif ($message->document)

                              <div class="pt-1">
                                @if ($message->document->isImage())
                                  
                                  <img src="{{ asset($message->document->url) }}" class="img-fluid">

                                @elseif ($message->document->isVideo())

                                  <video style="max-height:280px" class="embed-responsive" controls>
                                    <source src = "{{ route('documents.show', $message->document) }}" type = "video/{{$message->document->mime }}" >
                                    Your browser does not support the video tag. 
                                  </video>

                                @elseif ($message->document->isAudio())

                                  <audio controls>
                                    <source src = "{{ route('documents.show', $message->document) }}" type = "audio/{{$message->document->mime }}" >
                                    Your browser does not support the audio tag. 
                                  </audio>

                                @else
                                  <a href="{{ route('documents.show', $message->document) }}" target="_blank">
                                  <embed style="height:300px;width:350px;" class="embed-responsive" src="{{ route('documents.show', $message->document) }}" type="application/pdf">
                                    <br>
                                    <span class="btn btn-sm btn-primary"><i class="fa fa-file-alt fa-fw red"></i>open in new tab</span>
                                  </a>
                                @endif

                                <p class="pt-1">

                                    {{ $message->body }}

                                </p>
                              </div>

                            @else

                              {{ $message->body }}

                            @endif
                          </div>
                        </div>
                      </div>
                    @empty

                      <div class="col-md-6 offset-md-3">
                        <p>
                          <strong>Select a chat now...</strong>
                        </p>
                        <p>
                          Green  - Active <br>
                          Yellow - Pending (Awaiting schedule time) <br>
                          Red    - Past
                        </p>
                      </div>

                    @endforelse  

                    <div>{{$messages->appends(request()->query())->links()}}</div>
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

                        <a class="float-right text-muted" data-toggle="modal" data-target="#uploadFilesForm" title="Upload files">
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


  <div class="modal" tabindex="-1" role="dialog" id="uploadFilesForm" style="display:none;" aria-labelledby="uploadFilesFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content px-3">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
        <div class="modal-body">
          <div class="text-center">
            <div class="form-group text-center">
              <label for="uploadFile" class="h5">Upload Chat Related Files</label>
            </div>
          </div>

          <form action="{{route('chat.file.upload', $appointment)}}" method="post" enctype="multipart/form-data">
          {{-- <form action="{{route('user.uploadFile.upload', $user)}}" method="post" enctype="multipart/form-data"> --}}
            {{ csrf_field() }} 

            <div class="form-group text-center">
              <input type="file" name="uploadFile[]" id="uploadFile" class="form-control{{ $errors->has('uploadFile') ? ' is-invalid' : '' }}" accept="image/png, image/jpeg, application/pdf, application/docx, video/mp4, video/webm, video/ogg, audio/mp3, audio/wav, audio/ogg" required>

              @if ($errors->has('uploadFile'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('uploadFile') }}</strong>
                  </span>
              @endif
            </div> 

            <div class="form-group">
              <input type="text" name="caption" class="form-control" placeholder="write caption" required>
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Upload File</button>
            </div>
          </form> 
        </div>
      </div>
    </div>
  </div>

@endsection
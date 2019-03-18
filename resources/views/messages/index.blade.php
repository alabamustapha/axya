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
            
            @include('messages.partials._chat-sidebar')

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

                        @include('messages.partials._appointment-info')

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
                          <span class="rounded px-1 text-info bg-white" style="font-size: 10px;">
                            @if($message->canBeDeleted())
                            <form action="{{ route('messages.destroy', $message) }}" method="post" class="d-inline">
                              @csrf
                              {{ method_field('DELETE') }}
                              <button type="submit" 
                                class="btn btn-link btn-xs p-0 bg-transparent"
                                onclick="return confirm('Delete this message?');" 
                                >
                                <i class="fa fa-ellipsis-h red" style="font-size: 12px;"></i>
                              </button>
                            </form>
                            @endif

                            {{ $message->user->name }} - <em>{{ $message->created_at->diffForHumans() }}</em>
                          </span>
                          
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
                                  <embed style="max-height:300px;width:350px;" class="embed-responsive" src="{{ route('documents.show', $message->document) }}" type="{{ $message->document->mime_type }}">
                                    <span class="btn btn-sm btn-primary float-right"><i class="fa fa-file-alt fa-fw red"></i>open in new tab</span>
                                  </a>
                                  <br>
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
              <input type="file" name="uploadFile[]" id="uploadFile" class="form-control{{ $errors->has('uploadFile') ? ' is-invalid' : '' }}" accept="image/png, image/jpeg, application/pdf, video/mp4, video/webm" required>

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
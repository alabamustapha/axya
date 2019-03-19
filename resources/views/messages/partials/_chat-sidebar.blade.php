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
                  <strong class="p-2 text-center">Active Correspondence</strong>

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
                    <strong class="p-2 text-center">Inactive/Past Correspondences</strong>

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
@extends('layouts.master')

@section('title', $user->name .' Profile')
@section('page-title', 'User\'s Profile')

@section('content')

  <div class="">

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

              <div class="row">
                                        
                  <div class="col-md-4 bg-light border-right py-3 my-0 text-center">
                      <div class="pb-2 p-img">
                          
                          <img src="{{ $user->avatar_md }}" alt="profile image" class="img-responsive rounded" style="min-height:200px;max-height:250px;">
                          <!-- <div class="text-center py-3">
                              <a href="#" class="text-theme-blue">View my profile</a>
                          </div> -->
                      </div>
                        

                                               
                     <div class="form-category">
                        {{-- <h4 class="form-category-title mb-0">Basic Infomation</h4> --}}

                         <ul class="nav flex-column bg-white rounded shadow-sm">
                             <li class="border-bottom p-2">
                                 <div class="name f-s-lg font-weight-bold">
                                    @if ($user->isAccountOwner())
                                      <span class="mr-3" title="Profile Settings">              
                                        <a id="navbarDropdown" class="dropdown-toggle d-inline text-sm" href="#" role="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Edit
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">

                                          <button onclick="return false;" class="dropdown-item" title="Update Profile" data-toggle="modal" data-target="#updateUserProfileForm">
                                            <i class="fa fa-edit"></i> 
                                            <span>Edit Profile</span>
                                          </button>

                                          <button class="dropdown-item" data-toggle="modal" data-target="#updateAvatarForm" title=" Update Avatar">
                                            <i class="fa fa-image"></i> 
                                            <span>{{ $user->hasUploadedAvatar() ? 'Change':'Upload' }} Avatar</span>
                                          </button>
                                          
                                          @if ($user->hasUploadedAvatar())
                                              <a href="{{route('user.avatar.delete', $user)}}" class="dropdown-item" title="Remove Avatar" onclick="return confirm('Do you want to remove current avatar?');">
                                              <i class="fa fa-trash red"></i>
                                              <span>Remove Avatar</span>
                                            </a>
                                          @endif
                                        </div>
                                      </span>

                                    @endif
                                  <span>{{ $user->name }} </span>

                                  <br>

                                  <small class="text-sm text-muted font-weight-bold" title="Age">
                                    {{ $user->age }} y/o
                                  </small>
                                 </div>
                             </li>
                             <li class="border-bottom p-2">
                                 <span class="tf-flex px-3">
                                  <span class=" font-weight-bold">Status: </span>
                                  <span title="User Status">{{$user->status()}}</span>
                                </span>
                             </li>
                             <li class="border-bottom p-2">
                                 <span class="dob tf-flex px-3">
                                  <span class=" font-weight-bold">Date of Birth: </span>
                                  <span>{{ $user->dob_text }}</span>
                                </span>
                             </li>
                             <li class="border-bottom p-2">
                                <span class="gender tf-flex px-3">
                                  <span class=" font-weight-bold">Gender: </span>
                                  <span>{{ $user->gender }}</span>
                                </span>
                             </li>
                             <li class="border-bottom p-2">
                                 <span class="height tf-flex px-3">
                                  <span class=" font-weight-bold">Height: </span>
                                  <span>{{ $user->height }}(m)</span>
                                </span>
                             </li>
                             <li class="border-bottom p-2">
                                 <span class="weight tf-flex px-3">
                                  <span class=" font-weight-bold">Weight: </span>
                                  <span>{{ $user->weight }}(kg)</span>
                                </span>
                             </li>
                             <li class="p-2">
                                 <span class="language tf-flex px-3">
                                  <span class=" font-weight-bold">Language: </span>
                                  <span>{{ $user->language }}</span>
                                </span>
                             </li>
                         </ul>
                     </div>
                  </div>
                  
              
                  <div class="col-md-7">
                      <div class="profile-view profile-view--self">
                         
                          <div id="#form">

                              <!-- FORM CATEGORY  HERE-->
                              
                              @if ($user->isAccountOwner())
                                <div class="form-category">
                                        <h4 class="form-category-title">Contact Infomation</h4>
                                  <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="">Email</label>
                                            <br>
                                            <div class="">
                                                <input type="email" class="form-control" name="email" id="email" placeholder="email" value="{{ $user->email }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" class="">Password</label>
                                            <br>
                                            <div class="">
                                              <button class="btn btn-md btn-block btn-primary" data-toggle="modal" data-target="#updatePasswordForm">
                                                <i class="fa fa-key"></i>
                                                <span>Change Password</span>
                                              </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- FORM CATEGORY  HERE CONTACT INFO-->

                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="tel" class="">Phone</label>
                                            <br>
                                            <div class="">
                                                <input type="tel" class="form-control" name="tel" id="tel" placeholder="tel" value="{{ $user->phone }}" disabled>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="home-address" class="">Address</label>
                                            <br>
                                            <div class="">
                                                <textarea class="form-control" style="max-height: 150px;" name="home-address" id="home-address" placeholder="your home address" value="" disabled>{{ $user->address }} {{ $user->city->name }}, {{ $user->region->name }}</textarea>
                                            </div>
                                        </div>
                                        
                                    </div>
                                  </div>
                                </div>
                              @endif

                              <!-- FORM CATEGORY  HERE BASIC INFO-->

                              <div class="form-category">

                                  <h4 class="form-category-title mb-0">Medical Information</h4>

                                  <ul class="nav flex-column mb-4">
                                      <li class="pb-4 border-bottom">
                                          <div class="tf-flex mb-3 p-2 bg-light">
                                            <strong><i class="fa fa-allergies mr-1"></i> Allergies</strong>

                                            @if($user->isAccountOwner())
                                              <a style="cursor: pointer;" onclick="return false;" title="Update Allergies" data-toggle="modal" data-target="#updateAllergyProfileForm">
                                                <span><i class="fa fa-edit mr-1"></i> Edit</span>
                                              </a>
                                              @endif

                                          </div>

                                          <p class="text-muted">{{$user->allergies}}</p>
                                      </li>
                                      <li class="pb-4">
                                          <div class="tf-flex mb-3 p-2 bg-light">
                                            <strong><i class="fa fa-diagnoses mr-1"></i> Chronic Conditions</strong>

                                            @if($user->isAccountOwner())
                                              <a style="cursor: pointer;" onclick="return false;" title="Update Chronic Conditions" data-toggle="modal" data-target="#updateChronicsProfileForm">
                                                <span><i class="fa fa-edit mr-1"></i> Edit</span>
                                              </a>
                                              @endif
                                          </div>

                                          <p class="text-muted"> {{$user->chronics}} </p>
                                      </li>
                                  </ul>

                                  <h4 class="form-category-title mb-0">Other Medical Information</h4>

                                  <ul class="nav flex-column mb-4">

                                      <li class="pb-5 border-bottom">
                                          <div class="tf-flex mb-3 p-2 bg-light">
                                            <strong><i class="fa fa-diagnoses mr-1"></i> Previous Treatments</strong>
                                          </div>
                                          
                                          <div class="ml-4 text-sm">
                                            <div class="table-responsive">
                                                <table class="table table-borderless">
                                                    <thead >
                                                        <tr>
                                                            <th scope="col" class="text-muted">Info</th>
                                                            <th scope="col" class="text-muted">Chat</th>
                                                            <th scope="col" class="text-muted">Doctor</th>
                                                            <th scope="col" class="text-muted">Date</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="text-sm">

                                                        @forelse($treatments as $appointment)
                                                            <tr>
                                                                <td>
                                                                    <a href="{{ route('appointments.show', $appointment) }}" class="text-primary"> 
                                                                        <i class="fa fa-link btn btn-sm"></i>
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                  <a href="{{ route('messages.index', [$user, $appointment->slug]) }}" class="text-primary">
                                                                    <i class="fa fa-comments btn btn-sm"></i>
                                                                  </a>
                                                                </td>
                                                                <td>
                                                                  <a href="{{route('doctors.show', $appointment->doctor)}}" style="color:inherit;">{{$appointment->doctor->name}}</a>
                                                                </td>
                                                                <td title="{{ $appointment->schedule }}: {{ $appointment->description_preview }}">
                                                                    <small class="text-sm">
                                                                        <i class="fa fa-clock"></i>{{ $appointment->day_text }}
                                                                    </small>
                                                                </td>
                                                            </tr>
                                                            <tr class="shadow-sm">
                                                                <td colspan="5" title="Status">
                                                                  <p><small>{{ $appointment->description_preview }}</small></p>
                                                                  <small>{{ $appointment->statusTextOutput() }}</small>
                                                                </td>
                                                            </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="bg-white p-4 text-center">
                                                                    <div class="h1"><i class="fa fa-diagnoses"></i></div> 

                                                                    <br>

                                                                    <p><strong>0</strong> appointments at this time.</p>
                                                                </td>
                                                            </tr>
                                                        @endforelse
                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                          
                                            @if ($treatments->count())
                                              <a class="btn btn-sm btn-info" href="#" title="View more treatments">More treatments</a>
                                            @endif
                                        </div>
                                      </li>

                                      @if($user->isAccountOwner())
                                      <li class="pb-5 border-bottom">
                                          <div class="tf-flex mb-3 p-2 bg-light">
                                            <strong><i class="fa fa-pills mr-1"></i> Medications</strong>
                                          </div>

                                          <div class="ml-4 text-sm">
                                              @forelse ($medications as $medication)
                                                
                                                <div class="border-bottom p-2 mb-2">

                                                    <blockquote class="blockquote mb-0">
                                                      <a href="{{ $medication->link }}">
                                                        <p>

                                                          {{ $medication->title }}

                                                        </p>
                                                      </a>
                                                      <footer class="blockquote-footer">{{ $medication->description }}</footer>
                                                    </blockquote>

                                                </div>
                                              @empty
                                                <div class="text-center">
                                                  <div class="h1"><i class="fa fa-pills"></i></div> 

                                                  <br>

                                                  <p>You have <strong>0</strong> medications at this time.</p>
                                                </div>
                                              @endforelse

                                              @if ($medications->count())
                                                <a class="btn btn-sm btn-info" href="{{ route('medications.index', Auth::user()) }}" title="View more Medications">View medications</a>
                                              @endif
                                          </div>
                                      </li>
                                      @endif

                                      <li class="pb-5">
                                          <div class="tf-flex mb-3 p-2 bg-light">
                                            <strong><i class="fa fa-prescription mr-1"></i> Prescriptions</strong>
                                          </div>

                                          <div class="ml-4 text-sm">
                                            <div class="table-responsive tp-scrollbar">
                                                    
                                              @forelse($prescriptions as $prescription)
                                                
                                                @include('prescriptions._card')
                                                
                                              @empty
                                                <div class="text-center">
                                                  <div class="h1"><i class="fa fa-prescription"></i></div> 

                                                  <br>

                                                  <p>You have <strong>0</strong> prescriptions at this time.</p>
                                                </div>
                                              @endforelse
                                            </div>
                                          
                                            @if ($prescriptions->count())
                                              <a class="btn btn-sm btn-info" href="{{ route('prescriptions.index', Auth::user()) }}" title="View more Medications">More prescriptions</a>
                                            @endif
                                          </div>
                                      </li>
                                      
                                  </ul>
                                  
                              </div>

                          </div>
                      </div>
                  </div>
              </div> 



        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

      @include('users.partials.modals')
  </div>

@endsection
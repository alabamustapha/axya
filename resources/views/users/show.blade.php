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
                          
                          <img src="{{ $user->avatar_md }}" alt="profile image" class="rounded" height="250">
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
                             {{-- <li class="border-bottom p-2">
                                 <span class="weight tf-flex px-3">
                                  <span class=" font-weight-bold">Phone: </span>
                                  <span>{{ $user->phone }}</span>
                                </span>
                             </li>
                             <li class="border-bottom p-2">
                                 <span class="weight tf-flex px-3">
                                  <span class=" font-weight-bold">Address: </span>
                                </span>
                                <span>{{ $user->address }}</span>
                             </li> --}}
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
                                                <span>Change Login Password</span>
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
                                            <label for="home-address" class="">Home Address</label>
                                            <br>
                                            <div class="">
                                                <textarea class="form-control" style="max-height: 150px;" name="home-address" id="home-address" placeholder="your home address" value="" disabled>{{ $user->address }}</textarea>
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

                                      <li class="pb-4 border-bottom">
                                          <div class="tf-flex mb-3 p-2 bg-light">
                                            <strong><i class="fa fa-syringe mr-1"></i> Treatments</strong>
                                          </div>

                                          <p class="text-muted">                                            
                                              // List 3 completed appointment/consultation/teratments on this app, others in medication index <br>
                                              + view more
                                          </p>
                                          
                                          <a class="btn btn-sm btn-info" href="#" title="View more treatments">View <pre class="d-inline text-white"><i class="fa fa-syringe mr-1"></i>s</pre></a>
                                      </li>

                                      <li class="pb-4 border-bottom">
                                          <div class="tf-flex mb-3 p-2 bg-light">
                                            <strong><i class="fa fa-prescription mr-1"></i> Prescriptions</strong>
                                          </div>

                                          <p class="text-muted">                                            
                                              // List 3 Prescriptions, others in Prescriptions index <br>
                                              + view more
                                          </p>
                                          
                                          <a class="btn btn-sm btn-info" href="{{ route('prescriptions.index', Auth::user()) }}" title="View more Medications">View <pre class="d-inline text-white"><i class="fa fa-prescription">s</i></pre></a>
                                      </li>

                                      @if($user->isAccountOwner())
                                      <li class="pb-4">
                                          <div class="tf-flex mb-3 p-2 bg-light">
                                            <strong><i class="fa fa-pills mr-1"></i> Medications</strong>
                                          </div>

                                          <p class="text-muted">                                            
                                              // List 3 medications, others in medication index <br>
                                              + view more
                                          </p>

                                          <a class="btn btn-sm btn-info" href="{{ route('medications.index', Auth::user()) }}" title="View more Medications">View <pre class="d-inline text-white"><i class="fa fa-pills"></i>s</pre></a>
                                      </li>
                                      @endif
                                      
                                  </ul>
                                  
                              </div>

                          </div>
                      </div>
                  </div>
              </div> 



        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

      @if ($user->isAccountOwner())
        <div class="modal fade" tabindex="-1" role="dialog" id="updateUserProfileForm" style="display:none;" aria-labelledby="updateUserProfileFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">

                @include('users.forms.edit')

              </div> <!-- modal-body -->    
            </div> <!-- modal-content -->    
          </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="updateAllergyProfileForm" style="display:none;" aria-labelledby="updateAllergyProfileFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">

                @include('users.forms.allergies')

              </div> <!-- modal-body -->    
            </div> <!-- modal-content -->    
          </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="updateChronicsProfileForm" style="display:none;" aria-labelledby="updateChronicsProfileFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">

                @include('users.forms.chronics-form')

              </div> <!-- modal-body -->    
            </div> <!-- modal-content -->    
          </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="updatePasswordForm" style="display:none;" aria-labelledby="updatePasswordFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">

                @include('users.forms.password-form')

              </div> <!-- modal-body -->    
            </div> <!-- modal-content -->    
          </div>
        </div>

        <div class="modal fade" tabindex="-1" role="dialog" id="updateAvatarForm" style="display:none;" aria-labelledby="updateAvatarFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content px-3">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">
                <div class="text-center">
                  <img class="img-circle" height="75" src="{{$user->avatar}}" alt="{{$user->name}} profile picture">

                  <div class="form-group text-center">
                    <label for="avatar" class="h6">Update Avatar</label>
                  </div>
                </div>

                <form action="{{route('user.avatar.upload', $user)}}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}  
                  {{ method_field('PATCH') }}   

                  <div class="form-group text-center">
                    <input type="hidden" name="resize" value="true">
                    <input type="hidden" name="caption" value="{{ auth()->user()->name }}'s profile avatar">
                    <input type="file" name="uploadFile[]" id="uploadFile" class="form-control{{ $errors->has('uploadFile') ? ' is-invalid' : '' }}" accept="image/*" required>

                    @if ($errors->has('uploadFile'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('uploadFile') }}</strong>
                        </span>
                    @endif
                  </div> 

                  <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-image"></i> Upload Avatar</button>
                  </div>
                </form> 
              </div>
            </div>
          </div>        
        </div>
      @endif
  </div>

@endsection
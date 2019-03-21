@extends('layouts.master')

@section('title', $user->name .' Profile')

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
                        

                      @if ($user->isAccountOwner())

                        <div class="p-2 mb-2">
                          <div>
                              <strong>
                                <span class="red" title="Certified Doctor?"><i class="fa fa-{{$user->is_doctor ? 'certificate green':''}}"></i> {{$user->professionalType()}}</span> | 
                                <span class="teal" title="User Status">{{$user->status()}}</span>
                              </strong>
                          </div>

                          <div class="p-2">
                            <span class="mr-3" title="Profile Settings">              
                              <button id="navbarDropdown" class="btn btn-sm btn-dark btn-block dropdown-toggle shadow-lg" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  <i class="fa fa-cog"></i> Settings
                              </button>

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
                          </div>
                        </div>

                      @endif
                                               
                     <div class="form-category">
                        {{-- <h4 class="form-category-title mb-0">Basic Infomation</h4> --}}

                         <ul class="nav flex-column bg-white rounded shadow-sm">
                             <li class="border-bottom p-2">
                                 <span class="name f-s-lg font-weight-bold">
                                  <span>{{ $user->name }} </span>

                                  <small class="text-sm text-muted" title="Age">
                                    ({{ $user->age }}y/o)
                                  </small>
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
                                    <h4 class="form-category-title">Log in</h4>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-3 col-form-label text-right">Your Email</label>
                                        <div class="col-sm-9">
                                            <input type="email" class="form-control" name="email" id="email" placeholder="email" value="{{ $user->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password" class="col-sm-3 col-form-label text-right">Password</label>
                                        <div class="col-sm-9">
                                          <button class="btn btn-md btn-block btn-primary" data-toggle="modal" data-target="#updatePasswordForm">
                                            <i class="fa fa-key"></i>
                                            <span>Change Login Password</span>
                                          </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- FORM CATEGORY  HERE CONTACT INFO-->

                                <div class="form-category">
                                    <h4 class="form-category-title">Contact Infomation</h4>

                                    <div class="form-group row">
                                        <label for="tel" class="col-sm-3 col-form-label text-right">Phone</label>
                                        <div class="col-sm-9">
                                            <input type="tel" class="form-control" name="tel" id="tel" placeholder="tel" value="{{ $user->phone }}" disabled>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="home-address" class="col-sm-3 col-form-label text-right">Home Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control" name="home-address" id="home-address" placeholder="your home address" value="{{ $user->address }}" disabled>
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
                                      <li class="pb-4 border-bottom">
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

                                      <li class="pb-4 border-bottom">
                                          <a class="nav-link" href="#">
                                            <strong><i class="fa fa-syringe mr-1"></i> Treatments</strong>
                                          </a>
                                      </li>

                                      <li class="nav-item">
                                          <a class="nav-link" href="#">
                                            <strong><i class="fa fa-first-aid-kit mr-1"></i> Medical Tests</strong>
                                          </a>
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
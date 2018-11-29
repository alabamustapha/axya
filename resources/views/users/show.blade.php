@extends('layouts.master')

@section('title', $user->name .' Profile')

@section('content')

  <div class="">

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">

          <div class="row">
            <div class="col-md-4">

              <div class="card card-dark card-outline">
                <div class="card-body box-profile">
                  <!-- Profile Image -->
                  <div class="text-center">
                    <a href="{{$user->originalAvatarFile}}" target="_blank" style="text-decoration:none;color: inherit;">
                      <img class="profile-user-img img-fluid img-circle profile-img" src="{{$user->avatar}}" alt="{{$user->name}} profile picture">
                    </a>
                  </div>

                  @if ($user->isAccountOwner())
                    <div class="tf-flex">
                      <span class="mr-3" title="Profile Settings">              
                        <button id="navbarDropdown" class="btn btn-sm btn-dark dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-cog"></i> Settings
                        </button>

                        <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">

                          <button onclick="return false;" class="dropdown-item" title="Update Profile" data-toggle="modal" data-target="#updateUserProfileForm">
                            <i class="fa fa-edit"></i> 
                            <span>Edit Profile</span>
                          </button>

                          <button class="dropdown-item" data-toggle="modal" data-target="#updatePasswordForm">
                            <i class="fa fa-key"></i>
                            <span>Change Password</span>
                          </button>

                          <button class="dropdown-item" data-toggle="modal" data-target="#updateAvatarForm" title=" Update Avatar">
                            <i class="fa fa-image"></i> 
                            <span>Upload Avatar</span>
                          </button>

                          <button class="dropdown-item" data-toggle="modal" data-target="#testMultipleForm" title=" Test Multiple Uploads">
                            <i class="fa fa-upload"></i> 
                            <span>Multiple Uploads</span>
                          </button>
                          
                          @if ($user->hasUploadedAvatar())
                              <a href="{{route('user.avatar.delete', $user)}}" class="dropdown-item" title="Remove Avatar" onclick="return confirm('Do you want to remove current avatar?');">
                              <i class="fa fa-trash red"></i>
                              <span>Remove Avatar</span>
                            </a>
                          @endif
                        </div>
                      </span>
                    
                      <strong>
                        <span class="red" title="Certified Doctor?"><i class="fa fa-{{$user->is_doctor ? 'certificate green':''}}"></i> {{$user->professionalType()}}</span> | 
                        <span class="teal" title="User Status">{{$user->status()}}</span>
                      </strong>
                    </div>
                  @endif

            <hr>

                  <h3 class="profile-username text-center">{{$user->name}}</h3>

                  <p class="text-muted text-center">
                    
                    <br>
                    @auth
                      @if (Auth::user()->isAdmin())
                        <b title="Admin Type" class="purple">{{$user->type()}}</b> 
                      @endif
                    @endauth
                  </p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item p-1">
                      <b>Date of Birth</b> <a class="float-right">{{$user->dob()}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Age</b> <a class="float-right">{{$user->age()}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Gender</b> <a class="float-right">{{$user->gender}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Weight</b> <a class="float-right">{{$user->weight}} (kg)</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Height</b> <a class="float-right">{{$user->height}} (m)</a>
                    </li>

                    @can ('isAccountOwner')
                      <li class="list-group-item p-1">
                        <b>Phone</b> <a class="float-right">{{$user->phone}}</a>
                      </li>
                      <li class="list-group-item p-1">
                        <b>Email</b> <a class="float-right">{{$user->email}}</a>
                      </li>
                    @endcan

                    <li class="list-group-item p-1">
                      <b>Location</b> <a class="float-right">{{$user->address}}</a>
                    </li>
                  </ul>
                </div>
                <!-- /.card-body -->
              </div>

            </div>
            <!-- /.col -->

            <div class="col-md-8">             

              @if($user->isAccountOwner())
              <div class="row">  
                <div class="col-sm-6">
                  <div class="card card-dark">
                    <div class="card-header">
                      <h3 class="card-title">Payment Details</h3>
                    </div>
                    <div class="card-body box-profile">
                          
                      <ul class="list-group list-group-unbordered mb-0">
                        <li class="list-group-item p-1 tf-flex"><b>Card 1:</b> <span>*********{{$user->last_four}}</span></li>
                        <li class="list-group-item p-1 tf-flex"><b>Card 2:</b> <span>*********{{$user->last_four}}</span></li>
                        <li class="list-group-item p-1"><button class="btn btn-dark btn-block text-light">Add new</button></li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="card card-dark">
                    <div class="card-header">
                      <h3 class="card-title">Payment Options</h3>
                    </div>
                    <div class="card-body box-profile">

                      <ul class="list-group list-group-unbordered mb-0">
                        <li class="list-group-item p-1">Bank Transfer</li>
                        <li class="list-group-item p-1">Credit/Debit cards</li>
                        <li class="list-group-item p-1">Others</li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              @endif

              <!-- Medical History Section -->
              <div class="card card-dark">
                <div class="card-header">
                  <h3 class="card-title">Basic Medical History</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="tf-flex">
                    <strong><i class="fa fa-allergies mr-1"></i> Allergies</strong>

                    @if($user->isAccountOwner())
                      <a style="cursor: pointer;" onclick="return false;" title="Update Allergies" data-toggle="modal" data-target="#updateAllergyProfileForm">
                        <span><i class="fa fa-edit mr-1"></i> Edit</span>
                      </a>
                      @endif

                  </div>
                  <ul class="list-inline text-muted">
                    <li class="list-inline-item">{{$user->allergies}}</li>
                  </ul>

                  <hr>
                  <div class="tf-flex">
                    <strong><i class="fa fa-diagnoses mr-1"></i> Chronic Conditions</strong>

                    @if($user->isAccountOwner())
                      <a style="cursor: pointer;" onclick="return false;" title="Update Chronic Conditions" data-toggle="modal" data-target="#updateChronicsProfileForm">
                        <span><i class="fa fa-edit mr-1"></i> Edit</span>
                      </a>
                      @endif
                  </div>

                  <p class="text-muted">
                    {{$user->chronics}}
                  </p>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
              
            </div>
            <!-- /.col -->
          </div>
          <!-- /.row -->

        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

      @if ($user->isAccountOwner())
        <div class="modal" tabindex="-1" role="dialog" id="updateUserProfileForm" style="display:none;" aria-labelledby="updateUserProfileFormLabel" aria-hidden="true">
          <div class="modal-dialog{{--  modal-dialog-centered --}}" role="document">
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

        <div class="modal" tabindex="-1" role="dialog" id="updateAllergyProfileForm" style="display:none;" aria-labelledby="updateAllergyProfileFormLabel" aria-hidden="true">
          <div class="modal-dialog{{--  modal-dialog-centered --}}" role="document">
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

        <div class="modal" tabindex="-1" role="dialog" id="updateChronicsProfileForm" style="display:none;" aria-labelledby="updateChronicsProfileFormLabel" aria-hidden="true">
          <div class="modal-dialog{{--  modal-dialog-centered --}}" role="document">
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

        <div class="modal" tabindex="-1" role="dialog" id="updatePasswordForm" style="display:none;" aria-labelledby="updatePasswordFormLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
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

        <div class="modal" tabindex="-1" role="dialog" id="updateAvatarForm" style="display:none;" aria-labelledby="updateAvatarFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content px-3">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">
                <div class="text-center">
                  <img class="img-fluid img-circle profile-img" src="{{$user->avatar}}" alt="{{$user->name}} profile picture">

                  <div class="form-group text-center">
                    <label for="avatar" class="h5">Update Display Picture</label>
                  </div>
                </div>

                <form action="{{route('user.avatar.upload', $user)}}" method="post" enctype="multipart/form-data">
                  {{ csrf_field() }}  
                  {{ method_field('PATCH') }}   

                  <div class="form-group text-center">
                    <input type="file" name="avatar" id="avatar" class="form-control{{ $errors->has('avatar') ? ' is-invalid' : '' }}" accept="image/*" required>

                    @if ($errors->has('avatar'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('avatar') }}</strong>
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

        <div class="modal" tabindex="-1" role="dialog" id="testMultipleForm" style="display:none;" aria-labelledby="testMultipleFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content px-2">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">
            <form action="{{route('image.upload', auth()->user())}}" method="post" enctype="multipart/form-data">
              {{ csrf_field() }}  
              {{ method_field('PATCH') }}   

              <div class="form-group text-center">
                <label for="image_file" class="h5">Test Multiple Uploads (Max. 5)</label>
                <br>

                <input type="file" name="image_file[]" id="image_file" class="form-control{{ $errors->has('image_file') ? ' is-invalid' : '' }}" accept="image/*" multiple required>

                @if ($errors->has('image_file'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('image_file') }}</strong>
                    </span>
                @endif
              </div> 

              <div class="form-group">
                <input type="text" name="caption" class="form-control" placeholder="write caption" required>
              </div>

              <div class="form-group">
                <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-pencil"></i> Upload Images</button>
              </div>
            </form>
              </div>
            </div>
          </div>
        </div>
      @endif
  </div>

@endsection
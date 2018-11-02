@extends('layouts.master')

@section('content')

  <div class="">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>{{$user->name}} Profile</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">

              <div class="card card-dark card-outline">
                <div class="card-body box-profile">
                  <!-- Profile Image -->
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{$user->avatar}}" alt="{{$user->name}} profile picture">
                  </div>

                  <h3 class="profile-username text-center">{{$user->name}}</h3>

                  <p class="text-muted text-center">
                    
                    <strong>
                      <span class="red" title="Certified Doctor?"><i class="fa fa-{{$user->is_doctor ? 'certificate green':''}}"></i> {{$user->professionalType()}}</span> | 
                      <span class="teal" title="User Status">{{$user->status()}}</span>
                    </strong>
                    
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

                  @if ($user->isAccountOwner())
                    <a onclick="return false;" class="btn btn-dark btn-block text-light" title="Update Profile" data-toggle="modal" data-target="#updateUserProfileForm">
                      <i class="fa fa-edit mr-1"></i> 
                      <b>Edit Details</b>
                    </a>
                  @endif
                </div>
                <!-- /.card-body -->
              </div>

              <div class="card card-dark card-outline">
                <div class="card-body box-profile">
                  <button class="btn btn-block btn-secondary text-white" data-toggle="modal" data-target="#updatePasswordForm">
                    <i class="fa fa-key"></i>
                    <span>Change Password</span>
                  </button>
                </div>
              </div>

            </div>
            <!-- /.col -->

            <div class="col-md-8">             

              @if($user->isAccountOwner())
              <div class="row">  
                <div class="col-sm-6">
                  <div class="card card-dark card-outline">
                    <div class="card-body box-profile">
                      <h3 class="card-tile text-center">Payment Details</h3>
                          
                      <ul class="list-group list-group-unbordered mb-0">
                        <li class="list-group-item p-1 tf-flex"><b>Card 1:</b> <span>*********{{$user->last_four}}</span></li>
                        <li class="list-group-item p-1 tf-flex"><b>Card 2:</b> <span>*********{{$user->last_four}}</span></li>
                        <li class="list-group-item p-1"><button class="btn btn-dark btn-block text-light">Add new</button></li>
                      </ul>
                    </div>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="card card-dark card-outline">
                    <div class="card-body box-profile">
                      <h3 class="card-tile text-center">Payment Options</h3>

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
                    <strong><i class="fa fa-file-text-o mr-1"></i> Chronic Conditions</strong>

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
            
          {{--
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header p-2">
                  <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Activity</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Timeline</a></li>
                  </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                  <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                      <!-- Post -->
                      <div class="post">
                        <div class="user-block">
                          {{-- <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image"> -}}
                          <span class="username">
                            <a href="#">Dr. Jon Burkly</a>
                            <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
                          </span>
                          <span class="description">Appointment confirmed - 7:30 PM today</span>
                        </div>
                        <!-- /.user-block -->
                        <p>
                          Agreed time is October 31, 2018 by 4:25pm. <br>
                          Send me more details as soon as possible. <br>
                          Stay healthy.
                        </p>
                      </div>
                      <!-- /.post -->

                      <!-- Post -->
                      <div class="post clearfix">
                        <div class="user-block">
                          {{-- <img class="img-circle img-bordered-sm" src="" alt="User Image"> -}}
                          <span class="username">
                            <a href="#">Dr. Winston</a>
                            <a href="#" class="float-right btn-tool"><i class="fa fa-times"></i></a>
                          </span>
                          <span class="description">Sent you drug prescriptions - 7 days ago</span>
                        </div>
                        <!-- /.user-block -->
                        <p>
                          Some people hate it and argue for
                          its demise, but others ignore the hate as they create awesome
                          tools to help create filler text for everyone from bacon lovers to Charlie Sheen fans.
                        </p>
                        <footer class="muted">...About migraine headache</footer>
                      </div>
                      <!-- /.post -->
                    </div>
                    <!-- /.tab-pane -->


                    <div class="tab-pane" id="timeline">
                      <!-- The timeline -->

                    </div>
                    <!-- /.tab-pane -->

                    <!-- /.tab-pane -->
                  </div>
                  <!-- /.tab-content -->
                </div><!-- /.card-body -->
              </div>
              <!-- /.nav-tabs-custom -->
            </div>
          </div>
          <!-- /.row -->
          --}}

        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->

      @if ($user->isAccountOwner())
        <div class="modal" tabindex="-1" role="dialog" id="updateUserProfileForm" style="display:none;" aria-labelledby="editUserProfileFormLabel" aria-hidden="true">
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

        <div class="modal" tabindex="-1" role="dialog" id="updateAllergyProfileForm" style="display:none;" aria-labelledby="editAllergyProfileFormLabel" aria-hidden="true">
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

        <div class="modal" tabindex="-1" role="dialog" id="updateChronicsProfileForm" style="display:none;" aria-labelledby="editChronicsProfileFormLabel" aria-hidden="true">
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

        <div class="modal" tabindex="-1" role="dialog" id="updatePasswordForm" style="display:none;" aria-labelledby="editPasswordFormLabel" aria-hidden="true">
          <div class="modal-dialog{{--  modal-dialog-centered --}}" role="document">
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
      @endif
  </div>

@endsection
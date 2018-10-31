@extends('layouts.master')

@section('content')

  <div class="">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Profile</h1>
            </div>
          </div>
        </div><!-- /.container-fluid -->
      </section>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-4">

              <!-- Profile Image -->
              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{Auth::user()->avatar}}" alt="{{Auth::user()->name}} profile picture">
                  </div>

                  <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>

                  <p class="text-muted text-center">
                    {{Auth::user()->type()}} | {{Auth::user()->status()}}
                  </p>

                  <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item p-1">
                      <b>Date of Birth</b> <a class="float-right">{{substr(Auth::user()->dob, 0, 10)}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Age</b> <a class="float-right">{{Auth::user()->age()}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Gender</b> <a class="float-right">{{Auth::user()->gender}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Weight</b> <a class="float-right">{{Auth::user()->weight}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Height</b> <a class="float-right">{{Auth::user()->height}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Phone</b> <a class="float-right">{{Auth::user()->phone}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Email</b> <a class="float-right">{{Auth::user()->email}}</a>
                    </li>
                    <li class="list-group-item p-1">
                      <b>Location</b> <a class="float-right">{{--Auth::user()->address--}}Lagos, Nigeria</a>
                    </li>
                  </ul>

                  @if (Auth::user()->isAccountOwner())
                    <a href="#" class="btn btn-primary btn-block">
                      <i class="fa fa-edit mr-1"></i> 
                      <b>Edit Details</b></a>
                  @endif
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->

              <!-- About Me Box -->
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Basic Medical History</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                  <div class="tf-flex">
                    <strong><i class="fa fa-allergies mr-1"></i> Allergies</strong>
                    <span><i class="fa fa-edit mr-1"></i> Edit</span>
                  </div>
                  <ul class="list-unstyled text-muted">
                    <li class="list-item">Cookies</li>
                    <li class="list-item">Red Oil</li>
                    <li class="list-item">Veg. Oil</li>
                    <li class="list-item">Histamines</li>
                  </ul>

                  <hr>
                  <div class="tf-flex">
                    <strong><i class="fa fa-file-text-o mr-1"></i> Chronic Conditions</strong>
                    <span><i class="fa fa-edit mr-1"></i> Edit</span>
                  </div>

                  <p class="text-muted">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.
                  </p>
                  <p class="text-muted">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam fermentum enim neque.
                  </p>
                </div>
                <!-- /.card-body -->
              </div>
              <!-- /.card -->
            </div>
            <!-- /.col -->


            <div class="col-md-8">
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
                          {{-- <img class="img-circle img-bordered-sm" src="../../dist/img/user1-128x128.jpg" alt="user image"> --}}
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
                          {{-- <img class="img-circle img-bordered-sm" src="" alt="User Image"> --}}
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
            <!-- /.col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
  </div>

@endsection
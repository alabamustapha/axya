@extends('layouts.master')

@section('title', 'Users Stat. Dashboard')

@section('content')

<div class="container-fluid">
  <div class="row">
    <!-- Left col -->
    <div class="col-md-9">
      <!-- MAP & BOX PANE -->
      <div class="card text-center shadow-none">
        <div class="card-header bg-secondary">
          <h3 class="card-title text-bold pt-3">All Registered Users</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0 mb-4 shadow-sm">
          <div class="d-md-flex">
            <div class="p-4 flex-1" style="overflow: hidden">
              
              <div class="display-1 tf-flex">
                <i class="fa fa-users col-sm-3"></i>
                <span class="col-sm-9">{{ $users_count }}</span>
              </div>

            </div>
          </div><!-- /.d-md-flex -->
        </div>
        <!-- /.card-body -->

        <h3 class="text-bold pt-3 mt-3 pb-2 bg-secondary">
          <i class="fa fa-check-double"></i>
          Verification Statistics
        </h3>
        <div class="row mx-1">
          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-user-check display-3 green"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">
                      {{ $verified_users_count }}
                    </h1>

                    <p>
                      Verified Users
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $verified_users_stat }}%
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-users display-3 red"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">
                      {{ $unverified_users_count }}
                    </h1>

                    <p>
                      UnVerified Users
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $unverified_users_stat }}%
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <h3 class="text-bold pt-3 mt-3 pb-2 bg-secondary">
          <i class="fa fa-venus-mars"></i>
          Gender Statistics
        </h3>
        <div class="row mx-1">
          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-male display-3 purple"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">{{ $male_users_count }}</h1>

                    <p>
                      Males
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $male_users_stat }}%
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-female display-3 pink"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">{{ $female_users_count }}</h1>

                    <p>
                      Females
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $female_users_stat }}%
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-genderless display-3 pink"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">{{ $other_genders_stat }}</h1>

                    <p>
                      Others
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $other_genders_stat }}%
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div>
      <!-- /.card -->


      <div class="row">
        <div class="col-md-12">
          <!-- USERS LIST -->
          <div class="card shadow-none">
            <div class="card-header text-center bg-secondary">
              <h3 class="card-title text-bold pt-3">Latest Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="users-list clearfix">                
                @foreach(\App\User::latest()->take(8)->get() as $user)
                <li title="{{$user->name}}">
                  <img src="{{$user->avatar}}" width="80" alt="User Image">
                  <a class="users-list-name" href="{{route('users.show', $user)}}">{{$user->name}}</a>
                  <span class="users-list-date">{{$user->created_at->diffForHumans()}}</span>
                </li>
                @endforeach                
              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
          </div>
          <!--/.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.col -->

    <div class="col-md-3">
      <!-- Info Boxes Style 2 -->
      <div class="info-box mb-3 bg-warning">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Users Today</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Users This Week</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Users This Month</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
    <!-- /.col -->
  </div>
</div>

@endsection
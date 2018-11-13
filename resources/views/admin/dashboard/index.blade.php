@extends('layouts.master')

@section('title', 'App Main Dashboard')

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-9 order-sm-1 order-2 text-center">
      <div class="row">
        <div class="col-md-6">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-users display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">150,000</h1>

                  <p>Registered Users</p>
                </div>
              </div>
            </div>
            <a href="{{route('dashboard-users')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-user-check display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">150,000</h1>

                  <p>Verified Users</p>
                </div>
              </div>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <hr>

      <div class="row">
        <div class="col-md-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-male display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">80,000</h1>

                  <p>Males</p>
                </div>
              </div>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-female display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">70,000</h1>

                  <p>Females</p>
                </div>
              </div>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div> 

      <hr>

      <!-- MAP & BOX PANE -->
      <div class="card text-center">
        <div class="card-header">
          <h3 class="card-title">All Registered Users</h3>

          <div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse">
              <i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-widget="remove">
              <i class="fa fa-times"></i>
            </button>
          </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body p-0">
          <div class="d-md-flex">
            <div class="p-4 flex-1" style="overflow: hidden">
              
              <div class="display-1 tf-flex">
                <i class="fa fa-users col-sm-3"></i>
                <span class="col-sm-8">{{ \App\User::all()->count() }}</span>
              </div>

            </div>
          </div><!-- /.d-md-flex -->
        </div>
        <!-- /.card-body -->

        <div class="row mx-3">
          <div class="col-md-6">
            <div class="card shadow">
              <div class="card-title">Verified</div>
              <div class="card-body p-2">
                {{ \App\User::verified()->get()->count() }}
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card shadow">
              <div class="card-title">UnVerified</div>
              <div class="card-body p-2">
                {{ \App\User::notVerified()->get()->count() }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- /.card -->
      <div class="row">
        <div class="col-md-12">
          <!-- USERS LIST -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Latest Members</h3>

              <div class="card-tools">
                <span class="badge badge-danger">8 New Members</span>
                <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="users-list clearfix">

                @foreach(\App\User::latest()->take(8)->get() as $user)
                <li>
                  <img src="{{$user->avatar}}" width="80" alt="User Image">
                  <a class="users-list-name" href="{{route('users.show', $user)}}" title="{{$user->name}}">{{$user->name}}</a>
                  <span class="users-list-date">{{$user->created_at->diffForHumans()}}</span>
                </li>
                @endforeach

              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
              <a href="javascript::">View All Users</a>
            </div>
            <!-- /.card-footer -->
          </div>
          <!--/.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>

    <div class="col-md-3 order-sm-2 order-1">
      <!-- Info Boxes Style 2 -->
      <div class="info-box mb-3 bg-warning">
        <span class="info-box-icon"><i class="fa fa-tag"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Today</span>
          <span class="info-box-number">5,200</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fa fa-heart-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New This Week</span>
          <span class="info-box-number">92,050</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fa fa-cloud-download"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New this Month</span>
          <span class="info-box-number">114,381</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-info">
        <span class="info-box-icon"><i class="fa fa-comment-o"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Direct Messages</span>
          <span class="info-box-number">163,921</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>
</div>

@endsection
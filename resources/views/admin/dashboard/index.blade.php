@extends('layouts.master')

@section('title', 'App Main Dashboard')

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-9 order-sm-1 order-2 text-center">

      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner pt-5 pb-2">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-users display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">{{$users_count}}</h1>

                  <p>Registered Users</p>
                </div>
              </div>
            </div>
            <a href="{{route('dashboard-users')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <hr>

      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner pt-5 pb-2">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-user-md display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">{{$doctors_count}}</h1>

                  <p>Verified Doctors</p>
                </div>
              </div>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="{{route('dashboard-doctors')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <hr>

      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner pt-5 pb-2">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-handshake display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">---</h1>

                  <p>Completed Transactions</p>
                </div>
              </div>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="{{route('dashboard-transactions')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <hr>

      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner pt-5 pb-2">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-calendar-alt display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">---</h1>

                  <p>Successful Appointments</p>
                </div>
              </div>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="{{--route('dashboard-appointments')--}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div> 

    </div>

    <div class="col-md-3 order-sm-2 order-1">
      <!-- Info Boxes Style 2 -->
      <div class="info-box mb-3 bg-warning">
        <span class="info-box-icon"><i class="fa fa-tag"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Subscription</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fa fa-users"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Users</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fa fa-user-md"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Doctors</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-info">
        <span class="info-box-icon"><i class="fa fa-handshake"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Transactions</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
    </div>
  </div>
</div>

@endsection
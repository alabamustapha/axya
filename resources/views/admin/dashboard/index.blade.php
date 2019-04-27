@extends('layouts.admin')
{{-- @extends('layouts.master') --}}

@section('title', 'App Main Dashboard')
@section('page-title')
    <i class="fa fa-chart-bar"></i>&nbsp;  {{ __('App Dashboard') }}
@endsection

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-9 order-md-1 order-2 text-center">

      <!-- Users/Patients -->
      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner pt-5 pb-2">
              <a href="{{route('dashboard-users')}}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-users display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{$users_count}}</h1>

                    <p>Registered Users</p>
                  </div>
                </div>
              </a>
            </div>
            <a href="{{route('dashboard-users')}}" class="small-box-footer font-weight-bold">Users Management <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <hr>

      <!-- Doctors -->
      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner pt-5 pb-2">
              <a href="{{route('dashboard-doctors')}}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-user-md display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{$doctors_count}}</h1>

                    <p>Verified Doctors</p>
                  </div>
                </div>
              </a>
            </div>
            <a href="{{route('dashboard-doctors')}}" class="small-box-footer">Doctors Management <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <hr>

      <!-- Appointments -->
      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner pt-5 pb-2">
              <a href="{{--route('dashboard-appointments')--}}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-calendar-alt display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{$completed_appointments_count}}</h1>

                    <p>Successful Appointments</p>
                  </div>
                </div>
              </a>
            </div>
            <a href="{{--route('dashboard-appointments')--}}" class="small-box-footer">Appointments Management <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div> 

      <hr>

      <!-- Subscriptions -->
      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-secondary">
            <div class="inner pt-5 pb-2">
              <a href="{{route('adm_subscriptions')}}{{--route('dashboard-subscriptions')--}}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-rss display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{ $successful_subscriptions_count }}</h1>

                    <p>Subscriptions</p>
                  </div>
                </div>
              </a>
            </div>
            <a href="{{route('adm_subscriptions')}}{{--route('dashboard-subscriptions')--}}" class="small-box-footer">Subscriptions Management <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div> 

      <hr>

      <!-- Doctors -->
      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner pt-5 pb-2">
              <a href="{{route('adm_transactions')}}{{--route('dashboard-transactions')--}}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-handshake display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{ $successful_transactions_count }}</h1>

                    <p>Completed Transactions</p>
                  </div>
                </div>
              </a>
            </div>
            <a href="{{route('adm_transactions')}}{{--route('dashboard-transactions')--}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>

    </div>

    <div class="col-md-3 order-md-2 order-1">
      <nav>
        
        <!-- Admin Nav -->
        @include('admin.partials.right-sidebar-nav')
        
      </nav>
    </div>
  </div>
</div>

@endsection
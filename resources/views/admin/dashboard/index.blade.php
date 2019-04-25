@extends('layouts.admin')
{{-- @extends('layouts.master') --}}

@section('title', 'App Main Dashboard')
@section('page-title')
    <i class="fa fa-chart-bar"></i>&nbsp;  {{ __('App Dashboard') }}
@endsection

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-9 order-sm-1 order-2 text-center">

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

    <div class="col-md-3 order-sm-2 order-1">
      <div>
        @if (Auth::user()->isSuperAdmin())
        <!-- Info Boxes Style 2 -->
        <a href="{{ route('app-settings') }}" class="info-box mb-3 bg-danger">
          <span class="info-box-icon"><i class="fa fa-cogs"></i></span>

          <div class="info-box-content d-flex flex-column justify-content-center align-content-center">
            <span>App Settings</span>
          </div>
          <!-- /.info-box-content -->
        </a>
        <!-- /.info-box -->

        <a href="{{--route('dashboard-admins')--}}" class="info-box mb-3 bg-info">
          {{-- Link to FAQs, Privacy, TOS, Tags, Specialties etc updates --}}
          <span class="info-box-icon"><i class="fa fa-rss-square"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">App Contents</span>
          </div>
          <!-- /.info-box-content -->
        </a>
        <!-- /.info-box -->

        <a href="{{route('dashboard-admins')}}" class="info-box mb-3 bg-warning">
          <span class="info-box-icon"><i class="fa fa-user-tie"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Admins</span>
            <span class="info-box-number">{{ $admins_count }}</span>
          </div>
          <!-- /.info-box-content -->
        </a>
        <!-- /.info-box -->
        @endif

        <a href="{{route('applications.index')}}" class="info-box mb-3 bg-primary">
          <span class="info-box-icon"><i class="fa fa-user-secret"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Applications</span>
            {{-- <span class="info-box-number">{{ $admins_count }}</span> --}}
            <span class="badge badge-danger">1333{{--$applications_count--}}</span>
          </div>
          <!-- /.info-box-content -->
        </a>
        <!-- /.info-box -->
      </div>

      <nav>
        
        <!-- Admin Nav -->
        @include('admin.partials.right-sidebar-nav')
        
      </nav>
    </div>
  </div>
</div>

@endsection
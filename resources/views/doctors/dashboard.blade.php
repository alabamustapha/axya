@extends('layouts.master')

@section('title', 'Doctor Dashboard')
@section('page-title')
    <i class="fa fa-chart-bar"></i>&nbsp;  {{ __('Doctor Official Dashboard') }}
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
              <a href="{{route('dr_patients', $doctor)}}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-procedures display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{ $doctor->patients_count }}</h1>

                    <p>Patients</p>
                  </div>
                </div>
              </a>
            </div>
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
              <a href="{{ route('dr_appointments', $doctor) }}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-calendar-alt display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{ $doctor->appointments_count }}</h1>

                    <p>Successful Appointments</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div> 

      <hr>

      <!-- Prescriptions -->
      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner pt-5 pb-2">
              <a href="{{ route('dr_prescriptions', $doctor) }}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-prescription display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{-- $doctor->prescriptions_count --}}</h1>

                    <p>Prescriptions</p>
                  </div>
                </div>
              </a>
            </div>
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
              <a href="{{ route('subscriptions.index', $doctor) }}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-rss display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{ $doctor->subscriptions_count }}</h1>

                    <p>Subscriptions</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div> 

      <hr>

      <!-- Transactions -->
      <div class="row">
        <div class="col-12">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner pt-5 pb-2">
              <a href="{{ route('dr_transactions', $doctor) }}" style="color:inherit;">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-handshake display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{ $doctor->transactions_count }}</h1>

                    <p>Appointment Fee Payments</p>
                  </div>
                </div>
              </a>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>

    </div>

    <div class="col-md-3 order-sm-2 order-1">
      <div class="bg-light">
        <div class="list-group">
          <div class="list-group-item tf-flex" title="Your license on this platform is {{$doctor->revoked ? 'Revoked':'Active'}}">
            <span class="font-weight-bold">License: </span>
            <span class="d-inline-block bg-{{$doctor->revoked ? 'danger':'success'}}" style="width: 12px;height: 12px; border-radius:50%;"></span>
          </div>

          <div class="list-group-item tf-flex" title="You have {{$doctor->isSubscribed() ? 'Active':'Inactive'}} subscription on this platform">
            <span class="font-weight-bold">Subscription: </span>
            <span class="d-inline-block bg-{{$doctor->isSubscribed() ? 'success':'danger'}}" style="width: 12px;height: 12px; border-radius:50%;"></span>
          </div>
        </div>
      </div>
      <h1>
      </h1>
    </div>
  </div>
</div>

@endsection
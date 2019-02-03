@extends('layouts.master')

@section('title', 'Doctor Dashboard')

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
                    <i class="fa fa-bed display-3"></i>
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
          <div class="small-box bg-secondary">
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
              <a href="{{ route('dr_subscriptions', $doctor) }}" style="color:inherit;">
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
      <h1>
        License: <button class="btn btn-lg btn-{{$doctor->revoked ? 'danger':'success'}}">{{$doctor->revoked ? 'Revoked':'Active'}}</button>
      </h1>
    </div>
  </div>
</div>

@endsection
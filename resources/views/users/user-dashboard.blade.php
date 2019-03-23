@extends('layouts.master')

@section('title', Auth::user()->name .' Dashboard')

@section('content')

@section('page-title')
  <i class="fa fa-calendar-alt"></i> My Events 
@endsection

  <!-- end breadcrumbs -->

  <section class="main-content mt-40">
    <div class="container-fluid">
      <div class="wrapper-content">
        <div class="content">
          <div class="row">

            <div class="col-md-9 order-sm-1 order-2">
              {{-- <div id="calendar"> --}}
                <!-- calendar injected here -->
              {{-- </div> --}}
              <schedule-calendar-users :user-id="{{ Auth::id() }}"></schedule-calendar-users>
            </div>

            <div class="col-md-3 order-sm-2 order-1 mb-3">
              <div id="appointment-display" class="bg-theme-gradient">

            <div class="display-wrapper">

                <!-- Type of Appointment indicators -->
                <div class="display-card card shadow-lg">
                    <div class="card-body">
                      <h4 class="text-center text-info">
                        <span class="display-4">{{ $eventsCount}}</span>
                        <br>
                        Events Today
                      </h4>
                    </div>
                </div>

                <div class="appointment-legend">
                    @if (Auth::user()->is_doctor)
                    <div class="legend l-upcoming pb-2 border-bottom border-info tf-flex">
                        <span><i class="fas fa-procedures fa-fw"></i> Patient Apptmts</span>
                        <span class="badge badge-warning">{{ $patientAppointmentsCount }}</span>
                    </div>
                    @endif
                    <div class="legend l-past pb-2 border-bottom border-info tf-flex">
                        <span><i class="fas fa-user-md fa-fw"></i> Doctor Apptmts</span>
                        <span class="badge badge-warning">{{ $doctorAppointmentsCount }}</span>
                    </div>
                    <div class="legend l-requested pb-2 border-bottom border-info tf-flex">
                        <span><i class="fas fa-pills fa-fw"></i> Medications</span>
                        <span class="badge badge-warning">{{ $medicationEventsCount }}</span>
                    </div>
                    <div class="legend l-requested tf-flex">
                        <span><i class="fas fa-calendar-alt fa-fw"></i> Pending</span>
                        <span class="badge badge-warning">{{ $transactionEventsCount }}</span>
                    </div>
                </div>

            </div>
        </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end main content -->

  <div class="content-footer">
    <div class="text-center">Footer</div>
  </div>
  <!-- end footer -->

@endsection

@extends('layouts.master')

@section('title', Auth::user()->name .' Dashboard')

@section('content')

@section('page-title', 'My Appointments')

  <!-- end breadcrumbs -->

  <section class="main-content mt-40">
    <div class="container-fluid">
      <div class="wrapper-content">
        <div class="content">
          <div class="row">

            <div class="col-md-9">
              {{-- <div id="calendar"> --}}
                <!-- calendar injected here -->
              {{-- </div> --}}
              <schedule-calendar-users :user-id="{{ Auth::id() }}"></schedule-calendar-users>
            </div>

            <div class="col-md-3"></div>

          </div>
          <br>
          <br>
          <div class="">
            <vue-ctk-date-time-picker></vue-ctk-date-time-picker>
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

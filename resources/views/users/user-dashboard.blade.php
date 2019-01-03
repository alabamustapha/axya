@extends('layouts.dashboard')

@section('title', Auth::user()->name .' Dashboard')

@section('content')

  <div id="content-navbar">
    <div class="container-fluid">
      <div class="bg-light py-3 d-flex">
  
        <button type="button" id="sidebarCollapse" class="btn btn-theme-blue navbar-btn">
          <i class="fa fa-align-left"></i>
          <!-- Shrink Sidebar -->
        </button>

        <a class="crumb h4 text-theme-blue text-uppercase">
          My Appointments
        </a>          
  
      </div>
    </div>
    <!-- end container fluid -->
  </div>
  <!-- end content navbar -->

  <!-- end breadcrumbs -->

  <section class="main-content mt-40">
    <div class="container-fluid">
      <div class="wrapper-content">
        <div class="row">

          <div class="col-lg-9">
            <div id="calendar">
              <!-- calendar injected here -->
            </div>
          </div>

          <div class="col-lg-3"></div>

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

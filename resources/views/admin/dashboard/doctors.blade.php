@extends('layouts.master')

@section('title', 'Doctors Stat. Dashboard')

@section('content')

<div class="container-fluid">
  <div class="row">
    <!-- Left col -->
    <div class="col-md-9">
      <!-- MAP & BOX PANE -->
      <div class="card text-center shadow-none">
        <div class="card-header bg-secondary">
          <h3 class="card-title text-bold pt-3">Verified Doctors</h3>

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
                <i class="fa fa-user-md col-sm-3"></i>
                <span class="col-sm-9">{{ $doctors_count }}</span>
              </div>

            </div>
          </div><!-- /.d-md-flex -->
        </div>
        <!-- /.card-body -->

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
                    <h1 class="font-weight-light">
                      {{$male_doctors_count}}
                    </h1>

                    <p>
                      Male Doctors
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $male_doctors_stat }}%
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
                    <h1 class="font-weight-light">
                      {{$female_doctors_count}}
                    </h1>

                    <p>
                      Female Doctors
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $female_doctors_stat }}%
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
                    <i class="fa fa-genderless display-3 pink"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">
                      {{$other_genders_count}}
                    </h1>

                    <p>
                      Other Doctors
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

        <h3 class="text-bold pt-3 mt-3 pb-2 bg-secondary">
          <i class="fa fa-user-plus"></i>
          Doctor Applications
        </h3>
        <div class="row mx-1">
          <div class="col-md-6 offset-md-3">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-user-plus display-3"></i>
                  </div>
                  <div class="col-sm-9">
                    <a href="{{route('applications.index')}}" style="color: inherit;text-decoration: none;">
                      <h1 class="font-weight-light badge badge-danger">
                        <span class="h3">{{$applications_count}}</span>
                      </h1>

                      <p>Pending Applications</p>
                  </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>

        <h3 class="text-bold pt-3 mt-3 pb-2 bg-secondary">
          <i class="fa fa-stethoscope"></i>
          Specialty Statistics
        </h3>
        <div class="row mx-1">
          @foreach ($specialties as $specialty)
          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-stethoscope display-3"></i>
                  </div>
                  <div class="col-sm-9">
                    <a href="{{route('specialties.show', $specialty)}}" class="users-list-name">
                      <h1>
                        {{$specialty->doctors->count()}}
                      </h1>

                      <p>
                        {{$specialty->name}}
                        <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                          {{ round(100 * (($specialty->doctors->count() / $doctors_count)), 1) }}%
                        </span>
                      </p>
                  </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ./col -->
          @endforeach
        </div>
      </div>
      <!-- /.card -->



      <div class="row">
        <div class="col-md-12">
          <!-- USERS LIST -->
          <div class="card shadow-none">
            <div class="card-header text-center bg-secondary">
              <h3 class="card-title text-bold pt-3">Latest Additions</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="users-list clearfix">                
                @foreach($latest_doctors as $doctor)
                <li title="{{$doctor->user->name}}">
                  <img src="{{$doctor->user->avatar}}" width="80" alt="Doctor Image">
                  <a class="users-list-name" href="{{route('doctors.show', $doctor->user)}}">{{$doctor->user->name}}</a>
                  <span class="users-list-date">{{$doctor->created_at->diffForHumans()}}</span>
                </li>
                @endforeach                
              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center p-2">
              <a href="#{{-- route('doctors.index') --}}">View More <i class="fa fa-arrow-circle-right"></i></a>
            </div>
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
          <span class="info-box-text">New Doctors Today</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Doctors This Week</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Doctors This Month</span>
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
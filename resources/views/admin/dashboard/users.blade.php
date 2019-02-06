@extends('layouts.master')

@section('title', 'Users Management/Dashboard')
@section('page-title')
    <i class="fa fa-users"></i>&nbsp;  {{ __('Users Management') }}
@endsection

@section('content')

<div class="container-fluid">
  <div class="row">
    <!-- Left col -->


    <div class="col-md-9">
      <div class="order-sm-1 order-2 text-center">
        <div class="row">
          <div class="col-md-12">
            <!-- small box -->
            <div class="small-box bg-info p-1">
              <div class="inner pt-5">
                <div class="row">
                  <div class="col-sm-5">
                    <i class="fa fa-users display-3"></i>
                  </div>
                  <div class="col-sm-7">
                    <h1 class="font-weight-light">{{$users_count}}</h1>

                    <p>All Registered Users</p>
                  </div>
                </div>
              </div>
              <div class="small-box-footer p-2">

                <form @submit.prevent="searchForUser" class="form-inline">
                  <div class="form-group mb-2 d-inline-block w-100">
                    <input
                      v-model="search"
                      @keyup="searchForUser"
                      type="search" name="search"
                      placeholder="search users..." aria-label="Search Users" 
                      class="form-control form-control-lg text-center w-100 bg-dark" id="userSearchForm">
        
                  </div>        
                  <button @click="searchForUser" type="submit" class="btn btn-primary d-block mx-auto">
                      <i class="fa fa-search "></i> Search
                  </button>                    
                </form>
              </div>

              <div class="bg-light">
              <user-search :admins_count="{{$admins_count}}" :staffs_count="{{$staffs_count}}"></user-search>
              </div>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- ./row -->
      </div>

      <div class="mb-4">
        <div class="h4 text-center text-bold p-3 bg-secondary rounded-top">
          <i class="fa fa-check-double"></i>
          <strong>Verification Statistics</strong>
        </div>
        <div class="row">
          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-user-check display-3 green"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">
                      {{ $verified_users_count }}
                    </h1>

                    <p>
                      Verified Users
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $verified_users_stat }}%
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-users display-3 red"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">
                      {{ $unverified_users_count }}
                    </h1>

                    <p>
                      UnVerified Users
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $unverified_users_stat }}%
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="mb-4">
        <div class="h4 text-center text-bold p-3 bg-secondary rounded-top">
          <i class="fa fa-venus-mars"></i>
          <strong>Gender Statistics</strong>
        </div>
        <div class="row">
          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-male display-3 purple"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">{{ $male_users_count }}</h1>

                    <p>
                      Males
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $male_users_stat }}%
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
                    <h1 class="font-weight-light">{{ $female_users_count }}</h1>

                    <p>
                      Females
                      <span class="badge badge-dark badge-pill badge-sm" style="font-size:16px;">
                        {{ $female_users_stat }}%
                      </span>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <!-- small box -->
            <div class="small-box shadow">
              <div class="inner">
                <div class="row">
                  <div class="col-sm-3">
                    <i class="fa fa-genderless display-3 pink"></i>
                  </div>
                  <div class="col-sm-9">
                    <h1 class="font-weight-light">{{ $other_genders_stat }}</h1>

                    <p>
                      Others
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
        <!-- /.row mx-1 -->
      </div>


      <div class="row">
        <div class="col-md-12">
          <!-- USERS LIST -->
          <div class="card shadow-none">
            <div class="card-header text-center bg-secondary">
              <h3 class="card-title text-bold pt-3">Latest Users</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <ul class="users-list clearfix">                
                @foreach($latest_users as $user)
                <li title="{{$user->name}}">
                  <img src="{{$user->avatar}}" width="80" alt="User Image">
                  <a class="users-list-name" href="{{route('users.show', $user)}}">{{$user->name}}</a>
                  <span class="users-list-date">{{$user->created_at->diffForHumans()}}</span>
                </li>
                @endforeach                
              </ul>
              <!-- /.users-list -->
            </div>
            <!-- /.card-body -->
          </div>
          <!--/.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.col -->

    <div class="col-md-3">
      {{-- <!-- Info Boxes Style 2 -->
      <div class="info-box mb-3 bg-warning">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Users Today</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Users This Week</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box -->
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fa"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">New Users This Month</span>
          <span class="info-box-number">---</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <!-- /.info-box --> --}}
    </div>
    <!-- /.col -->
  </div>
</div>

@endsection
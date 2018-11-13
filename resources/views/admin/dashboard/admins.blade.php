@extends('layouts.master')

@section('title', 'Admin Stat. Dashboard')

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-9 order-sm-1 order-2 text-center">
      <div class="row">
        <div class="col-md-12">
          <!-- small box -->
          <div class="small-box bg-info">
            <div class="inner pt-5">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-users display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">{{$admins->count() + $staffs->count()}}</h1>

                  <p>Staff and Admin Users</p>
                </div>
              </div>
            </div>
            <p href="#" class="small-box-footer">&nbsp;</p>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <hr>

      <div class="row">
        <div class="col-md-6">
          <!-- small box -->
          <div class="small-box bg-warning">
            <div class="inner">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-male display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">{{$admins->count()}}</h1>

                  <p>Admins</p>
                </div>
              </div>
            </div>

            <p class="small-box-footer p-3 text-left text-dark" style="font-size: 12px;">
              <b>ROLE:</b>
              Oversees the day to day core activities of the site.
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde molestias ut beatae natus nobis eius perferendis. Vitae quod, deleniti suscipit consequatur rem ipsum quia sint ipsam, consectetur commodi natus! Odio?
            </p>
          </div>

          <div class="">
            @forelse ($admins as $admin)
            <div class="px-3 py-1">
              <div class="row" title="{{$admin->name}}">
                <img src="{{$admin->avatar}}" style="width:80px;height: 80px;" alt="Doctor Image">
                <span class="text-left">
                  <a class="users-list-name" href="{{route('users.show', $admin)}}">
                    {{$admin->name}}
                  </a>

                  <span class="mr-3">
                    <button id="navbarDropdown" class="btn btn-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                      <form method="post" action="{{--route('admins.destroy', $admin)--}}">
                        @csrf
                        <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to STAFF?');" title="Demote Admin">
                          <i class="fa fa-user-tag orange"></i>&nbsp; Demote to Staff
                        </button>
                      </form>
                      <form method="post" action="{{--route('admins.destroy', $admin)--}}">
                        @csrf
                        <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                          <i class="fa fa-user-slash red"></i>&nbsp; Demote to Normal User
                        </button>
                      </form>
                    </div>
                  </span>
                </span>
              </div>
            </div>
            @empty
              <div class="empty-list">
                0 staffs at the moment
              </div>
            @endforelse
          </div>
        </div>
        <!-- ./col -->
        <div class="col-md-6">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <div class="row">
                <div class="col-sm-5">
                  <i class="fa fa-female display-3"></i>
                </div>
                <div class="col-sm-7">
                  <h1 class="font-weight-light">{{$staffs->count()}}</h1>

                  <p>Staffs</p>
                </div>
              </div>
            </div>

            <p class="small-box-footer p-3 text-left text-sm" style="font-size: 12px;">
              <b>ROLE:</b>
              Oversees the day to day core activities of the site.
              Lorem ipsum dolor sit amet, consectetur adipisicing elit. Unde molestias ut beatae natus nobis eius perferendis. Vitae quod, deleniti suscipit consequatur rem ipsum quia sint ipsam, consectetur commodi natus! Odio?
            </p>
          </div>

          <div class="">
            @forelse ($staffs as $staff)
            <div class="px-3 py-1">
              <div class="row" title="{{$staff->name}}">
                <img src="{{$staff->avatar}}" style="width:80px;height: 80px;" alt="staff Image">
                <span class="text-left">
                  <a class="users-list-name" href="{{route('users.show', $staff)}}">
                    {{$staff->name}}
                  </a>

                  <span class="mr-3">
                    <button id="navbarDropdown" class="btn btn-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                      <form method="post" action="{{--route('admins.destroy', $admin)--}}">
                        @csrf
                        <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to STAFF?');" title="Demote Admin">
                          <i class="fa fa-user-tie green"></i>&nbsp; Upgrade to Admin
                        </button>
                      </form>
                      <form method="post" action="{{--route('admins.destroy', $admin)--}}">
                        @csrf
                        <button type="submit" class="dropdown-item" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                          <i class="fa fa-user-slash red"></i>&nbsp; Demote to Normal User
                        </button>
                      </form>
                    </div>
                  </span>
                </span>
              </div>
            </div>
            @empty
              <div class="empty-list">
                0 staffs at the moment
              </div>
            @endforelse
          </div>
        </div>
        <!-- ./col -->
      </div> 
    </div>
  </div>
</div>

@endsection
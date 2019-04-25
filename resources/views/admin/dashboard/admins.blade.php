@extends('layouts.admin')

@section('title', 'Admin Management')
@section('page-title')
    <i class="fa fa-user-tie"></i>&nbsp;  {{ __('Administrators Management') }}
@endsection

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-9 order-sm-1 order-2 text-center">
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
                  <h1 class="font-weight-light">{{$admins_count}}</h1>

                  <p>Staff and Admin Users</p>
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
                    class="form-control form-control-lg text-center w-100" id="userSearchForm">
      
                </div>        
                <button @click="searchForUser" type="submit" class="btn btn-primary d-block mx-auto">
                    <i class="fa fa-search "></i> Search
                </button>                    
              </form>
            </div>

            <div class="bg-light">
              <user-search :admins_count="{{$admins->count()}}" :staffs_count="{{$staffs->count()}}"></user-search>
            </div>
          </div>
        </div>
        <!-- ./col -->
      </div>

      <hr>

      <div class="row">
        <div class="col-md-6">

            <admin-list :admins_count="{{$admins->count()}}" :staffs_count="{{$staffs->count()}}"></admin-list>

            {{-- @forelse ($admins as $admin)
            <div class="px-3 py-1">
              <div class="row" title="{{$admin->name}}">
                <a class="users-list-name" href="{{route('users.show', $admin)}}">
                  <img src="{{$admin->avatar}}" style="width:80px;height: 80px;" alt="Doctor Image">
                </a>
                <span class="text-left ml-2">
                  <a class="users-list-name" href="{{route('users.show', $admin)}}">
                    {{$admin->name}}
                  </a>

                  <span>
                    <span class="text-muted">{{$admin->type()}}</span>

                    @if (Auth::user()->is_super_admin)
                    <span>
                      <button id="navbarDropdown" class="btn btn-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cog"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                        <form method="post" action="{{ route('make-staff', $admin) }}">
                          @csrf
                          {{method_field('PATCH')}}
                          <button type="submit" class="dropdown-item btn-sm" onclick="return confirm('You really want to demote this admin to STAFF?');" title="Demote Admin">
                            <i class="fa fa-user-tag orange"></i>&nbsp; Demote to Staff
                          </button>
                        </form>
                        <form method="post" action="{{ route('make-normal', $admin) }}">
                          @csrf
                          {{method_field('PATCH')}}
                          <button type="submit" class="dropdown-item btn-sm" onclick="return confirm('You really want to demote this admin to NORMAL User?');" title="Demote Admin">
                            <i class="fa fa-user-slash red"></i>&nbsp; Demote to Normal User
                          </button>
                        </form>
                      </div>
                    </span>
                    @endif
                  </span>
                </span>
              </div>
            </div>
            @empty
              <div class="empty-list">
                0 staffs at the moment
              </div>
            @endforelse --}}
        </div>
        <!-- ./col -->
        <div class="col-md-6">
            
            <staff-list :staffs_count="{{$staffs->count()}}" :admins_count="{{$admins->count()}}"></staff-list>
            
            {{-- @forelse ($staffs as $staff)
            <div class="px-3 py-1">
              <div class="row" title="{{$staff->name}}">
                <a class="users-list-name" href="{{route('users.show', $staff)}}">
                  <img src="{{$staff->avatar}}" style="width:80px;height: 80px;" alt="staff Image">
                </a>
                <span class="text-left ml-2">
                  <a class="users-list-name" href="{{route('users.show', $staff)}}">
                    {{$staff->name}}
                  </a>

                   <span>
                    <span class="text-muted">{{$staff->type()}}</span>

                    @if (Auth::user()->is_super_admin)
                    <span>
                      <button id="navbarDropdown" class="btn btn-sm dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <i class="fa fa-cog"></i>
                      </button>
                      <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                        <form method="post" action="{{ route('make-admin', $staff) }}">
                          @csrf
                          {{method_field('PATCH')}}
                          <button type="submit" class="dropdown-item btn-sm" onclick="return confirm('You really want to demote this staff to ADMIN?');" title="Upgrade Staff">
                            <i class="fa fa-user-tie teal"></i>&nbsp; Upgrade to Admin
                          </button>
                        </form>
                        <form method="post" action="{{ route('make-normal', $staff) }}">
                          @csrf
                          {{method_field('PATCH')}}
                          <button type="submit" class="dropdown-item btn-sm" onclick="return confirm('You really want to demote this staff to NORMAL User?');" title="Demote Staff">
                            <i class="fa fa-user-slash red"></i>&nbsp; Demote to Normal User
                          </button>
                        </form>
                      </div>
                    </span>
                    @endif
                  </span>
                </span>
              </div>
            </div>
            @empty
              <div class="empty-list">
                0 staffs at the moment
              </div>
            @endforelse --}}
        </div>
        <!-- ./col -->
      </div> 
    </div>

    <div class="col-md-3 order-sm-2 order-1">
      <nav>
        
        <!-- Admin Nav -->
        @include('admin.partials.right-sidebar-nav')
        
      </nav>
    </div>
    <!-- /.col -->
  </div>
</div>

@endsection
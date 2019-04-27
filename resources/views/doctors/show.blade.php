@extends('layouts.doctor')

@section('title', $doctor->name .' - Doctors')
@section('page-title', 'Doctor\'s Profile')

@section('styles')    
    <link rel="stylesheet" href="{{asset('css/vendor/jquery.timepicker.css')}}"> 
@endsection

@section('content')

  <div class="row my-0">
    <div class="col-md-5 pt-3 bg-light">
      <div class="p-img text-center">          
        <img src="{{ $doctor->avatar }}" alt="{{ $doctor->name }} avatar" class="rounded" height="250">
        <!-- <div class="text-center py-3">
            <a href="#" class="text-theme-blue">View my profile</a>
        </div> -->
      </div>
               
      <div class="p-img text-left">   
        <div>

          <div class="search-item" style="cursor: context-menu;">
            <!-- schedule detail -->
            <div id="s-d" class="mx-auto">

              <span class="text-center font-weight-bold">Available on:</span>
              
              @include('doctors.partials._days-available')

            </div>
          </div>

          @if ($doctor->user->isAccountOwner())
          <div class="search-item" style="background: none;">
            <div id="s-d" class=" mx-auto">
              <ul class="list-inline">
                <li class="list-inline-item mr-3" title="settings">
                    <button id="navbarDropdown" class="btn btn-sm btn-dark dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-cog"></i> Account Settings
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">
                      <a class="dropdown-item" href="{{route('doctors.edit', $doctor)}}">
                        <i class="fa fa-edit mr-1"></i>&nbsp; Edit Profile
                      </a>

                      <button class="dropdown-item" data-toggle="modal" data-target="#updateAvatarForm" title=" Update Avatar">
                        <i class="fa fa-upload"></i>&nbsp; Change Avatar
                      </button>
                  
                      @if ($doctor->user->hasUploadedAvatar())
                          <a href="{{route('user.avatar.delete', $doctor->user)}}" class="dropdown-item" title="Remove Avatar" onclick="return confirm('Do you want to remove current avatar?');">
                          <i class="fa fa-trash"></i>&nbsp; Remove Avatar
                        </a>
                      @endif
                    </div>
                </li>

                <li class="list-inline-item" title="availability">
                    <button id="navbarDropdown" class="btn btn-sm btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-calendar-alt" style="font-size: 12px;"></i> Availability
                    </button>

                    <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">

                        @include('doctors.partials._availability')

                    </div>
                </li>

              </ul>
            </div>
          </div>
          @endif
        </div>

        @auth  
          @if (Auth::id() !== $doctor->user_id) 
            <div class="search-item" style="background: none;">
              <div id="s-d" class=" mx-auto">
                <ul class="list-inline">
                  <li class="list-inline-item" title="Request Appointment">
                    
                        <button class="btn btn-secondary" data-toggle="modal" data-target="#appointmentForm" title="Book Appointment">
                          <i class="fa fa-calendar-check"></i>&nbsp; Request Appointment
                        </button>

                  </li>
                </ul>
              </div>
            </div>
          @endif
        @else
        <div class="search-item" style="background: none;">
          <div id="s-d" class=" mx-auto">
            <ul class="list-inline">
              <li class="list-inline-item" title="Request Appointment">

                  <a href="{{ route('login') }}"
                    class="btn btn-secondary" 
                    data-toggle="modal" data-target="#sign-in-up-modal" 
                    title="Log in now to book an appointment with {{$doctor->name}}">
                    <i class="fa fa-calendar-check"></i>&nbsp; Request Appointment
                  </a>

              </li>
            </ul>
          </div>
        </div>
        @endauth
      </div>

      <!-- doctor schedules row -->
        <div id="schedules" class="search-item bg-white" style="background: none;">
          <div id="s-d" class="table-responsive mx-auto">
            <div class="list-inline">
              <div class="list-inline-item" title="Request Appointment">

                <schedule-index 
                    :doctor="{{ $doctor }}" 
                    :is-doctor-owner="{{ intval( Auth::check() 
                                            && ( Auth::id() === $doctor->id ) 
                                            && ( Auth::user()->isAuthenticatedDoctor()) 
                                         ) }}"
                ></schedule-index>
                {{-- 
                  @can ('edit', $doctor)
                  
                    <!-- Schedules/Available Hours Section -->
                    @include('doctors.partials._schedules')
                    
                  @else
                  
                    @include('doctors.partials._schedules_users')
                    
                  @endcan 
                --}}
                <div class="text-center">
                  @auth
                    @if((Auth::id() === $doctor->id) && !Auth::user()->isAuthenticatedDoctor())
                      <div class="p-2 mb-2 border-bottom bg-light text-sm" title="To edit dchedules login as a doctor.">
                        <a href="{{ route('doctor.login') }}"
                          data-toggle="modal" data-target="#doctor-sign-in-modal"
                          class="btn btn-sm btn-primary"
                        ><i class="fa fa-sign-in-alt"></i> Login as Doctor</a> to edit
                      </div>
                    @endif
                  @endauth
                </div>

              </div>
            </div>
          </div>
        </div>
    </div>
    

    <div class="col-md-7">
      <div class="profile-view profile-view--self">
         
        <div class="form-category">
          <div class="row">

            <div class="col">
              <div class="fee-wrap">
                  <div class="p-1 text-center">FEE</div>
                  <span class="fee p-1">{{setting('base_currency')}} {{ $doctor->rate }}</span>
              </div>
              <ul class="nav flex-column">

                <li class="nav-item">
                  <p class="name f-s-lg font-weight-bold m-0">
                    {{ $doctor->name }}
                  </p>
                </li>

                <li class="nav-item">
                  
                  <small class="py-1 px-2 my-3 rounded-pill bg-light d-inline-block text-sm text-muted border " title="{{ $doctor->is_active ? 'Available' :'Unavailable' }} for appointments">
                    {{ $doctor->is_active ? 'Available' :'Unavailable' }} &nbsp;

                    @if ($doctor->is_active)
                        <span class="bg-success doc-avail-indicator"></span>
                    @else
                        <span class="bg-danger doc-avail-indicator"></span>
                    @endif
                  </small>
                </li>
                <li class="nav-item">
                  <p class="speciality font-weight-normal text-theme-blue">{{ $doctor->degree }}</p>
                </li>
                <li class="nav-item">
                  <p class="office  font-weight-normal">
                    <span>{{ $doctor->work_address }}</span>
                    <br>
                    <span>{{ $doctor->location }}</span>
                  </p>
                </li>
                <li class="nav-item">
                  <p class="experience">{{ $doctor->practice_years }} years in practice</p>
                </li>
                     
              </ul>
            </div>
          </div>
        </div>

        <div class="form-category">
            <h4 class="form-category-title">My Subscription Plan</h4>
            <div class="row align-items-center">
                <div class="col-sm-8 ">
                    <p>
                      @if ($doctor->is_subscribed)
                        <span class="text-muted">Current subscription ends by:</span>
                        <br>
                        <strong>{{ $doctor->subscription_end_formatted }}</strong>
                      @else
                        You have no subscription.
                        <br>
                        <small>  You must be subscribed to appear in search results or receive appointment from patients. </small>
                      @endif
                    </p>
                </div>
                <div class="col-sm-4">
                    @if ($doctor->is_subscribed)
                        {{-- <button class="btn btn-secondary btn-sm" 
                          data-toggle="modal" data-target="#newSubscriptionForm" 
                          title="New Subscription">Extend current subscription</button> --}}

                        <a href="{{ route('subscription_plans.index') }}" class="btn btn-secondary btn-sm" 
                          title="New Subscription">Extend current subscription</a>
                    @else
                        {{-- <button class="btn btn-secondary btn-sm" 
                          data-toggle="modal" data-target="#newSubscriptionForm" 
                          title="New Subscription">Subscribe Now</button> --}}
                        <a href="{{ route('subscription_plans.index') }}" class="btn btn-secondary btn-sm" title="New Subscription">Subscribe Now</a>
                    @endif
                </div>
            </div>
        </div>
      </div>

      <div class="profile-view profile-view--self">
        <div class="form-category">
          <h4 class="form-category-title">Speciality</h4>
          <div class="row bg-theme-gradient category p-3">
            {{-- @foreach ($doctor->specialties as $specialty) --}}
              <div class="">
                <a href="{{ $doctor->specialty->link }}" class="btn  p-2 rounded-pill spec d-block">{{ $doctor->specialty->name }}</a>
              </div>
            {{-- <div class="col-sm-3">
              <a href="#" class="btn  p-2 rounded-pill spec d-block">Dentistry</a>
            </div>
            <div class="col-sm-3">
              <a href="#" class="btn  p-2 rounded-pill spec d-block">Opthomologist</a>
            </div>
            <div class="col-sm-3">
              <a href="#" class="btn  p-2 rounded-pill spec d-block">Gynaecologist</a>
            </div> 
            @endforewach
            --}}
          </div>
        </div>
          
        <div class="form-category">
          <h4 class="form-category-title">Contact Information</h4>
          <ul class="nav flex-column">
      
            <li class="nav-item">
              <p class="phone  font-weight-normal">Phone: {{ $doctor->phone }}</p>
            </li>
            @can('delete', $doctor)
            <li class="nav-item">
              <p class="address  font-weight-normal">Home Address : {{ $doctor->home_address }}</p>
            </li>
            @endcan

          </ul>
        </div>
      
      </div>

      <!-- doctor schedules row -->

      <!-- review row -->
      <div class="row mt-4">
        <div class="col-md-9">
            
          <div class="review">
          
            <div class="d-flex justify-content-between align-items-center">
              <h4 class="text-uppercase">reviews</h4>
              <a href="{{ route('dr_reviews', $doctor) }}" class="text-theme-blue">View more</a>
            </div>

            @include('doctors.partials._review-section') 

          </div>
        </div>
      </div>

    </div>
  </div>

  <div>

      @include('doctors.forms.modals')

  </div>

@endsection

@section('scripts')

  @include('appointments.partials.scripts')
  
@endsection
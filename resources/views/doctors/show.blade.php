@extends('layouts.master')

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
          <div class="search-item mb-3">
            <!-- schedule detail -->
            <div id="s-d" class="search-cell w-100">
                <ul class="nav flex-sm-row">
                    <li class="nav-item">Available on:</li>
                    <li class="nav-item">
                      <ul class="nav flex-sm-row">
                        {{-- <li class="nav-item mr-3">Available on:</li> --}}
                        <li class="nav-item {{$doctor->has_sunday_schedules ? 'has':''}}"   title="Sunday">S</li>
                        <li class="nav-item {{$doctor->has_monday_schedules ? 'has':''}}"   title="Monday">M</li>
                        <li class="nav-item {{$doctor->has_tuesday_schedules ? 'has':''}}"  title="Tuesday">T</li>
                        <li class="nav-item {{$doctor->has_wednesday_schedules ? 'has':''}}" title="Wednesday">W</li>
                        <li class="nav-item {{$doctor->has_thursday_schedules ? 'has':''}}" title="Thursday">T</li>
                        <li class="nav-item {{$doctor->has_friday_schedules ? 'has':''}}"   title="Friday">F</li>
                        <li class="nav-item {{$doctor->has_saturday_schedules ? 'has':''}}" title="Saturday">S</li>
                      </ul>
                    </li>
                </ul>
            </div>
          </div>

          @if ($doctor->user->isAccountOwner())
          <div class="search-item mb-3">
            <ul class="nav flex-sm-row">
              <li class="nav-item mr-3 mb-3" title="settings">
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

              <li class="nav-item mr-3 mb-3" title="availability">
                  <button id="navbarDropdown" class="btn btn-sm btn-info dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="fa fa-calendar-alt" style="font-size: 12px;"></i> Availability
                  </button>

                  <div class="dropdown-menu dropdown-menu-lg" aria-labelledby="navbarDropdown">

                      @include('doctors.partials._availability')

                  </div>
              </li>

            </ul>
          </div>
          @endif
        </div>

        <div class="mb-4">
          @auth  
            @if (Auth::id() !== $doctor->user_id)                 
              <button class="btn btn-secondary" data-toggle="modal" data-target="#appointmentForm" title="Book Appointment">
                <i class="fa fa-calendar-check"></i>&nbsp; Request Appointment
              </button>
            @endif
          @else
            <a href="{{ route('login') }}"
              class="btn btn-secondary" 
              data-toggle="modal" data-target="#sign-in-up-modal" 
              title="Log in now to book an appointment with {{$doctor->name}}">
              <i class="fa fa-calendar-check"></i>&nbsp; Request Appointment
            </a>
          @endauth
        </div>
      </div>

      <!-- doctor schedules row -->
      <div class="mt-4">
        <div id="schedules">

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
                  <a href="{{ route('doctor.login') }}" class="btn btn-sm btn-primary"><i class="fa fa-sign-in-alt"></i> Login as Doctor</a> to edit
                </div>
              @endif
            @endauth
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
                  <p class="office  font-weight-normal">{{ $doctor->work_address }}</p>
                </li>
                <li class="nav-item">
                  <p class="experience">{{ $doctor->practice_years }}years in practice</p>
                </li>
                     
              </ul>
            </div>
          </div>
        </div>
      </div>

      <div class="profile-view profile-view--self">
        <div class="form-category">
          <h4 class="form-category-title">Speciality</h4>
          <div class="row bg-theme-gradient category p-3">
            {{-- @foreach ($doctor->specialties as $specialty) --}}
              <div class="col-sm-3">
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

            {{-- @include('doctors.partials._review-section')  --}}
            <div class="review-content my-2" id="reviews">
              @forelse ($reviews as $review)
                <div class="media">
                  <img src="{{ $review->user->avatar }}" alt="{{ $review->user->name }} avatar" height="50" class="rounded-circle">

                  <div class="media-body pl-2 border-bottom pb-3 mb-3">
                    <div class="review-head d-flex justify-content-between align-items-center">
                      <p class="lead name m-0">
                        {{ $review->user->name }}

                        @auth
                          @if(Auth::id() == $review->user_id)
                            <button class="btn btn-link btn-sm" title="Update this review">
                              <i class="fa fa-cog"></i>
                            </button>
                          @endif
                        @endauth
                      </p>
                      <span class="text-review review-star">

                        @for($i=1; $i <= $review->rating; $i++)
                          <i class="fas fa-star"></i>
                        @endfor
                        
                      </span>
                    </div>

                    <span class="review-time small">{{$review->created_at}}</span>
                    <br>

                    <span class="review-message">
                      {{ $review->comment }}
                    </span>
                  </div>

                </div>
              @empty
                <p class="list-group-item empty-list">0 reviews</p>
              @endforelse
            </div>

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
@extends('layouts.master')

@section('title', 'Reviews Index - ' . $doctor->name)

@section('page-title', 'Doctor Reviews Index')

@section('content')

    <div class="row">                                        
        <div class="col-md-4 pt-3 bg-light">
            <div class="p-img mb-4 text-center">
                
                <img src="{{ $doctor->avatar }}" alt="{{ $doctor->name }}" class="rounded" height="250">
                <div class=" py-3">
                   <h3>
                        <a href="{{ $doctor->link }}" style="color:inherit;">{{ $doctor->name }}</a>
                    </h3>

                   <p class="text-theme-blue">{{ $doctor->degree }}</p>

                   <span>{{ $doctor->work_address }}</span>
                </div>
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

        <div class="col-md-8">
            <!-- review row -->
            <div class="row mt-4">
                <div class="col-md-9">
                    
                    <div class="review">
                    
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="text-uppercase">reviews</h4>
                           
                        </div>

                        @include('doctors.partials._review-section') 

                        <div>{{ $reviews->links() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div>

        <!-- Appointment Form-->
        @if (Auth::id() !== $doctor->user_id)
        <div class="modal" tabindex="-1" role="dialog" id="appointmentForm" style="display:none;" aria-labelledby="appointmentFormLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content px-0 pb-0 shadow-none">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
                <span aria-hidden="true">&times;</span>
              </button>
              <br>
              <div class="modal-body">

                @include('appointments.partials.form')
                {{-- <appointment-form :doctor="{{$doctor}}"></appointment-form> --}}

              </div>
            </div>
          </div>
        </div>
        @endif
        <!-- END - Appointment Form-->

    </div>
@endsection
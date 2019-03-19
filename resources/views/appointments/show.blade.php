@extends('layouts.master')

@section('title', $appointment->user->name .' Appointments - '. $appointment->day)

@section('styles')    
    <link rel="stylesheet" href="{{asset('css/vendor/jquery.timepicker.css')}}"> 
@endsection

@section('content')

<div class="container-fluid">
  <div class="row">
    
    <div class="col-sm-5 text-secondary p-2 text-small">
      <div>

        <appointment-details :appointment="{{$appointment}}"></appointment-details>

      </div>     
    </div>

    <div class="col-sm-7">
        {{-- @include('appointments.partials.appointment-details') --}}    
        <div class="d-block m-auto text-center bg-white rounded">

          <div class="text-left shadow-lg p-3 mb-3" title="Appointment Description">
            <h5 title="appointment status" class="pb-2 border-bottom">Description</h5>
            
            <p class="text-small">{{ $appointment->description }}</p>
          </div>
        </div>

        <!-- Doctor/Patient Profile Section -->

        @include('appointments.partials.appointment-doctor-patient-details')

    </div>

  </div>
</div>

 @if($appointment->creator)
   <!-- Appointment Form-->
   <div class="modal" tabindex="-1" role="dialog" id="appointmentForm" style="display:none;" aria-labelledby="appointmentFormLabel" aria-hidden="true">
     <div class="modal-dialog modal-lg" role="document">
       <div class="modal-content px-0 pb-0 shadow-none">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
           <span aria-hidden="true">&times;</span>
         </button>
         <br>
         <div class="modal-body">
        <!-- Doctor/Patient Profile Section -->
 
           @include('appointments.partials.edit-form')
           {{-- <appointment-form :doctor="{{$doctor}}"></appointment-form> --}}
        @include('appointments.partials.appointment-doctor-patient-details')
 
         </div>
       </div>
     </div>
     </div>
   <!-- END - Appointment Form-->

   <!-- Appointment Transaction Form-->
   <div class="modal" tabindex="-1" role="dialog" id="appointmentTransactionForm" style="display:none;" aria-labelledby="appointmentTransactionFormLabel" aria-hidden="true">
     <div class="modal-dialog modal-md" role="document">
       <div class="modal-content px-0 pb-0 shadow-none">
         <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
           <span aria-hidden="true">&times;</span>
         </button>
         <br>
         <div class="modal-body">
 
           @include('transactions.partials.create-form')

         </div>
       </div>
     </div>
   </div>
   <!-- END - Appointment Transaction Form-->
 @endif

@endsection

@section('scripts')

  @include('appointments.partials.scripts')
  
@endsection
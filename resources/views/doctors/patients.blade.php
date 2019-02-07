@extends('layouts.master')

@section('title', 'Doctor Patients Dashboard')
@section('page-title')
    <i class="fa fa-procedures"></i>&nbsp;  {{ __('Patients') }}
@endsection

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-9 order-sm-1 order-2 text-center">
      <div class="list-group">
        @forelse ($patients as $patient)
        
          <div class="list-group-item list-group-item-action ">
            <div class="tf-flex">
              <a href="{{route('users.show', $patient)}}" class="text-left">
                <img src="{{$patient->avatar}}" height="40" alt="patient avatar" class="rounded">
                {{$patient->name}}
              </a>
              
              {{-- <a href="tel:{{ $patient->phone }}" class="text-muted">{{ $patient->phone }}</a> --}}
            </div>
          </div>
        

        @empty
          <div class="bg-white p-4 text-center">
              <div class="display-3"><i class="fa fa-procedures"></i></div> 

              <br>

              <p><strong>0</strong> patients at this time.</p>
          </div>
          
        @endforelse        
      </div>
    </div>

    <div class="col-md-3 order-sm-2 order-1 text-center bg-light py-3">
      <h1>
        Patients

        <br>

        <small>{{ $doctor->patients_count }}</small>
      </h1>
    </div>
  </div>
</div>

@endsection
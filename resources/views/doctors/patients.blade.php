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
            <div class="row text-left">
              <a href="{{route('users.show', $patient)}}" class="col-md-5">
                <img src="{{$patient->avatar}}" height="30" alt="patient avatar" class="rounded">
                {{$patient->name}}
              </a>
              
              <span class="text-muted col-md-3">{{ $patient->gender }}</span>
              <span class="text-muted col-md-4 text-truncate">{{ $patient->address }}</span>
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

    <div class="col-md-3 order-sm-2 order-1 text-center">
      <div class="card shadow-none">
        <div class="card-heading bg-light p-4 border-bottom">
          <span class="h2">Patients</span>
        </div>

        <div class="card-body">

          <span class="display-4">{{ $doctor->patients_count }}</span>
          
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
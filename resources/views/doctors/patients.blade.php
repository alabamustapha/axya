@extends('layouts.master')

@section('title', 'Doctor Patients Dashboard')

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-9 order-sm-1 order-2 text-center">
      <div class="list-group">
        @forelse ($patients as $patient)
        
          <a href="{{route('users.show', $patient)}}" class="list-group-item list-group-item-action">{{$patient->name}}</a>

        @empty
          <div class="bg-white p-4 text-center">
              <div class="display-3"><i class="fa fa-bed"></i></div> 

              <br>

              <p><strong>0</strong> patients at this time.</p>
          </div>
          
        @endforelse        
      </div>
    </div>

    <div class="col-md-3 order-sm-2 order-1 text-center bg-light">
      <h1>
        Patients

        <br>

        {{ $doctor->patients_count }}
      </h1>
    </div>
  </div>
</div>

@endsection
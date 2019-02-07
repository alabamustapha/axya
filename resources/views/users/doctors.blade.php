@extends('layouts.master')

@section('title', $user->name .' Doctors')
@section('page-title')
    <i class="fa fa-user-md"></i>&nbsp;  {{ __('Doctors') }}
@endsection

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col-md-9 order-sm-1 order-2 text-center">
      <div class="list-group">
        @forelse ($doctors as $doctor)
        
          <div class="list-group-item list-group-item-action ">
            <div class="tf-flex">
              <a href="{{route('doctors.show', $doctor)}}" class="text-left">
                <img src="{{$doctor->avatar}}" height="40" alt="doctor avatar" class="rounded">
                {{$doctor->name}}
              </a>
              
              {{-- <a href="tel:{{ $doctor->phone }}" class="text-muted">{{ $doctor->phone }}</a> --}}
            </div>
          </div>

        @empty
          <div class="bg-white p-4 text-center">
              <div class="display-3"><i class="fa fa-procedures"></i></div> 

              <br>

              <p><strong>0</strong> doctors at this time.</p>
          </div>
          
        @endforelse        
      </div>
    </div>

    <div class="col-md-3 order-sm-2 order-1 text-center bg-light rounded py-3">
      <h1>
        Doctors

        <br>

        <small>{{ $user->doctors_count }}</small>
      </h1>
    </div>
  </div>
</div>

@endsection
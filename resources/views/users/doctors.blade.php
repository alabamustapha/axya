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
            <div class="row text-left">
              <a href="{{route('doctors.show', $doctor)}}" class="col-md-5">
                <img src="{{$doctor->avatar}}" height="30" alt="doctor avatar" class="rounded">
                {{$doctor->name}}
              </a>
              
              <span class="text-muted col-md-3">{{ $doctor->specialty->name }}</span>
              <span class="text-muted col-md-4 text-truncate">{{ $doctor->location }}</span>
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

    <div class="col-md-3 order-sm-2 order-1 text-center">
      <div class="card shadow-none">
        <div class="card-heading bg-light p-4 border-bottom">
          <span class="h2">Doctors</span>
        </div>

        <div class="card-body">

          <span class="display-4">{{ $user->doctors_count }}</span>
          
        </div>
      </div>
    </div>

  </div>
</div>

@endsection
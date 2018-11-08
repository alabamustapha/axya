@extends('layouts.app')

@section('content')

@include('layouts.partials.home_header')

<div class="container">
    <div class="row">
            <h2 class="text-primary">Featured doctor</h2>
    </div>
</div>
<div class="container">
    <div class="table-responsive mb-5">
        <div class="card-deck" style="flex-flow: nowrap;">
            @foreach ($doctors as $doctor)
                <div class="card mr-1" style="min-width: 16rem;max-width: 16rem;">
                    <div style="display:block;min-height: 200px;height: 200px;overflow: hidden;">
                        <img class="card-img-top" src="{{ $doctor->dummyAvatar()/*$doctor->user->avatar*/ }}" alt="{{ $doctor->user->name }}" style="display:block;min-height: 200px;">
                    </div>
                    <div class="card-body">
                        <h5 class="card-title d-block text-truncate">
                            <a href="{{route('doctors.show', $doctor->user)}}">{{ $doctor->user->name }}</a>
                        </h5>
                        <h6 class="card-subtitle mb-2 text-muted">
                            <a href="#" style="color: inherit;">Spech{{-- $doctor->specialty --}}</a>
                        </h6>
                        <p class="card-text">Practice Years: {{random_int(2,10)}}</p>
                    </div>
                    <div class="card-footer">
                        <span class="tf-flex mb-2">
                            <small class="text-muted">
                                <span class="fa fa-star text-primary"></span>
                                <span class="fa fa-star text-primary"></span>
                                <span class="fa fa-star text-primary"></span>
                                <span class="fa fa-star text-primary"></span>
                                <span class="fa fa-star text-primary"></span>
                            </small>
                            <span>&nbsp;{{random_int(1,5)}}({{random_int(10,100)}})</span>
                        </span>
                        <a href="#" class="btn btn-primary btn-sm btn-block"><i class="fa fa-calendar-check"></i>&nbsp; Make Appointment</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <div class="text-center">
        <div class="row">
            <div class="col-sm-6">
                <a href="{{route('specialties.index')}}" class="card">
                    <h1 class="card-body red">
                        
                        <i class="fa fa-stethoscope"></i>&nbsp; Doctors By Specialties

                    </h1>
                </a>
            </div>
            <div class="col-sm-6">
                <a href="{{route('tags.index')}}" class="card">
                    <h1 class="card-body teal">
                        
                        <i class="fa fa-tags"></i>&nbsp; Doctors By Keywords
                        
                    </h1>
                </a>
            </div>
        </div>
    </div>
</div>


<div class="jumbotron jumbotron-fluid mt-5 mb-0 bg-white">
        <div class="container">
                <div class="row">
                        <h2 class="text-primary">Testimonials</h2>
                </div>
            </div>
    <div class="container">
        <div class="row">
                <div class="col">
                    <img class="img-responsive rounded-circle mx-auto d-block mb-2" src="{{ asset('images/doc.jpg') }}" alt="" width="100">    
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Special title treatment</h5>
                            <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
                            <a href="#" class="btn btn-primary">Go somewhere</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>


<div class="jumbotron jumbotron-fluid align-middle">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 mt-5">
                <h1 class="display-4">Download on store</h1>
                <p class="lead">Get connected with doctors straight from your phone.</p>
                <a href="#" class="btn btn-primary">Download now</a>
            </div>
            <div class="col-md-4">
                <img src="{{ asset('images/phone.png') }}" alt="phone" height="400">
            </div>
        </div>
        
    </div>
</div>
@endsection

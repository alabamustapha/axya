@extends('layouts.app')

@section('title', 'Welcome') 

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

                @include('doctors.partials._profile')

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

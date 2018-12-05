@extends('layouts.app')

@section('title', 'Welcome') 

@section('content')
<div class="container-fluid px-0 mx-0">
    <div id="leadview">
        <div class="jumbotron jumbotron-fluid mb-0" style="min-height: 90vh;background-color:rgba(0,0,0,.81);">

            @include('layouts.partials.home_header')

        </div>
    </div>

    <div class="jumbotron jumbotron-fluid mb-0 bg-light" style="min-height: 90vh;">
        <div class="container">
            <h1 class="text-dark py-3 text-center text-uppercase text-bold">
                <i class="fa fa-user-md"></i>
                Featured Doctors
            </h1>

            <div class="table-responsive mb-5" id="tp-scrollbar">
                <div data-aos="zoom-out-down" class="card-deck" style="flex-flow: nowrap;">
                    @foreach ($doctors as $doctor)

                        @include('doctors.partials._profile')

                    @endforeach
                </div>
            </div>

            <div class="row text-center pb-4">
                <div class="col-sm-6">
                    <a data-aos="fade-right" href="{{route('specialties.index')}}" class="card shadow-lg">
                        <h1 class="card-body red">
                            
                            <i class="fa fa-stethoscope"></i>&nbsp; Doctors By Specialties

                        </h1>
                    </a>
                </div>
                <div class="col-sm-6">
                    <a data-aos="fade-left" href="{{route('tags.index')}}" class="card shadow-lg">
                        <h1 class="card-body teal">
                            
                            <i class="fa fa-tags"></i>&nbsp; Doctors By Keywords
                            
                        </h1>
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="jumbotron jumbotron-fluid mb-0 bg-dark" style="min-height: 90vh;">
        <div class="container">
            <h1 class="text-white py-3 text-center text-uppercase text-bold">
                <i class="fa fa-poll"></i>
                Testimonials
            </h1>

            {{-- <div class="row">
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
            </div> --}}

            <div data-aos="fade-right"
                data-aos-offset="300"
                data-aos-easing="ease-in-sine" 
                id="testimonialIndicators" class="carousel slide bg-secondary" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#testimonialIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#testimonialIndicators" data-slide-to="1"></li>
                <li data-target="#testimonialIndicators" data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" src="{{asset('/images/bgs/bg-1.jpg')}}" style="width:100%;height: 350px;" alt="First slide">
                  <div class="carousel-caption{{--  d-none d-md-block --}}">
                    <h5>Jason Doe - Special title treatment</h5>
                    <p>...With supporting text below as a natural lead-in to additional content....</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{asset('/images/bgs/bg-2.jpg')}}" style="width:100%;height: 350px;" alt="Second slide">
                  <div class="carousel-caption{{--  d-none d-md-block --}}">
                    <h5>Jane Doe</h5>
                    <p>...caption 2...</p>
                  </div>
                </div>
                <div class="carousel-item">
                  <img class="d-block w-100" src="{{asset('/images/bgs/bg-3.jpg')}}" style="width:100%;height: 350px;" alt="Third slide">
                  <div class="carousel-caption{{--  d-none d-md-block --}}">
                    <h5>Mickey Mouse</h5>
                    <p>...caption 3...</p>
                  </div>
                </div>
              </div>
              <a class="carousel-control-prev" href="#testimonialIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
              </a>
              <a class="carousel-control-next" href="#testimonialIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
              </a>
            </div>
        </div>
    </div>


    <div class="jumbotron jumbotron-fluid" style="min-height: 90vh;">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6 pb-4 text-md-right text-center flex-center position-ref">
                    <div class="">
                        <h1 class="display-4">Download on store</h1>
                        <p class="lead">Get connected with doctors straight from your phone.</p>
                        <a href="#" class="btn btn-primary">Download now</a>
                    </div>
                </div>

                <div class="col-md-4 pb-4 text-md-left text-center">
                    <img src="{{ asset('images/phone.png') }}" alt="phone" height="400">
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection

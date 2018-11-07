@extends('layouts.master')

@section('meta-description', $tag->name)
@section('meta-keywords', '')

@section('title', $tag->name)

@section('content')

<div class="">
  <nav aria-label="breadcrumb" class=" mt-0">
    <ol class="breadcrumb py-1">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('specialties.index') }}">Specialties</a></li>
      <li class="breadcrumb-item"><a href="{{ route('specialties.show', $tag->specialty) }}">{{$tag->specialty->name}}</a></li>
      <li class="breadcrumb-item active" aria-current="page"><b>{{ $tag->name }}</b></li>
      <li class="breadcrumb-item"><a href="{{ route('tags.index')}}">Tags</a></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-md-8">

      <div class="card-deck">
      {{-- @foreach ($doctors as $doctor) --}}
        <div class="card mr-2" style="min-width: 16rem;max-width: 16rem;">
            <div style="display:block;min-height: 200px;height: 200px;overflow: hidden;">
                <img class="card-img-top" src="{{ \App\Doctor::first()->dummyAvatar()/*$doctor->user->avatar*/ }}" alt="{{-- $doctor->user->name --}}" style="display:block;min-height: 200px;">
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{--route('doctors.show', $doctor->user)--}}">{{-- $doctor->user->name --}} Dr. Name</a>
                </h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    <a href="#" style="color: inherit;">Spech{{-- $doctor->tag --}}</a>
                </h6>
                <p class="card-text">Practice Years: {{random_int(2,10)}}</p>
            </div>
            <div class="card-footer tf-flex">
                <span>
                    <small class="text-muted">
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                    </small>
                    &nbsp;{{random_int(1,5)}}({{random_int(10,100)}})
                </span>
                <a href="{{--route('doctors.show', $doctor->user)--}}" class="btn btn-primary btn-sm">View Profile</a>
            </div>
        </div>
        <div class="card mr-2" style="min-width: 16rem;max-width: 16rem;">
            <div style="display:block;min-height: 200px;height: 200px;overflow: hidden;">
                <img class="card-img-top" src="{{ \App\Doctor::first()->dummyAvatar()/*$doctor->user->avatar*/ }}" alt="{{-- $doctor->user->name --}}" style="display:block;min-height: 200px;">
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{--route('doctors.show', $doctor->user)--}}">{{-- $doctor->user->name --}} Dr. Name</a>
                </h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    <a href="#" style="color: inherit;">Spech{{-- $doctor->tag --}}</a>
                </h6>
                <p class="card-text">Practice Years: {{random_int(2,10)}}</p>
            </div>
            <div class="card-footer tf-flex">
                <span>
                    <small class="text-muted">
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                    </small>
                    &nbsp;{{random_int(1,5)}}({{random_int(10,100)}})
                </span>
                <a href="{{--route('doctors.show', $doctor->user)--}}" class="btn btn-primary btn-sm">View Profile</a>
            </div>
        </div>
        <div class="card mr-2" style="min-width: 16rem;max-width: 16rem;">
            <div style="display:block;min-height: 200px;height: 200px;overflow: hidden;">
                <img class="card-img-top" src="{{ \App\Doctor::first()->dummyAvatar()/*$doctor->user->avatar*/ }}" alt="{{-- $doctor->user->name --}}" style="display:block;min-height: 200px;">
            </div>
            <div class="card-body">
                <h5 class="card-title">
                    <a href="{{--route('doctors.show', $doctor->user)--}}">{{-- $doctor->user->name --}} Dr. Name</a>
                </h5>
                <h6 class="card-subtitle mb-2 text-muted">
                    <a href="#" style="color: inherit;">Spech{{-- $doctor->tag --}}</a>
                </h6>
                <p class="card-text">Practice Years: {{random_int(2,10)}}</p>
            </div>
            <div class="card-footer tf-flex">
                <span>
                    <small class="text-muted">
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                        <span class="fa fa-star text-primary"></span>
                    </small>
                    &nbsp;{{random_int(1,5)}}({{random_int(10,100)}})
                </span>
                <a href="{{--route('doctors.show', $doctor->user)--}}" class="btn btn-primary btn-sm">View Profile</a>
            </div>
        </div>
      {{-- @endforeach --}}
      </div>

    </div>

    <div class="col-md-4">
      @if (Auth::check()/* && (Auth::user()->isAdmin() || Auth::user()->isDoctor())*/)
    
        @include('tags.partials.create-form')
      
      @endif

      <br clear="both">

      @include('tags.partials.related-tags')

    </div>
  </div>
</div>

@endsection
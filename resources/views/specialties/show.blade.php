@extends('layouts.master')

@section('meta-description', $specialty->name)
@section('meta-keywords', '')

@section('title', $specialty->name)

@section('content')

<div class="">
  <nav aria-label="breadcrumb" class=" mt-0">
    <ol class="breadcrumb py-1">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('specialties.index') }}">Specialties</a></li>
      <li class="breadcrumb-item active" aria-current="page"><b>{{ $specialty->name }}</b></li>
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
                    <a href="#" style="color: inherit;">Spech{{-- $doctor->specialty --}}</a>
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
                    <a href="#" style="color: inherit;">Spech{{-- $doctor->specialty --}}</a>
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
                    <a href="#" style="color: inherit;">Spech{{-- $doctor->specialty --}}</a>
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
        <div class="card card-primary card-outline text-center shadow">
          <div class="card-header">
            <div class="card-title">
              <i class="fa fa-tags"></i> Add New Keyword
              <br>
              <span style="font-size:12px;">
                <i class="fa fa-info-circle red"></i> For doctors only! {{-- Only medical doctors can see this form. --}}
                <br>
                Add tags or keywords that are relevant to <b>{{$specialty->name}}</b> with this form.
              </span>
            </div>
          </div>

          <div class="card-body">
            <form action="{{ route('tags.store') }}" method="post">
              {{ csrf_field() }}

              <input type="hidden" name="specialty_id" value="{{$specialty->id}}">

              <div class="form-group">
                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="keyword, illness, procedure" required>

                @if ($errors->has('name'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
              </div>

              <div class="form-group">
                <textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" placeholder="short description" style="min-height: 100px;max-height: 150px;" required>{{ old('description') }}</textarea>

                @if ($errors->has('description'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('description') }}</strong>
                    </span>
                @endif
              </div>

              <button type="submit" class="btn btn-block btn-primary">Create Keyword</button>
            </form>
          </div>

          <div class="card-footer">
            <span class="text-danger"><b>Relevant keywords help patients in locating relevant doctors easily.</b></span>
          </div>
        </div>
      @endif

      <br clear="both">

      <div class="p-3 shadow bg-white text-center">
        Medical terms, illnesses, procedures under <b>{{$specialty->name}}</b> 
        <span class="badge badge-primary">{{$specialty->tags->count()}}</span>.
        <hr>
        @foreach ($specialty->tags as $tag)
          <span class="keyword-labels">
            <a href="{{ route('tags.show', $tag) }}">{{ $tag->name }}</a>
          </span>
        @endforeach
      </div>
    </div>
  </div>
</div>

@endsection
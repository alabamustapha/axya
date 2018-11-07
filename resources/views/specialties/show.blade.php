@extends('layouts.master')

@section('meta-description', $specialty->name)
@section('meta-keywords', '')

@section('title', $specialty->name)

@section('content')

<div class="">
  <nav aria-label="breadcrumb" class=" mt-0">
    <ol class="breadcrumb p-1">
      <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('specialties.index') }}">Specialties</a></li>
      <li class="breadcrumb-item active" aria-current="page"><b>{{ $specialty->name }}</b></li>
    </ol>
  </nav>

  <div class="row">
    <div class="col-md-8">

      List of Doctors under {{$specialty->name}}, with statistics <br>
      List of Tags under {{$specialty->name}}

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
              <i class="fa fa-plus"></i> Add New Tag/Content
            </div>
          </div>

          <div class="card-body">
            <form action="{{--route('tags.store')--}}" method="post">
              {{ csrf_field() }}

              <input type="hidden" name="specialty_id" value="{{$specialty->id}}">

              {{-- <div class="form-group">
                <label for="specialty_id" class="col-form-label">{{ __('Specialty Name') }}</label>
                <select name="specialty_id" class="form-control{{ $errors->has('specialty_id') ? ' is-invalid' : '' }}" value="{{ old('specialty_id') }}" required>
                  <option value="">Select Specialty</option>
                  @foreach($specialties as $specialty)
                    <option value="{{ $specialty->id }}">{{ $specialty->name }}</option>
                  @endforeach
                </select>

                @if ($errors->has('specialty_id'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('specialty_id') }}</strong>
                    </span>
                @endif
              </div> --}}

              <div class="form-group">
                <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="tag/content name" required>

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

              <button type="submit" class="btn btn-block btn-primary">Submit</button>
            </form>
          </div>
          <div class="card-footer">            
            <span class="text-muted">
                Medical Terms, procedures etc under <b>{{$specialty->name}}</b>
            </span>
          </div>
        </div>
      @endif

      <br clear="both">

      <div class="card p-3">
        {{-- @foreach ($specialty->tags as $tag)
          <a href="{{ route('tags.show', $tag) }}"><span class="badge">{{ $tag->name }}</span></a>, 
        @endforeach --}}
        @ foreach <br>
          $tags as $tag  <br>
        @ endforeach <br>
        paginate(100)
      </div>
    </div>
  </div>
</div>

@endsection
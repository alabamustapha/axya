@extends('layouts.master')

@section('meta-description', '')
@section('meta-keywords', '')

@section('title', "Medical Specialties Index")

@section('content')

<nav aria-label="breadcrumb" class=" mt-0">
  <ol class="breadcrumb p-1">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><b>Specialties</b></li>
  </ol>
</nav>
  
<div class="row">
	<div class="col-md-8">
		<h1>Medical Specialties</h1>

		@forelse ($specialties as $specialty)
      <a href="{{ route('specialties.show', $specialty) }}" style="color: inherit;text-decoration:none;">
        <div class="card shadow-sm">
          <div class="card-body">
            <blockquote class="blockquote mb-0">
              <p>
                <span class="blue">
                  {{ $specialty->name }}
                </span>
                <span class="pull-right">
                  <span class="badge badge-dark badge-sm" title="Doctors with {{ $specialty->name }} specialty">
                    {{random_int(5,100)}}
                    {{-- $specialty->doctors_count --}}
                  </span>
                  <small>Doctor(s)</small>
                </span>
              </p>
              <footer class="blockquote-footer">{{ $specialty->description }}</footer>
            </blockquote>
          </div>
          <div class="card-footer">
            @ 5 tags + <button class="btn btn-sm btn-info">see more</button>
          </div>
        </div>
      </a>
    @empty
      <div class="empty-list bg-white">
        0 specialties at the moment
      </div>
		@endforelse
	</div>

  <div class="col-md-4">
    @if (Auth::check()/* && (Auth::user()->isAdmin() || Auth::user()->isDoctor())*/)
      <div class="card card-primary card-outline text-center shadow">
        <div class="card-header">
          <div class="card-title">
            <i class="fa fa-plus"></i> Add New Specialty
          </div>
        </div>

        <div class="card-body">
					<form action="{{route('specialties.store')}}" method="post">
						{{ csrf_field() }}

	       		<div class="form-group">
							<input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="specialty name" required>

	            @if ($errors->has('name'))
	                <span class="invalid-feedback" role="alert">
	                    <strong>{{ $errors->first('name') }}</strong>
	                </span>
	            @endif
	          </div>

	       		<div class="form-group">
							<textarea name="description" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"  style="min-height: 100px;max-height: 150px;" placeholder="description" required>{{ old('description') }}</textarea>

	            @if ($errors->has('description'))
	                <span class="invalid-feedback" role="alert">
	                    <strong>{{ $errors->first('description') }}</strong>
	                </span>
	            @endif
	          </div>

						<button type="submit" class="btn btn-block btn-primary">New Specialty</button>
					</form>
        </div>
        <div class="card-footer">            
          <span class="text-muted">
              <b>Medical Fields of Specialization</b> <br>
              <i class="fa fa-info-circle brown"></i>&nbsp; Only medical doctors can see this form or allowed to create new specialties.
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

@endsection

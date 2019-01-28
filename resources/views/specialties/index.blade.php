@extends('layouts.master')

@section('meta-description', '')
@section('meta-keywords', '')

@section('title', "Medical Specialties Index")

@section('content')
  
<div class="row">
	<div class="col-md-8">
    <div class="card shadow-sm">
        <div class="card-body">
          <h1>Medical Specialties</h1>
        </div>
    </div>

		@forelse ($specialties as $specialty)
      
      <div class="card shadow-sm">
        <div class="card-body">
          <blockquote class="blockquote mb-0">
            <a href="{{ route('specialties.show', $specialty) }}">
              <p>
                {{ $specialty->name }}
                <span class="pull-right" style="color: inherit;">
                  <span class="badge badge-dark badge-sm" title="Doctors with {{ $specialty->name }} specialty">
                    {{ $specialty->doctors_count }}
                    <small>Doctor(s)</small>
                  </span>
                </span>
              </p>
            </a>
            <footer class="blockquote-footer">{{ $specialty->description }}</footer>
          </blockquote>
        </div>
      </div>
    @empty
      <div class="text-center">
        <div class="display-3"><i class="fa fa-stethoscope"></i></div> 

        <br>

        <p>You have <strong>0</strong> specialties at this time.</p>
      </div>
		@endforelse
	</div>

  <div class="col-md-4">
    @can ('create', App\Specialty::class)
      <div class="card card-primary card-outline text-center shadow">
        <div class="card-header">
          <div class="card-title">
            <i class="fa fa-stethoscope"></i> Add New Specialty
              <br>
              <span style="font-size:12px;">
                <i class="fa fa-info-circle red"></i> For doctors only! <br>
                <b>Add your specialty if not available of this platform yet.</b>
              </span>
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

						<button type="submit" class="btn btn-block btn-primary">Create Specialty</button>
					</form>
        </div>
        <div class="card-footer">            
          <span class="text-muted">
              <b>Medical Fields of Specialization</b> <br>
              <i class="fa fa-info-circle brown"></i>&nbsp; Only medical doctors can see this form or allowed to create new specialties. 
          </span>
        </div>
      </div>
    @endcan

    <div class="p-3 shadow bg-white text-center">
      ...
    </div>
  </div>
</div>

@endsection

@extends('layouts.master')

@section('meta-description', '')
@section('meta-keywords', '')

@section('title', "Medications Index")

@section('content')
  
<div class="row">
	<div class="col-md-7">
    <div class="card shadow-sm">
        <div class="card-body">
          <h1>Medications</h1>
        </div>
    </div>

		@forelse ($medications as $medication)
      
      <div class="card shadow-sm">
        <div class="card-body">
          <blockquote class="blockquote mb-0">
            <a href="{{ $medication->link }}">
              <p>

                {{ $medication->title }}

              </p>
            </a>
            <footer class="blockquote-footer">{{ $medication->description }}</footer>
          </blockquote>
        </div>
      </div>
    @empty
      <div class="text-center">
        <div class="display-3"><i class="fa fa-pills"></i></div> 

        <br>

        <p>You have <strong>0</strong> medications at this time.</p>
      </div>
		@endforelse
	</div>

  <div class="col-md-5">
    @can ('create', App\Medication::class)
      <div class="card card-primary card-outline text-center shadow">
        <div class="card-header">
          <div class="card-title">

            <i class="fa fa-pills"></i> Add New Medication

          </div>
        </div>

        <div class="card-body">
					<form action="{{route('medications.store', Auth::user())}}" method="post" class="text-left">
						{{ csrf_field() }}

            <div class="form-group">
              <label class="text-sm" for="title">Medication Title <small class="red" title="Required field">*</small></label>
              <input type="text" name="title" class="form-control-sm form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') }}" placeholder="Title" required>

              @if ($errors->has('title'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('title') }}</strong>
                  </span>
              @endif
            </div>

	       		<div class="form-group">
              <label class="text-sm" for="title" title="Link to an Active Prescription">
                <i class="fa fa-file-prescription"></i> Link to an Active Prescription
                <small class="text-info" title="Not Required">Not Required</small>
              </label>
							<select type="text" name="prescription_id" class="form-control-sm form-control{{ $errors->has('prescription_id') ? ' is-invalid' : '' }}" value="{{ old('prescription_id') }}" placeholder="medication prescription_id">
                <option value="">Select Prescription</option>
                @forelse ($prescriptions as $prescription)
                  <option value="{{ $prescription->id }}" {{ old('prescription_id') ? 'selected':'' }}>
                    {{ $prescription->appointment->description_preview }}
                  </option>
                @empty
                  {{-- <option>No prescrition</option> --}}
                  <span>No prescrition</span>
                @endforelse
              </select>

	            @if ($errors->has('prescription_id'))
	                <span class="invalid-feedback" role="alert">
	                    <strong>{{ $errors->first('prescription_id') }}</strong>
	                </span>
	            @endif
	          </div>

	       		<div class="form-group">
              <label class="text-sm" for="title">Medication Description <small class="red" title="Required field">*</small></label>
							<textarea name="description" class="form-control-sm form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"  style="min-height: 100px;max-height: 150px;" placeholder="description" required>{{ old('description') }}</textarea>

	            @if ($errors->has('description'))
	                <span class="invalid-feedback" role="alert">
	                    <strong>{{ $errors->first('description') }}</strong>
	                </span>
	            @endif
	          </div>

            <div class="form-group">
              <label class="text-sm" for="start_date">Start Date <small class="red" title="Required field">*</small></label>

              <div class="row">
                <div class="col-6">
                  <input type="date" name="start_date" class="form-control-sm form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') }}" placeholder="start date" required>

                  @if ($errors->has('start_date'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('start_date') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="col-6">
                  <input type="time" name="start_time" class="form-control-sm form-control{{ $errors->has('start_time') ? ' is-invalid' : '' }}" value="{{ old('start_time') }}" placeholder="start date" required>

                  @if ($errors->has('start_time'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('start_time') }}</strong>
                      </span>
                  @endif
                </div>
              </div>
            </div>

            <div class="form-group">
              <label class="text-sm" for="end_date">End Date <small class="red" title="Required field">*</small></label>
              <input type="date" name="end_date" class="form-control-sm form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ old('end_date') }}" placeholder="end date" required>

              @if ($errors->has('end_date'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('end_date') }}</strong>
                  </span>
              @endif
            </div>

            <div class="form-group">
              <label class="text-sm" for="notify_by">Notification Time <small class="red" title="Required field"> (Minutes)*</small></label>
              <input type="number" min="0" name="notify_by" class="form-control-sm form-control{{ $errors->has('notify_by') ? ' is-invalid' : '' }}" value="{{ old('notify_by') }}" placeholder="30 mins" required>

              @if ($errors->has('notify_by'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('notify_by') }}</strong>
                  </span>
              @endif
            </div>

            <div class="form-group">
              <label class="text-sm">Recurrence (Notify Every) <small class="red" title="Required field">*</small></label>

              <div class="row">
                <div class="col-4">
                  <input type="number" min="0" name="recurrence" class="form-control-sm form-control{{ $errors->has('recurrence') ? ' is-invalid' : '' }}" value="{{ old('recurrence') }}" placeholder="45" required>

                  @if ($errors->has('recurrence'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('recurrence') }}</strong>
                      </span>
                  @endif
                </div>
                  
                <div class="col-8">
                  <select name="recurrence_type" class="form-control-sm form-control{{ $errors->has('recurrence_type') ? ' is-invalid' : '' }}" required>
                    <option value="">Select Type</option>
                    @php
                      $types = ['minutes', 'hours', 'days', 'weeks', 'months', 'years'];
                    @endphp
                    @foreach ($types as $type)
                    <option value="{{ $type }}" {{ old('type') == $type ? 'selected':'' }}>{{ ucfirst($type) }}</option>
                    @endforeach
                  </select>

                  @if ($errors->has('recurrence_type'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('recurrence_type') }}</strong>
                      </span>
                  @endif
                </div>
              </div>

            </div>

						<button type="submit" class="btn btn-block btn-primary">Create Medication</button>
					</form>
        </div>
      </div>
    @endcan
  </div>
</div>

@endsection

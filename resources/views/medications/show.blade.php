@extends('layouts.master')

@section('meta-description', $medication->title)
@section('meta-keywords', '')

@section('title', $medication->title)

@section('content')

<div class="row">
  <div class="col-md-7">
    <div class="card shadow-sm">
      <div class="card-body">

        <div class="border-bottom pb-2 mb-3">
          <strong>{{ $medication->title }}</strong>

          @can('edit', $medication)  
            <span class="float-right">
              <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#medicationUpdateForm" title="Update Medication">
                <i class="fa fa-edit teal"></i>&nbsp; edit
              </button>
            </span>
          @endcan
        </div>


        <div class="blockquote mb-0">
          @if ($prescription)
            <div class="blockquote-footer mb-4">
                <a href="{{ route('prescriptions.show', $prescription) }}" class="teal">
                  Linked Prescription <i class="fa fa-external-link-alt"></i>
                </a>:&nbsp;
                {{ $prescription->appointment->description }}
            </div>

            @if ($medication->description)
              <h5>More description:</h5>
            @endif
          @endif

          <div class="blockquote-footer mt-2">
            {{ $medication->description }}
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="col-md-5">
    <ul class="list-unstyled bg-primary rounded p-3 mb-2">

      <li class="bg-white p-2 mb-1">
        <i class="fas fa-clock fa-fw"></i> &nbsp; Duration: 
        <span class="float-right">
          <kbd>{{ $medication->start_time }}, {{ $medication->start }}</kbd> - <kbd>{{ $medication->end }}</kbd>
        </span>
      </li>

      <li class="bg-white p-2 mb-1">
        <i class="fas fa-bell fa-fw"></i> &nbsp; Time to Nofity: 
        <kbd class="float-right">{{ $medication->notify_by }}minutes</kbd>
      </li>

      <li class="bg-white p-2 mb-1">
        <i class="fas fa-hourglass-half fa-fw"></i> &nbsp; Notify Every: 
        <kbd class="float-right">{{ $medication->recurrence }}{{ $medication->recurrence_type }}</kbd>
      </li>

      <li>&nbsp;</li>
      <li class="bg-warning p-2 mb-1">
        <i class="fas fa-stopwatch fa-fw"></i> &nbsp; Next Recurrence: 
        <kbd class="float-right">{{ $medication->next_recurrence }}</kbd>
      </li>

    </ul>
  </div>
</div>


@can('edit', $medication)
  <div class="modal bg-transparent" tabindex="-1" role="dialog" id="medicationUpdateForm" style="display:none;" aria-labelledby="medicationUpdateFormLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content px-0 pb-0 m-0 shadow-none">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="padding: 5px 15px 0px;margin:10px auto -25px">
          <span aria-hidden="true">&times;</span>
        </button>
        <br>
        <div class="modal-body">

          <div class="card card-primary card-outline text-center shadow">
            <div class="card-header">
              <div class="card-title">
                <h5>Update the Medication: <strong><i class="fa fa-tags"></i>&nbsp;{{$medication->title}}</strong> </h5>
              </div>
            </div>

            <div class="card-body">

              <form action="{{route('medications.update', [$medication->user, $medication])}}" method="post">
                {{ csrf_field() }}
                {{ method_field('PATCH') }} 

                <div class="form-group">
                  <label class="text-sm" for="title">Medication Title <small class="red" title="Required field">*</small></label>
                  <input type="text" name="title" class="form-control-sm form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="{{ old('title') ?:$medication->title }}" placeholder="Title" required>

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
                  <select name="prescription_id" class="form-control-sm form-control{{ $errors->has('prescription_id') ? ' is-invalid' : '' }}">
                    <option value="">Select Prescription</option>
                    @forelse ($prescriptions as $prescription)
                      <option value="{{ $prescription->id }}" 
                          {{ ((old('prescription_id') == $prescription->id) || ($medication->prescription_id == $prescription->id)) ? 'selected':'' }}>
                        {{ $prescription->appointment->description_preview }}
                      </option>
                    @empty
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
                  <textarea 
                    name="description" 
                    class="form-control-sm form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                    style="min-height: 100px;max-height: 150px;" 
                    placeholder="description" 
                    maxlength="450" 
                    required>{{ old('description') ?: $medication->description }}</textarea>

                  @if ($errors->has('description'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('description') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <label class="text-sm" for="start_date">Start Date <small class="red" title="Required field">yyyy-mm-dd *</small></label>

                  <div class="row">
                    <div class="col-6">
                      <input type="text" maxlength="10" minlength="10" name="start_date" class="form-control-sm form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') ?: substr($medication->start_date, 0, 10) }}" placeholder="{{ date('Y-m-d') }}" required>

                      @if ($errors->has('start_date'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('start_date') }}</strong>
                          </span>
                      @endif
                    </div>

                    <div class="col-6">
                      <input type="text" maxlength="5" minlength="5" name="start_time" class="form-control-sm form-control{{ $errors->has('start_time') ? ' is-invalid' : '' }}" value="{{ \Carbon\Carbon::parse(old('start_time') ?:$medication->start_time)->format('H:i') }}" placeholder="21:00" required>

                      @if ($errors->has('start_time'))
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $errors->first('start_time') }}</strong>
                          </span>
                      @endif
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label class="text-sm" for="end_date">End Date <small class="red" title="Required field">yyyy-mm-dd *</small></label>
                  <input type="text" maxlength="8" minlength="8" name="end_date" class="form-control-sm form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ old('end_date') ?: substr($medication->end_date, 0, 10) }}" placeholder="{{ date('Y-m-d') }}" required>

                  @if ($errors->has('end_date'))
                      <span class="invalid-feedback" role="alert">
                          <strong>{{ $errors->first('end_date') }}</strong>
                      </span>
                  @endif
                </div>

                <div class="form-group">
                  <label class="text-sm" for="notify_by">Notification Time <small class="red" title="Required field"> (Minutes)*</small></label>
                  <input type="number" min="0" name="notify_by" class="form-control-sm form-control{{ $errors->has('notify_by') ? ' is-invalid' : '' }}" value="{{ old('notify_by') ?:$medication->notify_by }}" placeholder="30 mins" required>

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
                      <input type="number" min="0" name="recurrence" class="form-control-sm form-control{{ $errors->has('recurrence') ? ' is-invalid' : '' }}" value="{{ old('recurrence') ?:$medication->recurrence }}" placeholder="45" required>

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
                        <option value="{{ $type }}" {{ (old('type') == $type || $medication->recurrence_type == $type) ? 'selected':'' }}>{{ ucfirst($type) }}</option>
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

                <button type="submit" class="btn btn-block btn-primary">Update Medication</button>
              </form>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endcan

@endsection
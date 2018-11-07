<div class="card card-primary card-outline text-center shadow">
  <div class="card-header">
    <div class="card-title">
      <i class="fa fa-tags"></i> Add New Keyword
      <br>
      <span style="font-size:12px;">
        <i class="fa fa-info-circle red"></i> For doctors only! {{-- Only medical doctors can see this form. --}}
        <br>
        Add tags or keywords that are relevant to your specialization if not available yet.
      </span>
    </div>
  </div>

  <div class="card-body">
    
    <form action="{{route('tags.store')}}" method="post">
      {{ csrf_field() }}

      <div class="form-group">
        <select name="specialty_id" class="form-control{{ $errors->has('specialty_id') ? ' is-invalid' : '' }}" value="" required>
          <option value="">Select Specialty</option>
          @foreach($specialties as $specialty)
            <option value="{{ $specialty->id }}" {{ old('specialty_id') == $specialty->id ? 'selected':'' }}>{{ $specialty->name }}</option>
          @endforeach
        </select>

        @if ($errors->has('specialty_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('specialty_id') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group">
        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="keyword, illness, procedure" required>

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

      <button type="submit" class="btn btn-block btn-primary">Create Keyword</button>
    </form>

  </div>

  <div class="card-footer">
    <span class="text-danger"><b>Relevant keywords help patients in locating relevant doctors easily.</b></span>
  </div>
</div>

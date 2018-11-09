<div class="card card-primary card-outline text-center shadow">
  <div class="card-header">
    <div class="card-title">
      <i class="fa fa-hospital-alt"></i> Add New Workplace
    </div>
  </div>

  <div class="card-body">
    
    <form action="{{route('workplaces.store')}}" method="post">
      {{ csrf_field() }}

      <div class="form-group">
        <input type="hidden" name="doctor_id" value="{{$doctor->id}}">
        <input type="text" name="name" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" value="{{ old('name') }}" placeholder="name of hospital" required>

        @if ($errors->has('name'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
        @endif
      </div>

      <div class="form-group">
        <input type="text" name="address" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" value="{{ old('address') }}" placeholder="address of hospital" required>

        @if ($errors->has('address'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
      </div>

      <div class="row">
        <div class="col-sm-6"> 
          <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" class="form-control{{ $errors->has('start_date') ? ' is-invalid' : '' }}" value="{{ old('start_date') }}" required>

            @if ($errors->has('start_date'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('start_date') }}</strong>
                </span>
            @endif
          </div>
        </div>
        <div class="col-sm-6"> 
          <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" class="form-control{{ $errors->has('end_date') ? ' is-invalid' : '' }}" value="{{ old('end_date') }}">

            @if ($errors->has('end_date'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('end_date') }}</strong>
                </span>
            @endif
          </div>
        </div>
      </div>

      <button type="submit" class="btn btn-block btn-primary">Add Workplace</button>
    </form>
  </div>
</div>

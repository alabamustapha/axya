<form method="POST" action="{{ route('doctors.update', $doctor) }}">
    @csrf
    {{ method_field('PATCH') }}
    
    <div class="form-group row border-bottom">
        <label class="col-12 text-center h4">Official Profile Update</label>
    </div>

    <div class="form-group row">
        <label for="rate" class="col-md-4 col-form-label text-md-right">{{ __('Hourly Rate') }}</label>

        <div class="col-md-7">
          <div class="input-group mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text">$</span>
            </div>
            <input type="number" name="rate" min="5.00" max="1500.00" step="0.01" 
                value="{{ old('rate') ?: $doctor->rate }}" maxlength="7" placeholder="$20.50" 
                id="rate" class="form-control{{ $errors->has('rate') ? ' is-invalid' : '' }}"
                required autofocus>
            <div class="input-group-append">
              <span class="input-group-text"> / hour</span>
            </div>
          </div>

          @if ($errors->has('rate'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('rate') }}</strong>
              </span>
          @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="rate" class="col-md-4 col-form-label text-md-right">{{ __('Availability') }}</label>

        <div class="col-md-7">
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="available" id="available" value="1" 
              {{(old('available') == '1' || $doctor->available == '1') ? 'checked':''}}>
            <label class="form-check-label text-success" for="available">Available</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="available" id="unavailable" value="0" 
              {{(old('available') == '0' || $doctor->available == '0') ? 'checked':''}}>
            <label class="form-check-label text-danger" for="unavailable">Not Available</label>
          </div>

          @if ($errors->has('available'))
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $errors->first('available') }}</strong>
              </span>
          @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="specialty_id" class="col-md-4 col-form-label text-md-right">{{ __('Specialty') }}</label>

        <div class="col-md-7">
            <select id="specialty_id" class="form-control{{ $errors->has('specialty_id') ? ' is-invalid' : '' }}" name="specialty_id" required>
                <option value="">Select Specialty</option>
                @foreach($specialties as $specialty)
                  <option value="{{$specialty->id}}" {{(old('specialty_id') == $specialty->id || $doctor->specialty_id == $specialty->id) ? 'selected':''}}>{{$specialty->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('specialty_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('specialty_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="workplace_id" class="col-md-4 col-form-label text-md-right">{{ __('Current Workplace') }}</label>

        <div class="col-md-7">
            <select id="workplace_id" class="form-control{{ $errors->has('workplace_id') ? ' is-invalid' : '' }}" name="workplace_id" required>
                <option value="">Select Workplace</option>
                @foreach($workplaces as $workplace)
                  <option value="{{$workplace->id}}" {{(old('workplace_id') == $workplace->id || $current_workplace->id == $workplace->id) ? 'selected':''}}>{{$workplace->name}}</option>
                @endforeach
            </select>

            @if ($errors->has('workplace_id'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('workplace_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Official Phone') }}</label>

        <div class="col-md-7">
            <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') ?: $doctor->phone }}" placeholder="your phone address">

            @if ($errors->has('phone'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Official Email') }}</label>

        <div class="col-md-7">
            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') ?: $doctor->email }}" placeholder="your email address">

            @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="about" class="col-md-4 col-form-label text-md-right">{{ __('About You') }}</label>

        <div class="col-md-7">
            <textarea id="about" class="form-control{{ $errors->has('about') ? ' is-invalid' : '' }}" 
              maxlength="1500" style="max-height: 150px;height: 150px;"
              name="about" placeholder="write about specialization, expertise and work history etc"
              >{{ old('about') ?: $doctor->about }}</textarea>

            @if ($errors->has('about'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('about') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="location" class="col-md-4 col-form-label text-md-right">{{ __('Address Location') }}</label>

        <div class="col-md-7">
            <input id="location" type="text" class="form-control{{ $errors->has('location') ? ' is-invalid' : '' }}" name="location" value="{{ old('location') ?: $doctor->location }}" placeholder="city, state, country">

            @if ($errors->has('location'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('location') }}</strong>
                </span>
            @endif
        </div>
    </div>
    

    <div class="form-group row mb-0">
        <div class="col-md-7 offset-md-4">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Update') }}
            </button>
        </div>
    </div>
</form>
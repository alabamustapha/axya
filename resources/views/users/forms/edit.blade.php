<form method="POST" action="{{ route('users.update', $user) }}">
    @csrf
    {{ method_field('PATCH') }}

    <div class="form-group row">
        <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

        <div class="col-md-6">
            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') ?: $user->name }}" placeholder="Firstname Surname" required autofocus>

            @if ($errors->has('name'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="gender" class="col-md-4 col-form-label text-md-right">{{ __('Gender') }}</label>

        <div class="col-md-6">
            <select id="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}" name="gender" required>
                <option value="">Select Gender</option>
                <option value="Male" {{old('gender') ?: $user->gender == 'Male' ? 'selected':''}}>Male</option>
                <option value="Female" {{old('gender') ?: $user->gender == 'Female' ? 'selected':''}}>Female</option>
                <option value="Other" {{old('gender') ?: $user->gender == 'Other' ? 'selected':''}}>Other</option>
            </select>

            @if ($errors->has('gender'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('gender') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="dob" class="col-md-4 col-form-label text-md-right">{{ __('Date of Birth') }}</label>

        <div class="col-md-6">
            <input type="text" id="dob" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" value="{{old('dob') ?: substr($user->dob, 0, 10)}}" name="dob" placeholder="yyyy-mm-dd" required>

            @if ($errors->has('dob'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('dob') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="phone" class="col-md-4 col-form-label text-md-right">{{ __('Phone') }}</label>

        <div class="col-md-6">
            <input id="phone" type="tel" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') ?: $user->phone }}" placeholder="your phone address">

            @if ($errors->has('phone'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="weight" class="col-md-4 col-form-label text-md-right">{{ __('Weight (KG)') }}</label>

        <div class="col-md-6">
            <input id="weight" type="weight" class="form-control{{ $errors->has('weight') ? ' is-invalid' : '' }}" name="weight" value="{{ old('weight') ?: $user->weight }}" placeholder="weight">

            @if ($errors->has('weight'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('weight') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="height" class="col-md-4 col-form-label text-md-right">{{ __('Height (metres)') }}</label>

        <div class="col-md-6">
            <input id="height" type="text" class="form-control{{ $errors->has('height') ? ' is-invalid' : '' }}" name="height" value="{{ old('height') ?: $user->height }}" placeholder="height">

            @if ($errors->has('height'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('height') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Address Location') }}</label>

        <div class="col-md-6">
            <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') ?: $user->address }}" placeholder="address">

            @if ($errors->has('address'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
    </div>
    

    <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
            <button type="submit" class="btn btn-primary btn-block">
                {{ __('Update') }}
            </button>
        </div>
    </div>
</form>
<form method="POST" action="{{ route('allergies.update', $user) }}">
    @csrf
    {{ method_field('PATCH') }}

    <div class="form-group">
        <label for="allergies" class="col-12 text-center h4 mb-4 p-3 bg-light">
            <i class="fa fa-allergies mr-1"></i> 
            {{ __('Allergies Update') }}
        </label>

        <div class="col-12">

            <textarea id="allergies" class="form-control{{ $errors->has('allergies') ? ' is-invalid' : '' }}" name="allergies" placeholder="type in your common allergies" style="min-height: 120px;" required autofocus>{{ old('allergies') ?: $user->allergies }}</textarea>

            @if ($errors->has('allergies'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('allergies') }}</strong>
                </span>
            @endif
        </div>    
    </div>

    <div class="form-group col-12">
        <button type="submit" class="btn btn-primary btn-block">
            {{ __('Update') }}
        </button>
    </div>
</form>

<form method="POST" action="{{ route('chronics.update', $user) }}">
    @csrf
    {{ method_field('PATCH') }}

    <div class="form-group row">
        <label for="chronics" class="col-12 text-center h4">{{$user->name}} {{ __('Chronic Illnesses Update') }}</label>

        <br>

        <div class="col-12">

            <textarea id="chronics" class="form-control{{ $errors->has('chronics') ? ' is-invalid' : '' }}" name="chronics" placeholder="type in your common chronic illnesses" style="min-height: 120px;" required autofocus>{{ old('chronics') ?: $user->chronics }}</textarea>

            @if ($errors->has('chronics'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('chronics') }}</strong>
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

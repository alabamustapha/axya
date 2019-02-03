 @component('app_settings::input_group', compact('field'))

    <input type="tel"
           name="{{ $field['name'] }}"
           @if( $placeholder = array_get($field, 'placeholder') )
           placeholder="{{ $placeholder }}"
           @endif
           value="{{ old($field['name'], \setting($field['name'])) }}"
           class="{{ array_get( $field, 'class', config('app_settings.input_class', 'form-control')) }} {{ $errors->has($field['name']) ? config('app_settings.input_invalid_class', 'is-invalid') : '' }}"
           @if( $styleAttr = array_get($field, 'style')) style="{{ $styleAttr }}" @endif
           @if( $maxlengthAttr = array_get($field, 'maxlength')) maxlength="{{ $maxlengthAttr }}" @endif
           @if( $requiredAttr = array_get($field, 'required')) required="{{ $requiredAttr }}" @endif
           id="{{ array_get($field, 'name') }}"
    >

    @if( $append = array_get($field, 'append'))
        <span>{{ $append }}</span>
    @endif

@endcomponent

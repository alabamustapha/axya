<div class="container">
    <div class="row">
        <div class="col-md-9 offset-md-1">

            @includeIf(config('app_settings.flash_partial'))

            <form method="post" action="{{ config('app_settings.url') }}" class="form-horizontal mb-3" enctype="multipart/form-data" role="form">
                {!! csrf_field() !!}

                @if( isset($settingsUI) && count($settingsUI) )

                    @foreach(array_get($settingsUI, 'sections', []) as $section => $fields)
                        @component('app_settings::section', compact('fields'))
                            <div class="{{ array_get($fields, 'section_body_class', config('app_settings.section_body_class', 'card-body')) }}">
                                <div class="row">
                                    @foreach(array_get($fields, 'inputs', []) as $field)
                                        @if(!view()->exists('app_settings::fields.' . $field['type']))
                                            <div style="background-color: #f7ecb5; box-shadow: inset 2px 2px 7px #e0c492; border-radius: 0.3rem; padding: 1rem; margin-bottom: 1rem">
                                                Defined setting <strong>{{ $field['name'] }}</strong> with
                                                type <code>{{ $field['type'] }}</code> field is not supported. <br>
                                                You can create a <code>fields/{{ $field['type'] }}.blade.php</code> to render this input however you want.
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            @includeIf('app_settings::fields.' . $field['type'] )
                                        </div>
                                @endforeach
                                </div>
                            </div>
                        @endcomponent
                    @endforeach
                @endif

                <div class="row m-b-md">
                    <div class="col-md-12">
                        <button class="btn-primary btn">
                            {{ array_get($settingsUI, 'submit_btn_text', 'Save Settings') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

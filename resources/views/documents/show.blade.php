@section('layouts.master')

@section('title', $document->name .' Document')

@section('content')
<embed
    src="{{ action('DocumentController@show', $document->id) }}"
    style="width:600px; height:800px;"
    frameborder="0"
>
@endsection
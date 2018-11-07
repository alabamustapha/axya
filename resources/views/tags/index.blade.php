@extends('layouts.master')

@section('meta-description', 'COntents associated with...')
@section('meta-keywords', '')

@section('title', "Tags Index")

@section('content')

<nav aria-label="breadcrumb" class=" mt-0">
  <ol class="breadcrumb py-1">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('specialties.index') }}">Specialties</a></li>
    <li class="breadcrumb-item"><b>Tags</b></li>
  </ol>
</nav>
  
<div class="row">
	<div class="col-md-8">
		<h1>Medical Terms, Procedures, Illnesses etc</h1>

		<div class="row">
      @forelse ($tags as $tag)
        <a href="{{ route('tags.show', $tag) }}" class="col-sm-6" style="color: inherit;text-decoration:none;" title="{{$tag->specialty->name}}">
          <div class="card shadow-sm mr-1">
            <div class="card-body py-1">
              <blockquote class="blockquote mb-0">
                <footer class="blockquote-footer">
                  <span class="blue text-weight-bold">
                    {{ $tag->name }}
                  </span>
                  {{ $tag->description }}</footer>
              </blockquote>
            </div>
          </div>
        </a>
      @empty
        <div class="empty-list bg-white">
          0 tags at the moment
        </div>
  		@endforelse
    </div>
    <div>{{ $tags->links() }}</div>
	</div>

  <div class="col-md-4">
    @if (Auth::check()/* && (Auth::user()->isAdmin() || Auth::user()->isDoctor())*/)

      @include('tags.partials.create-form')

    @endif

    <br clear="both">

    <div class="bg-white p-2 shadow text-center">
      <b>Available Specialties</b>

      <hr>

      @foreach ($specialties as $specialty)
        <span class="keyword-labels">
          <a href="{{ route('specialties.show', $specialty) }}" class="d-inline p-1">{{ $specialty->name }}</a>
        </span>
      @endforeach
    </div>

  </div>
</div>

@endsection

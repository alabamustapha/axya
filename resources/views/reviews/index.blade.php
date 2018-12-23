@extends('layouts.master')

@section('title')
    {{-- @if (Request::is('reviews/*')) --}}
    @if (Request::path() == 'reviews')
        User Reviews Index
    @else
        Doctor Reviews Index
    @endif
@endsection

@section('content')

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
        <h1 class="h2">Patient Reviews Dashboard</h1>
    </div>

    <div class="">
            
        @forelse($reviews as $review)
            <div>
                <h5>{{$review->doctor->name}}</h5>

                <p>
                    {{$review->comment}} <br>
                    Rating: {{$review->rating}}
                </p>

                <p>{{$review->user->name}}</p>
            </div>
        @empty
            <divclass="empty-list">No {{ request()->status }} reviews at this time</div>
        @endforelse
    </div>
@endsection
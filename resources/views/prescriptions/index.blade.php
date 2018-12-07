@extends('layouts.master')

@section('title')
    {{-- @if (Request::is('appointments/*')) --}}
    @if (Request::path() == 'prescriptions')
        User Prescriptions Index
    @else
        Doctor Prescriptions Index
    @endif
@endsection

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
  <h1 class="h2">Prescriptions Dashboard</h1>
</div>


<div class="table-responsive tp-scrollbar">
        
  @forelse($prescriptions as $prescription)
    
    @include('prescriptions._card')
  @empty
    <div class="empty-list">You have 0 prescriptions at the moment</div>
  @endforelse
</div>

@endsection
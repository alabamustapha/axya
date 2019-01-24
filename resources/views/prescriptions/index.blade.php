@extends('layouts.master')

@section('title')
    @if (Request::is('*/dr-prescriptions'))
        {{$doctor->name}} - Doctors Prescription Index
    @elseif (Request::is('*/prescriptions'))
        {{$user->name}} - Prescriptions Index
    @endif
@endsection

@section('page-title')
    @if (Request::is('*/dr-prescriptions'))
        Doctor Prescriptions - <strong>{{$doctor->name}}</strong>
    @elseif (Request::is('*/prescriptions'))
        Prescription Index - <strong>{{$user->name}}</strong>
    @endif
@endsection

@section('content')

<div class="table-responsive tp-scrollbar">
        
  @forelse($prescriptions as $prescription)
    
    @include('prescriptions._card')
  @empty
    <div class="empty-list">You have 0 prescriptions at the moment</div>
  @endforelse
    
  <div class="text-center py-3">{{ $prescriptions->appends(request()->query())->links() }}</div>
</div>

@endsection
@extends('layouts.master')

@section('title')
    {{-- @if (Request::is('appointments/*')) --}}
    @if (Request::path() == 'appointments')
        User Appointments Index
    @else
        Doctor Appointments Index
    @endif
@endsection

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Patient Appointments Dashboard</h1>
</div>


<div class="table-responsive tp-scrollbar">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Date</th>
            <th>Status</th>
            <th>Doctor</th>
            <th><i class="fa fa-stethoscope"></i>&nbsp; Specialty</th>
            <th>View Details</th>
        </tr>
        </thead>
        <tbody>
        
        @forelse($appointments as $appointment)
        <tr>
            <td>{{$appointment->day}} </td>
            <td>
                <a href="{{route('appointments.show', $appointment)}}" style="color:inherit;">
                    {{$appointment->statusText()}}
                </a>
            </td>
            <td>
                <a href="{{route('doctors.show', $appointment->doctor)}}" style="color:inherit;">{{$appointment->doctor->user->name}}</a>
            </td>
            <td>
                <a href="{{route('specialties.show', $appointment->doctor->specialty)}}" style="color:inherit;">{{$appointment->doctor->specialty->name}}</a>
            </td>
            <td>
                <a href="{{route('appointments.show', $appointment)}}" style="color:inherit;">                    
                    <span><i class="fa fa-file"></i>&nbsp; {{ $appointment->description_preview }}</span>
                </a>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="5" class="empty-list">No {{ request()->status }} appointments at this time</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
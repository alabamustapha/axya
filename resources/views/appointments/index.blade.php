@extends('layouts.master')

@section('title', 'User Appointments Index')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Patient Appointments Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group mr-2">
        <button class="btn btn-sm btn-outline-secondary">Share</button>
        <button class="btn btn-sm btn-outline-secondary">Export</button>
        </div>
        <button class="btn btn-sm btn-outline-secondary dropdown-toggle">
        <span data-feather="calendar"></span>
        This week
        </button>
    </div>
</div>

<h2>Section title</h2>
<div class="table-responsive">
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
        
        @foreach($appointments as $appointment)
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
                    <span><i class="fa fa-file"></i>&nbsp; {{substr($appointment->patient_info, 0, 100)}}...</span>
                </a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection
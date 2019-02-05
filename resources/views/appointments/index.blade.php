@extends('layouts.master')

@section('title')
    @if (Request::is('doctors/*/appointments'))
        {{$doctor->name}} - Doctors Appointment Index
    @else
        {{$user->name}} - Appointments Index
    @endif
@endsection

@section('page-title')
    @if (Request::is('doctors/*/appointments'))
        Doctor Appointments - <strong>{{$doctor->name}}</strong>
    @else
        Appointments - <strong>{{$user->name}}</strong>
    @endif
@endsection

@section('content')

<div class="table-responsive tp-scrollbar">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Date</th>
            <th>Schedule</th>
            <th>Status</th>
            <th>Name</th>
            <th><i class="fa fa-stethoscope"></i>&nbsp; Specialty</th>
            <th>View Details</th>
        </tr>
        </thead>
        <tbody>
        
        @forelse($appointments as $appointment)
            @if($appointment->creator || (Auth::user()->doctor == $appointment->doctor) || Auth::user()->isAdmin())
            <tr>
                <td>
                    <a href="{{route('appointments.show', $appointment)}}" style="color:inherit;"> 
                        {{$appointment->day}}
                    </a>
                </td>
                <td title="{{$appointment->duration}}">
                    <a href="{{route('appointments.show', $appointment)}}" style="color:inherit;"> 
                        {{$appointment->schedule}}
                    </a>
                </td>
                <td>
                    <a href="{{route('appointments.show', $appointment)}}">
                        {{$appointment->statusTextOutput()}}
                    </a>
                </td>
                <td>
                    @if($appointment->creator || (Auth::user()->isDoctor() && Auth::user()->doctor != $appointment->doctor) || Auth::user()->isAdmin())
                        <span title="Doctor name"><a href="{{route('doctors.show', $appointment->doctor)}}" style="color:inherit;">{{$appointment->doctor->name}}</a></span>
                    @else
                        <span title="Patient name"><a href="{{route('users.show', $appointment->user)}}" style="color:inherit;">{{$appointment->user->name}}</a></span>
                    @endif
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
            @endif
        @empty
            <tr>
                <td colspan="6" class="bg-white p-4 text-center">
                    <div class="display-3"><i class="fa fa-calendar-alt"></i></div> 

                    <br>

                    <p><strong>0</strong> {{ request()->status }} appointments at this time.</p>
                </td>
            </tr>
        @endforelse
            <tr>
                <td colspan="5" class="text-center py-3">{{ $appointments->appends(request()->query())->links() }}</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
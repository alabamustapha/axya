@extends('layouts.master')

@section('title', 'Appointment - '. $appointment->day)

@section('content')
<table>
  <tr>
    <td>{{$appointment->day}} </td>
    <td>{{$appointment->statusText()}} </td>
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
</table>
@endsection
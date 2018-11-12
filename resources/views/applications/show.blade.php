@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Doctor Application Status Dashboard</h1>
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

<div class="jumbotron">
    
        <div class="row">
            <div class="col-md-3">
                <img class="rounded-circle" src="{{ $application->user->avatar }}" style="width:200px;" width="25">
            </div>
            <div class="col-md-9">
                <h2>
                    <b>{{$application->user->name}}</b>
                    <br>
                    <small><i class="fa fa-user-md"></i> {{ $application->specialty->name }}</small>
                </h2>
                
                <hr>

                <div class="">
                    <table>
                        <tbody>
                            <tr>
                                <th colspan="2" class="text-bold h4">Work Experience</th>
                            </tr>

                            <tr>
                                <th>Date of First Appointment</th>
                                <td>&nbsp;&nbsp; <i class="fa fa-calendar"></i> {{ $application->first_appointment }}</td>
                            </tr>

                            <tr>
                                <th>Current Place of Work</th>
                                <td>
                                    &nbsp;&nbsp; <i class="fa fa-hospital"></i> {{ $application->workplace }}, {{ $application->workplace_address }} 
                                    <br>
                                    &nbsp;&nbsp; <i class="fa fa-calendar"></i> Since: <b>{{ $application->workplace_start }}</b>
                                </td>
                            </tr>
                        <tbody>
                    </table>

                    <div class="tf-flex">
                        <form action="{{route('doctors.store')}}" method="post" style="display:inline-block;">
                            @csrf
                            <input type="hidden" name="user_id" value="{{$application->user_id}}">
                            
                            <button class="btn btn-sm btn-info" onclick="return confirm('Accept this application?');">
                                <i class="fa fa-user-check"></i>&nbsp;
                                Accept
                            </button>
                        </form>

                        <span>/</span>

                        <form action="{{route('applications.destroy', $application)}}" method="post" style="display:inline-block;">
                            @csrf
                            {{method_field('DELETE')}}
                            <button class="btn btn-sm btn-danger" onclick="return confirm('You really want to DELETE this application?');">
                                <i class="fa fa-user-minus"></i> Reject/Del
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    

    {{-- <h3></h3> --}}
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">

        <thead>
            <tr>
                <th colspan="2" class="h3">CERTIFICATES</th>
            </tr>
        <thead>
        <tbody>
            <tr>
                <th>Specialist Diploma</th>
                <td>
                    <i class="fa fa-file-pdf red"></i>&nbsp; 
                    <a href="{{ route('showFile', ['application' => $application,'type' =>'specialist_diploma']) }}" target="_blank">{{ $application->specialist_diploma }}</a>
                </td>
            </tr>

            <tr>
                <th>Competences Certificate</th>
                <td>
                    <i class="fa fa-file-pdf red"></i>&nbsp; 
                    <a href="{{ route('showFile', ['application' => $application,'type' =>'competences']) }}" target="_blank">{{ $application->competences }}</a></td>
            </tr>

            <tr>
                <th>Malpraxis</th>
                <td>
                    <i class="fa fa-file-pdf red"></i>&nbsp; 
                    <a href="{{ route('showFile', ['application' => $application,'type' =>'malpraxis']) }}" target="_blank">{{ $application->malpraxis }}</a></td>
            </tr>

            <tr>
                <th>Medical College License</th>
                <td>
                    <i class="fa fa-file-pdf red"></i>&nbsp; 
                    <a href="{{ route('showFile', ['application' => $application,'type' =>'medical_college']) }}" target="_blank">{{ $application->medical_college }}</a> 
                    <br><br>
                    <i class="fa fa-calendar"></i> Expiry Date: <b>{{ $application->medical_college_expiry }}</b></td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
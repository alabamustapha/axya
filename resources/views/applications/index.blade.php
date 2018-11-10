@extends('layouts.master')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Doctor Applications Dashboard</h1>
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

<div style="border:5px solid gray;">
    
        // admin only,  <br>
        // Seperate <b>ongoing </b><br>
        // from New =<b>unattended,  </b><br>
        // from <b>Accepted => delete immediately when new doctor is populated or  </b><br>
        // <b>Rejected=>deleted after 1 week. </b><br>
</div>

<h2>Section title</h2>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>#</th>
            <th>Status</th>
            <th>Name</th>
            <th> View Applicant</th>
            <th>Action</th>
            <th>Specialty</th>
            <th>Doc</th>
        </tr>
        </thead>
        <tbody>
        
        @foreach($applications as $i => $application)
        <tr>
            <td>{{$i + 1}}</td>
            <td>{{$application->user->is_doctor}}</td>
            <td>
                <a href="{{route('applications.show', $application)}}">
                    {{$application->user->name}}
                </a>
            </td>
            <td>
                <a href="{{route('applications.show', $application)}}">
                    <i class="fa file"></i> View Applicant
                </a>
            </td>
            <td>
                <button class="btn btn-sm btn-info" onclick="return confirm('You really want to ACCEPT this application?');">Accept</button>
                <button class="btn btn-sm btn-danger" onclick="return confirm('You really want to DELETE this application?');">Reject/Del</button>
            </td>
            <td>{{$application->specialty->name}}</td>
            <td>
                <a href="{{asset($application->malpraxis)}}">
                    View Doc1
                </a>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
</div>

@endsection
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

<div class="jumbotron">
    {{$application->user->name}}'s application for Doctorship
    <br>
    <h2>Application Status</h2>
</div>

<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Title</th>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
            <tr><th>user->name</th><td>{{ $application->user->name }}</td></tr>
            <tr><th>specialty->name</th><td>{{ $application->specialty->name }}</td></tr>
            <tr><th>first_appointment</th><td>{{ $application->first_appointment }}</td></tr>
            <tr><th>workplace</th><td>{{ $application->workplace }}</td></tr>
            <tr><th>workplace_address</th><td>{{ $application->workplace_address }}</td></tr>
            <tr><th>workplace_start</th><td>{{ $application->workplace_start }}</td></tr>
            <tr><th>specialist_diploma</th><td>{{ $application->specialist_diploma }}</td></tr>
            <tr><th>competences</th><td>{{ $application->competences }}</td></tr>
            <tr><th>malpraxis</th><td>{{ $application->malpraxis }}</td></tr>
            <tr><th>medical_college</th><td>{{ $application->medical_college }}</td></tr>
            <tr><th>medical_college_expiry</th><td>{{ $application->medical_college_expiry }}</td></tr>
        </tbody>
    </table>
</div>

@endsection
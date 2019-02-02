@extends('layouts.master')

@section('title', 'Doctor Applications Index')

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

<h2>Section title</h2>
<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Name</th>
            <th> View Applicant</th>
            <th><i class="fa fa-stethoscope"></i>&nbsp; Specialty</th>
        </tr>
        </thead>
        <tbody>
        
        @forelse($applications as $application)
        <tr>
            <td>
                {{$application->user->name}}
            </td>
            <td>
                <a href="{{route('applications.show', $application)}}">
                    <i class="fa fa-file"></i>&nbsp;
                    View Application
                </a>
            </td>
            <td>
                {{$application->specialty->name}}
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="3" class="bg-white p-4 text-center">
                    <div class="display-3"><i class="fa fa-user-secret"></i></div> 

                    <br>

                    <p><strong>0</strong> {{ request()->status }} applications at this time.</p>
                </td>
            </tr>
        @endforelse
            <tr>
                <td colspan="3" class="text-center py-3">{{ $applications->appends(request()->query())->links() }}</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection
@extends('layouts.master')

@section('title', 'User Messages Index')

@section('content')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Messages Dashboard</h1>
</div>


<div class="table-responsive">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Date</th>
            <th>Status</th>
            <th>Type</th>
            <th>Body</th>
            <th>View Message</th>
        </tr>
        </thead>
        <tbody>
        
        @forelse($messages as $message)
        <tr>
            <td>{{$message->created_at}} </td>
            <td>
                {{--$message->statusText()--}}
            </td>
            <td>
                {{$message->messageable}}
            </td>
            <td>
                {{$message->body}}
            </td>
            <td>
                <a href="{{route('appointments.show', $message->messageable)}}#msgId_{{$message->id}}" style="color:inherit;">                    
                    <span><i class="fa fa-file"></i>&nbsp; View</span>
                </a>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="5" class="empty-list">No messages at this time</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
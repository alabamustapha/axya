@extends('layouts.master')

@section('title', 'User Messages Index')
@section('page-title')
    <i class="fa fa-comments"></i>&nbsp;  {{ __('Messages Dashboard') }}
@endsection

@section('content')

{{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
    <h1 class="h2">Messages Dashboard</h1>
</div> --}}


<div class="table-responsive tp-scrollbar">
    <table class="table table-striped table-sm">
        <thead>
        <tr>
            <th>Date</th>
            <th>Type</th>
            <th>Body</th>
        </tr>
        </thead>
        <tbody>
        
        @forelse($messages as $message)
        <tr>
            <td>{{$message->created_at}} </td>
            <td>
                {{$message->type()}}
            </td>
            <td>
                <a href="{{route('appointments.show', $message->messageable)}}#msgId_{{$message->id}}" style="color:inherit;">
                    {{$message->body}}
                </a>
            </td>
        </tr>
        @empty
            <tr>
                <td colspan="5" class="empty-list">
                    <div class="display-3"><i class="fa fa-paper-plane"></i></div> 

                    <br>

                    <p><strong>0</strong> messages at this time.</p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>

@endsection
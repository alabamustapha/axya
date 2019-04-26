@extends('layouts.admin')

@section('title', 'Subscriptions Management')
@section('page-title')
    <i class="fa fa-rss"></i>&nbsp;  {{ __('Subscriptions Management') }}
@endsection

@section('content')

    @include('admin.partials._subscriptions')

@endsection
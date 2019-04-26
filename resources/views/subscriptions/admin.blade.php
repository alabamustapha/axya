@extends('layouts.admin')

@section('title', 'Subscriptions Management/Dashboard')
@section('page-title')
    <i class="fa fa-rss"></i>&nbsp;  {{ __('Subscriptions Management') }}
@endsection

@section('content')

  <div class="container-fluid">

    @include('admin.partials._subscriptions')

  </div>

@endsection
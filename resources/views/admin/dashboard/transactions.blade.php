@extends('layouts.admin')

@section('title', 'Transactions Management')
@section('page-title')
    <i class="fa fa-handshake"></i>&nbsp;  {{ __('Transactions Management') }}
@endsection

@section('content')

    @include('admin.partials._transactions')

@endsection
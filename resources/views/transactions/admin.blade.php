@extends('layouts.master')

@section('title', 'Transactions Management/Dashboard')
@section('page-title')
    <i class="fa fa-handshake"></i>&nbsp;  {{ __('Transactions Management') }}
@endsection

@section('content')

<div class="container-fluid">

    @include('admin.partials._transactions')

</div>

@endsection
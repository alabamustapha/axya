@extends('layouts.master')

@section('title', Auth::user()->name .' Dashboard')

@section('content')

@section('page-title')
  <i class="fa fa-calendar-alt"></i> My Events 
@endsection

  <!-- // -->

@endsection

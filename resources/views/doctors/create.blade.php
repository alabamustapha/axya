@extends('layouts.master')

@section('title', 'Medical Doctors Account Verification')
@section('page-title')
    <i class="fa fa-user-md"></i>&nbsp; Doctors Verification
    <br>
    <small class="text-sm">
      <strong>Kindly supply all <span class="red">required</span> details and documents with this form.</strong>
    </small>
@endsection

@section('content')
 
    <div class="col-sm-8 offset-sm-2">      
        @include('doctors.forms.apply')
        {{-- <new-doctor :user="{{ Auth::user() }}" :specialties="{{ $specialties }}"></new-doctor> --}}
    </div>

@endsection
@extends('layouts.master')

@section('title', 'Medical Doctors Account Registration')
@section('page-title', 'Register As A Doctor')

@section('content')
 
    <div class="col-sm-8 offset-sm-2">      
        @include('doctors.forms.apply')        
    </div>

@endsection
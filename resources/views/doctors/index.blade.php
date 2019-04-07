@extends('layouts.master')

@section('title', 'Medical Doctors Index')
@section('page-title', 'Doctors Index')

@section('content')

  <!-- SEARCH LIST CONTAINER -->

  <div class="row">
    <div class="col-md-9">
      @forelse ($doctors as $doctor)

          @include('doctors.partials._profile')

      @empty
        <div class="bg-white p-4 text-center">
          <div class="display-3"><i class="fa fa-user-md"></i></div> 

          <br>

          <p><strong>0</strong> doctors at this time.</p>
        </div> 
      @endforelse

      <div>{{ $doctors->links() }}</div>
    </div>
    <div class="col-md-3"></div>
  </div>

  <!-- END -->

@endsection
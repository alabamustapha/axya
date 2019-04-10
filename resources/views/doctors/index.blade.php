@extends('layouts.master')

@section('title', 'Medical Doctors Index')
@section('page-title', 'Doctors Index')

@section('content')

  <!-- SEARCH LIST CONTAINER -->

  <div class="row">
    <div class="col-md-9 order-sm-1 order-2">
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

    <div class="col-md-3 order-sm-2 order-1 mb-3">
        @auth

          <ul class="nav w-100 d-block">
            <li class="nav-item list-group">
              <span class="list-group-item">
                <input type="text" class="list-group-item form-control" placeholder="search...">
              </span>

              <a class="nav-link list-group-item" href="{{ route('user.doctors', Auth::user()) }}">
                  <span class="icon">
                    <i class="fas fa-user-md fa-fw"></i>
                  </span>
                  <span class="navlink-active">My Doctors</span>
              </a>

              <a class="nav-link list-group-item" href="{{ route('reviews.index') }}">
                  <span class="icon">
                    <i class="fas fa-user-check fa-fw"></i>
                  </span>
                  <span class="navlink-active">Reviews</span>
              </a>
            </li>
          </ul>

        @endauth
    </div>
  </div>

  <!-- END -->

@endsection

  <ol class="breadcrumb py-1" style="border-radius: 0;">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    @if (Request::path() == 'specialties')
      <li class="breadcrumb-item active" aria-current="page"><b>Specialties</b></li>
    @else
      <li class="breadcrumb-item"><a href="{{ route('specialties.index') }}">Specialties</a></li>
    @endif

    @if (Request::is('specialties/*'))
      <li class="breadcrumb-item active" aria-current="page"><b>{{ $specialty->name }}</b></li>
    @endif

    @if (Request::is('tags/*'))
      <li class="breadcrumb-item"><a href="{{ route('specialties.show', $tag->specialty) }}">{{ $tag->specialty->name }}</a></li>
      <li class="breadcrumb-item active" aria-current="page"><b>{{ $tag->name }}</b></li>
    @endif

    @if (Request::path() == 'tags')
      <li class="breadcrumb-item active" aria-current="page"><b>Tags</b></li>
    @else
      <li class="breadcrumb-item"><a href="{{ route('tags.index') }}">Tags</a></li>
    @endif
    
    @auth
      <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Appointments</a></li>
    @endauth
  </ol>

<a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
    <span>Resources</span>
    <span class="caret"></span>
</a>

<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
    @if (Request::path() == 'specialties')
      <a href="#" class="dropdown-item"><b>Specialties</b></a>
    @else
      <a href="{{ route('specialties.index') }}" class="dropdown-item">Specialties</a>
    @endif

    @if (Request::is('specialties/*'))
      <a href="#" class="dropdown-item"><b>{{ $specialty->name }}</b></a>
    @endif

    @if (Request::is('tags/*'))
      <a href="{{ route('specialties.show', $tag->specialty) }}" class="dropdown-item">{{ $tag->specialty->name }}</a>
      <a href="#" class="dropdown-item"><b>{{ $tag->name }}</b></a>
    @endif

    @if (Request::path() == 'tags')
      <a href="#" class="dropdown-item"><b>Tags</b></a>
    @else
      <a class="dropdown-item" href="{{ route('tags.index') }}">Tags</a>
    @endif
    
    @auth
      <a class="dropdown-item" href="{{ route('appointments.index') }}">Appointments</a>
    @endauth
</div>

<a id="navbarDropdown" class="nav-link mr-0 px-3 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
    <span>Resources</span>
    <span class="caret"></span>
</a>

<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
    <a href="{{ route('doctors.index') }}" class="dropdown-item text-secondary">Doctors</a>
    <a href="{{ route('subscription_plans.index') }}" class="dropdown-item text-secondary">Subscription Plans</a>
    
    @if (Request::path() == 'specialties')
      <a href="#" class="dropdown-item text-secondary"><b>Specialties</b></a>
    @else
      <a href="{{ route('specialties.index') }}" class="dropdown-item text-secondary">Specialties</a>
    @endif

    @if (Request::is('specialties/*'))
      <a href="#" class="dropdown-item text-secondary"><b>{{ $specialty->name }}</b></a>
    @endif

    @if (Request::is('tags/*'))
      <a href="{{ route('specialties.show', $tag->specialty) }}" class="dropdown-item text-secondary">{{ $tag->specialty->name }}</a>
      <a href="#" class="dropdown-item text-secondary"><b>{{ $tag->name }}</b></a>
    @endif

    @if (Request::path() == 'tags')
      <a href="#" class="dropdown-item text-secondary"><b>Tags</b></a>
    @else
      <a class="dropdown-item text-secondary" href="{{ route('tags.index') }}">Keywords</a>
    @endif
</div>
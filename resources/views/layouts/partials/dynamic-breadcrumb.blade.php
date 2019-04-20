
<a id="navbarDropdown" class="nav-link mr-0 px-3 dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre title="Some site resources">
    <span>Resources</span>
    <span class="caret"></span>
</a>

<div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
    <a href="{{ route('doctors.index') }}" class="dropdown-item {{Request::path() == 'doctors' ? 'active':''}}">Doctors</a>
    <a href="{{ route('subscription_plans.index') }}" class="dropdown-item {{Request::path() == 'subscription_plans' ? 'active':''}}">Subscription Plans</a>
    
    @if (Request::path() == 'specialties')
      <a href="#" class="dropdown-item active"><b>Specialties</b></a>
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
      <a href="#" class="dropdown-item active"><b>Tags</b></a>
    @else
      <a class="dropdown-item" href="{{ route('tags.index') }}">Keywords</a>
    @endif
</div>
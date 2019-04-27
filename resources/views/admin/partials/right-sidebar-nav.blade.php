<div>
  @if (Auth::user()->isSuperAdmin())
  <!-- Info Boxes Style 2 -->
  <a href="{{ route('app-settings') }}" class="info-box mb-3 bg-danger">
    <span class="info-box-icon"><i class="fa fa-cogs"></i></span>

    <div class="info-box-content d-flex flex-column justify-content-center align-content-center">
      <span>App Settings</span>
    </div>
  </a>

  <a href="{{ route('dashboard-notifications') }}" class="info-box mb-3 bg-info" title="Send notifications">
    <span class="info-box-icon"><i class="fa fa-bullhorn"></i></span>

    <div class="info-box-content d-flex flex-column justify-content-center align-content-center">
      <span class="info-box-text">Send Notifications</span>
    </div>
  </a>

  <a href="{{--route('dashboard-admins')--}}" class="info-box mb-3 bg-info">
    {{-- Link to FAQs, Privacy, TOS, Tags, Specialties etc updates --}}
    <span class="info-box-icon"><i class="fa fa-rss-square"></i></span>

    <div class="info-box-content d-flex flex-column justify-content-center align-content-center">
      <span class="info-box-text">App Contents</span>
    </div>
  </a>

  <a href="{{route('dashboard-admins')}}" class="info-box mb-3 bg-warning">
    <span class="info-box-icon"><i class="fa fa-user-tie"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Admins</span>
      <span class="info-box-number">{{-- $admins_count --}}</span>
    </div>
  </a>
  @endif

  <a href="{{route('applications.index')}}" class="info-box mb-3 bg-primary">
    <span class="info-box-icon"><i class="fa fa-user-secret"></i></span>

    <div class="info-box-content">
      <span class="info-box-text">Applications</span>
      {{-- <span class="info-box-number">{{ $admins_count }}</span> --}}
      <span class="badge badge-danger">1333{{--$applications_count--}}</span>
    </div>
  </a>
{{--  
  <form action="{{ route('manual.populate') }}" method="post">
    @csrf
    <input type="hidden" name="case" value="current">
    <button class="list-group-item list-group-item-action tf-flex nav-link bg-warning" title="Autopopulate contents">
      <span class="icon">
        <i class="fa fa-bug"></i>
      </span>
      <span>Auto Populate CTRL</span>
    </button>
  </form>
 --}}
</div>






<div class="list-group">

  <a class="list-group-item list-group-item-action tf-flex" href="{{--route('adm_appointments')--}}" class="nav-link" title="Appointment Management">
    <span class="icon">
      <i class="fas fa-fw fa-2x fa-calendar-alt"></i>
    </span>
    <span>&nbsp;Appointments</span>
  </a>
</div>
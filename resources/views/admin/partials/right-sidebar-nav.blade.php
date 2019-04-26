<div class="list-group">

  <a class="list-group-item list-group-item-action tf-flex bg-info" href="#" class="nav-link" title="Send notifications">
    <span class="icon">
      <i class="fas fa-fw fa-2x fa-bullhorn"></i>
    </span>
    <span>&nbsp;Send Notifications</span>
  </a>

  <a class="list-group-item list-group-item-action tf-flex" href="{{--route('adm_appointments')--}}" class="nav-link" title="Appointment Management">
    <span class="icon">
      <i class="fas fa-fw fa-2x fa-calendar-alt"></i>
    </span>
    <span>&nbsp;Appointments</span>
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
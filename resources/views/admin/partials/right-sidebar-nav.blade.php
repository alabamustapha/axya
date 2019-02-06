<div class="list-group">
  <a class="list-group-item list-group-item-action tf-flex" href="{{route('dashboard-users')}}" class="nav-link" title="User/Patient Management">
    <span class="icon">
      <i class="fa fa-users"></i>
    </span>
    <span>Users</span>
  </a>
  
  <a class="list-group-item list-group-item-action tf-flex" href="{{route('dashboard-doctors')}}" class="nav-link" title="Doctor Management">
    <span class="icon">
      <i class="fa fa-user-md"></i>
    </span>
    <span>Doctors</span>
  </a>

  <a class="list-group-item list-group-item-action tf-flex" href="{{--route('adm_appointments')--}}" class="nav-link" title="Appointment Management">
    <span class="icon">
      <i class="fa fa-calendar-alt"></i>
    </span>
    <span>Appointments</span>
  </a>

  <a class="list-group-item list-group-item-action tf-flex" href="{{route('adm_subscriptions')}}{{--route('dashboard-subscriptions')--}}" class="nav-link" title="Subscription Management">
    <span class="icon">
      <i class="fa fa-rss"></i>
    </span>
    <span>Subscriptions</span>
  </a>

  <a class="list-group-item list-group-item-action tf-flex" href="{{route('adm_transactions')}}{{--route('dashboard-transactions')--}}" class="nav-link" title="Payment/Transaction Management">
    <span class="icon">
      <i class="fa fa-handshake"></i>
    </span>
    <span>Transactions</span>
  </a>

  {{-- <a class="list-group-item list-group-item-action"></a> --}}
</div>
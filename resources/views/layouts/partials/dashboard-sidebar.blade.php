<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-user brown"></i>
        <p>
          Account
          <i class="right fa fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <a class="nav-link" href="http://medapp.demo/user-dashboard">
            {{-- <router-link to="/profile" class="nav-link"> --}}
              <i class="nav-icon fa fa-user-cog brown"></i>
              <p>
                Profile
              </p>
            {{-- </router-link> --}}
          </a>
        </li>

        <li class="nav-item">
          <router-link to="/dashboard" class="nav-link">
            <i class="nav-icon fa fa-tachometer-alt brown"></i>
            <p>
              Dashboard
            </p>
          </router-link>
        </li>
      </ul>
    </li>

    {{-- @can('isSuperAdmin') --}}
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-th green"></i>
          <p>
            App
            <i class="right fa fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <router-link to="/app-settings" class="nav-link">
              <i class="nav-icon fa fa-cog green"></i>
              <p>
                Settings
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/app-dashboard" class="nav-link">
              <i class="nav-icon fa fa-chart-line green"></i>
              <p>
                Dashboard
              </p>
            </router-link>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-cogs indigo"></i>
          <p>
            Management
            <i class="right fa fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <router-link to="/doctors" class="nav-link">
              <i class="fa fa-user-md nav-icon indigo"></i>
              <p>Doctors</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/users" class="nav-link">
              <i class="fa fa-users nav-icon indigo"></i>
              <p>Users</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/transactions" class="nav-link">
              <i class="nav-icon fa fa-handshake indigo"></i>
              <p>
                Transactions
              </p>
            </router-link>
          </li>
        </ul>
      </li>
    {{-- @endcan --}}

    {{-- @can('isDoctor') --}}
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-prescription orange"></i>
        <p>
          Doctor Section
          <i class="right fa fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <router-link to="/upcoming-appointments" class="nav-link">
            <i class="fa fa-calendar-check nav-icon orange"></i>
            <p>Upcoming</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/pending-appointments" class="nav-link">
            <i class="fa fa-calendar-plus nav-icon orange"></i>
            <p>Pending</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/past-patients" class="nav-link">
            <i class="fa fa-procedures nav-icon orange"></i>
            <p>Patients</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/activity-histories" class="nav-link">
            <i class="fa fa-calendar-alt nav-icon orange"></i>
            <p>Consultation History</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/transaction-histories" class="nav-link">
            <i class="fa fa-handshake nav-icon orange"></i>
            <p>Transaction History</p>
          </router-link>
        </li>
      </ul>
    </li>
    {{-- @endcan --}}

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-hospital teal"></i>
        <p>
          Appointments
          <i class="right fa fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <router-link to="/patient-up-appointments" class="nav-link">
            <i class="fa fa-calendar-check nav-icon teal"></i>
            <p>Upcoming</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/patient-pe-appointments" class="nav-link">
            <i class="fa fa-calendar-plus nav-icon teal"></i>
            <p>Pending</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/my-doctors" class="nav-link">
            <i class="fa fa-user-md nav-icon teal"></i>
            <p>My Doctors</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/activity-histories" class="nav-link">
            <i class="fa fa-calendar-alt nav-icon teal"></i>
            <p>Visit History</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/pa-transaction-histories" class="nav-link">
            <i class="fa fa-handshake nav-icon teal"></i>
            <p>Transaction History</p>
          </router-link>
        </li>
      </ul>
    </li>

    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon fa fa-folder-open gray"></i>
        <p>
          Messages
          <i class="right fa fa-angle-left"></i>
        </p>
      </a>
      <ul class="nav nav-treeview">
        <li class="nav-item">
          <router-link to="/patient-up-appointments" class="nav-link">
            <i class="fa fa-envelope-open nav-icon gray"></i>
            <p>Inbox</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/patient-pe-appointments" class="nav-link">
            <i class="fa fa-envelope nav-icon gray"></i>
            <p>Unread</p>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/patient-pe-appointments" class="nav-link">
            <i class="fa fa-star nav-icon gray"></i>
            <p>Starred</p>
          </router-link>
        </li>
      </ul>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{ route('logout') }}"
      onclick="event.preventDefault();
      document.getElementById('logout-form').submit();">
          <i class="nav-icon fa fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
      </a>

      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
      </form>
    </li>
  </ul>
</nav>
<nav class="mt-2">
  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

    @auth

      @can('isAdmin')
      {{-- @can('isSuperAdmin') --}}
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fa fa-th green"></i>
            <p>
              Admin Section
              @if ($applications_count)
              <span class="badge badge-danger">
                {{$applications_count}}
              </span>
              @endif
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <router-link to="/app-settings" class="nav-link">
                <i class="nav-icon fa fa-cog gray"></i>
                <p>
                  App Settings
                </p>
              </router-link>
            </li>

            <li class="nav-item">
              <a href="{{route('admin_dashboard')}}" class="nav-link">
                <i class="nav-icon fa fa-th-list green"></i>
                <p>
                  Dashboard
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="{{route('dashboard-main')}}" class="nav-link">
                  {{-- <router-link to="/dashboard-main" class="nav-link"> --}}
                    <i class="nav-icon fa fa-chart-line green"></i>
                    <p>
                      Main
                    </p>
                  {{-- </router-link> --}}
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('dashboard-doctors')}}" class="nav-link">
                  {{-- <router-link to="/dashboard-doctors" class="nav-link"> --}}
                    <i class="nav-icon fa fa-user-md green"></i>
                    <p>
                      Doctors
                    </p>
                  {{-- </router-link> --}}
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('dashboard-users')}}" class="nav-link">
                  {{-- <router-link to="/dashboard-users class="nav-link"> --}}
                    <i class="nav-icon fa fa-users green"></i>
                    <p>
                      Users
                    </p>
                  {{-- </router-link> --}}
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('dashboard-admins')}}" class="nav-link">
                  {{-- <router-link to="/dashboard-admins class="nav-link"> --}}
                    <i class="nav-icon fa fa-user-tie green"></i>
                    <p>
                      Staffs & Admins
                    </p>
                  {{-- </router-link> --}}
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('dashboard-transactions')}}" class="nav-link">
                  {{-- <router-link to="/dashboard-transactions" class="nav-link"> --}}
                    <i class="nav-icon fa fa-handshake green"></i>
                    <p>
                      Transactions
                    </p>
                  {{-- </router-link> --}}
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-cogs indigo"></i>
                <p>
                  Management
                  @if ($applications_count)
                  <span class="badge badge-danger">
                    {{$applications_count}}
                  </span>
                  @endif
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('applications.index')}}" class="nav-link">
                  {{-- <router-link to="/doctors" class="nav-link"> --}}
                    <i class="fa fa-user-md nav-icon indigo"></i>
                    <p class="tf-flex">
                      Doctors
                      @if ($applications_count)
                      <span class="badge badge-danger right">
                        {{$applications_count}}
                      </span>
                      @endif
                    </p>
                  {{-- </router-link> --}}
                  </a>
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
            <li class="nav-item has-treeview">
              <a href="#" class="nav-link">
                <i class="nav-icon fa fa-folder-open teal"></i>
                <p>
                  Contents
                  <i class="right fa fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="{{route('specialties.index')}}" class="nav-link">
                  {{-- <router-link to="/specialties" class="nav-link"> --}}
                    <i class="fa fa-hat-wizard nav-icon teal"></i>
                    <p>Specialties</p>
                  {{-- </router-link> --}}
                  </a>
                </li>
                <li class="nav-item">
                  <a href="{{route('tags.index')}}" class="nav-link">
                  {{-- <router-link to="/tags" class="nav-link"> --}}
                    <i class="nav-icon fa fa-tags teal"></i>
                    <p>
                      Tags
                    </p>
                  {{-- </router-link> --}}
                  </a>
                </li>
                <li class="nav-item">
                  <a href="#{{--route('faqs.index')--}}" class="nav-link">
                  {{-- <router-link to="/faqs" class="nav-link"> --}}
                    <i class="nav-icon fa fa-question-circle teal"></i>
                    <p>
                      FAQs
                    </p>
                  {{-- </router-link> --}}
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </li>
      @endcan

      @can('isDoctor')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link" title="{{ Auth::user()->is_doctor ? 'Doctor':'Nurse'}} or Admin">
          <i class="nav-icon fa fa-prescription orange"></i>
          <p>
            Official Section
            <i class="right fa fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{auth()->user()->isDoctor() ? route('doctors.show', auth()->user()) : '#'}}" class="nav-link">
            {{-- <router-link to="/doctors/:slug" class="nav-link"> --}}
              <i class="fa fa-user-md nav-icon orange"></i>
              <p>Professional Details</p>
            {{-- </router-link> --}}
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
            {{-- <router-link to="/past-patients" class="nav-link"> --}}
              <i class="fa fa-procedures nav-icon orange"></i>
              <p>My Patients</p>
            {{-- </router-link> --}}
            </a>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-tasks orange"></i>
              <p>
                My Appointments
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{route('dr_appointments', ['status'=> 'awaiting-appointment-time'])}}" class="nav-link">
                {{-- <router-link to="/upcoming-appointments" class="nav-link"> --}}
                  <i class="fa fa-calendar-check nav-icon teal"></i>
                  <p class="tf-flex" title="Upcoming Appointments">
                  <span>Upcoming</span>
                  <span class="badge badge-danger right">5</span>
                </p>
                {{-- </router-link> --}}
                </a>
              </li>
              <li class="nav-item">
                <a href="{{route('dr_appointments', ['status'=> 'awaiting-confirmation'])}}" class="nav-link">
                {{-- <router-link to="/pending-appointments" class="nav-link"> --}}
                  <i class="fa fa-calendar-plus nav-icon teal"></i>
                  <p class="tf-flex" title="Pending Appointments">
                    <span>Pending</span>
                    <span class="badge badge-danger right">5</span>
                  </p>
                {{-- </router-link> --}}
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-history orange"></i>
              <p>
                My History
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <router-link to="/activity-histories" class="nav-link">
                  <i class="fa fa-calendar-alt nav-icon teal"></i>
                  <p>Consultation</p>
                </router-link>
              </li>
              <li class="nav-item">
                <router-link to="/transaction-histories" class="nav-link">
                  <i class="fa fa-handshake nav-icon teal"></i>
                  <p>Transaction</p>
                </router-link>
              </li>
            </ul>
          </li>
        </ul>
      </li>

      <li><hr></li>
      @endcan

      <li class="nav-item">
        <a class="nav-link" href="{{route('users.show', Auth::user())}}">
          {{-- <router-link to="/profile" class="nav-link"> --}}
          <i class="nav-icon fa fa-user-cog indigo"></i>
          <p>
            My Account
          </p>
          {{-- </router-link> --}}
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#">
        {{-- <router-link to="/my-doctors" class="nav-link"> --}}
          <i class="fa fa-user-md nav-icon yellow"></i>
          <p>My Doctors</p>
        {{-- </router-link> --}}
        </a>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-tachometer-alt teal"></i>
          <p>
            My Dashboard
            <i class="right fa fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a class="nav-link" href="{{route('user_dashboard')}}">
              {{-- <router-link to="/user-dashboard " class="nav-link"> --}}
                <i class="fa fa-eye nav-icon teal"></i>
                <p>View All </p>
              {{-- </router-link> --}}
            </a>
          </li>
          <li class="nav-item">
            <router-link to="/medical-tests " class="nav-link">
              <i class="fa fa-stethoscope nav-icon teal"></i>
              <p>Medical tests </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/treatments " class="nav-link">
              <i class="fa fa-medkit nav-icon teal"></i>
              <p>Treatments </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/prescriptions" class="nav-link">
              <i class="fa fa-prescription nav-icon teal"></i>
              <p>Prescriptions</p>
            </router-link>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-tasks cyan"></i>
          <p>
            Appointments
            <i class="right fa fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{route('appointments.index')}}" class="nav-link">
            {{-- <router-link to="/patient-up-appointments" class="nav-link"> --}}
              <i class="fa fa-calendar nav-icon cyan"></i>
              <p title="Upcoming Appointments">
                All
                <span class="badge badge-danger right">{{--5--}}</span>
              </p>
            {{-- </router-link> --}}
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('appointments.index', ['status'=> 'success'])}}" class="nav-link">
            {{-- <router-link to="/patient-up-appointments" class="nav-link"> --}}
              <i class="fa fa-calendar-check nav-icon cyan"></i>
              <p title="Upcoming Appointments">
                Completed
                <span class="badge badge-danger right">{{--5--}}</span>
              </p>
            {{-- </router-link> --}}
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('appointments.index', ['status'=> 'confirmed'])}}" class="nav-link">
            {{-- <router-link to="/patient-up-appointments" class="nav-link"> --}}
              <i class="fa fa-calendar-plus nav-icon cyan"></i>
              <p title="Upcoming Appointments">
                Upcoming
                <span class="badge badge-danger right">{{--5--}}</span>
              </p>
            {{-- </router-link> --}}
            </a>
          </li>
          <li class="nav-item">
            <a href="{{route('appointments.index', ['status'=> 'uncompleted'])}}" class="nav-link">
            {{-- <router-link to="/patient-pe-appointments" class="nav-link"> --}}
              <i class="fa fa-calendar-minus nav-icon cyan"></i>
              <p title=">Pending Appointments">
                Pending
                <span class="badge badge-danger right">{{--5--}}</span>
              </p>
            {{-- </router-link> --}}
            </a>
          </li>
        </ul>
      </li>

      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fa fa-history blue"></i>
          <p>
            My History
            <i class="right fa fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <router-link to="/visits-history" class="nav-link">
              <i class="fa fa-calendar-alt nav-icon blue"></i>
              <p>Visits</p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/transactions-history" class="nav-link">
              <i class="fa fa-handshake nav-icon blue"></i>
              <p>Transactions</p>
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
            <a href="{{route('messages.index')}}" class="nav-link">
            {{-- <router-link to="/patient-up-appointments" class="nav-link"> --}}
              <i class="fa fa-envelope-open nav-icon gray"></i>
              <p>Inbox</p>
            {{-- </router-link> --}}
            </a>
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
            <i class="nav-icon fa fa-sign-out-alt red"></i>
            <p>
              {{ __('Logout') }}
            </p>
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </li>
    @else

      <li class="nav-item">
        <a class="nav-link" href="{{ route('login') }}">
            <i class="nav-icon fa fa-sign-in-alt green"></i>
            <p>
              {{ __('Login') }}
            </p>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{ route('register') }}">
            <i class="nav-icon fa fa-user-plus green"></i>
            <p>
              {{ __('Register') }}
            </p>
        </a>
      </li>
    @endauth
  </ul>
</nav>
<div class="sidebar-header ">
    <div class="avatar">
        <img src="{{Auth::user()->avatar}}" height="50" class="rounded-circle" alt="user avatar"> 
        <span class="online-status online mx-1"></span>{{Auth::user()->name}}
    </div>
    <div class="avatar-mini">
        <img src="{{Auth::user()->avatar}}" height="50" class="rounded-circle" alt="user avatar">
        <span class="online-status online"></span>
    </div>
</div>

<ul class="nav flex-sm-column">

    @if (Auth::user()->is_authenticated_admin)
      <li class="nav-item bg-dark">

        <a class="nav-link" href="{{route('dashboard-main')}}">
          <span>
            <i class="icon fa fa-th-list fa-fw"></i>
            <span class="navlink-active">&nbsp; Admin Portal</span>
            <span class="sub-online-status sub-online ml-1" title="online"></span>
          </span>          
        </a>
      </li>
    @elseif (Auth::user()->is_administrator)
      <li class="nav-item bg-dark">

        @if (is_null(Auth::user()->admin_password))
          <a href="{{route('admin.password')}}" class="nav-link">
            <span class="icon fa fa-key"></span>
            <span class="navlink-active">&nbsp; Create Admin Password</span>
          </a>
        @else
          <a href="{{route('admin.login')}}" 
            class="nav-link"
            data-toggle="modal" data-target="#admin-sign-in-modal"
            >
            <span class="icon fa fa-sign-in-alt"></span>
            <span class="navlink-active">&nbsp; Admin Login</span>
          </a>
        @endif
      </li>
    @endif

    @if (Auth::user()->isVerified() && !Auth::user()->is_doctor  && Auth::user()->allows_doctor_verify)
      <li class="nav-item bg-warning">

        <a href="{{route('doctors.create')}}" class="nav-link">
          <i class="icon fa fa-user-md fa-fw"></i>
          <span class="navlink-active">Verify As Doctor</span>
        </a>

      </li>
    @endif

    @if (Auth::user()->is_authenticated_doctor)
      <li class="nav-item">

        <a class="nav-link" data-toggle="collapse" href="#doctorSubmenu" role="button" aria-expanded="false" aria-controls="doctorSubmenu">
          
            <span>
              <i class="icon fa fa-user-md fa-fw"></i>
              <span class="navlink-active">Doctor</span>
              <span class="sub-online-status sub-online ml-1" title="online"></span>
            </span>
            <small class="text-sm float-right"><i class="fa fa-plus fa-fw"></i></small>
          
        </a>
        <ul id="doctorSubmenu" class=" collapse sub-menu nav flex-sm-column">
          <li class="nav-item">
            <a href="{{route('doctors.show', Auth::user())}}" class="nav-link">
              <span class="icon">
                <i class="fa fa-user-tie fa-fw"></i>
              </span>
              <span class="navlink-active">Profile</span>
            </a>

            <a href="{{Auth::user()->doctor->appointments_list}}" class="nav-link tf-flex">
              
                <span>
                  <span class="icon">
                    <i class="fa fa-stopwatch fa-fw"></i>
                  </span>
                  <span class="navlink-active">Appointments</span>
                </span>
                @if (Auth::user()->doctor->pending_appointments_count)
                  <span class="badge badge-danger float-right">{{Auth::user()->doctor->pending_appointments_count}}</span>
                @endif
              
            </a>

            <a href="{{Auth::user()->doctor->transactions_list}}" class="nav-link">
              <span class="icon">
                <svg width="24" height="24" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.58 1.43719L3.843 0.0114537C3.55797 -0.0488492 3.27545 0.135043 3.21515 0.420075L3.08716 1.2426L10.8605 2.88757L10.9885 2.06504C11.0488 1.78011 10.865 1.49751 10.58 1.43719Z"
                        fill="white" />
                    <path
                        d="M7.74697 3.06258C7.66828 2.7792 7.37214 2.6117 7.08885 2.69026L5.80993 3.0453L2.79493 2.40723L2.46334 3.97393L0.391586 4.54896C0.108316 4.62754 -0.0591843 4.92368 0.0193802 5.20697L1.18694 9.41429C1.26563 9.69756 1.56178 9.86517 1.84506 9.7865L8.54232 7.92793C8.82559 7.84924 8.99309 7.55321 8.91453 7.26981L8.71412 6.54754L9.46523 6.70634C9.75027 6.76675 10.0328 6.58286 10.0931 6.29783L10.5683 4.05221L7.86274 3.47968L7.74697 3.06258ZM8.52041 5.20091L8.68604 4.41811C8.71092 4.3009 8.82714 4.2253 8.94433 4.25005L9.72713 4.41579C9.84445 4.44066 9.92005 4.55676 9.8953 4.67407L9.72967 5.45688C9.70479 5.57409 9.58859 5.64979 9.47138 5.62494L8.68857 5.4593C8.57115 5.43434 8.49553 5.31812 8.52041 5.20091ZM0.50813 4.96881L2.36152 4.45465L6.73458 3.2411L7.20516 3.11035C7.21375 3.10803 7.22233 3.10694 7.2307 3.10694C7.26845 3.10694 7.31358 3.13171 7.32677 3.17914L7.38203 3.37811L7.55513 4.00188L0.667703 5.91317L0.439343 5.09053C0.425036 5.03891 0.456526 4.98312 0.50813 4.96881ZM8.49455 7.38623C8.50335 7.41815 8.49411 7.44455 8.48475 7.46107C8.47551 7.47757 8.45768 7.49916 8.42576 7.50795L1.72862 9.36651C1.72015 9.36883 1.71145 9.37004 1.70308 9.37004C1.66533 9.37004 1.6202 9.34516 1.60701 9.29773L0.926008 6.84366L7.81344 4.93227L8.23351 6.44583L8.49455 7.38623Z"
                        fill="white" />
                    <path
                        d="M2.81063 7.55419C2.77849 7.43864 2.65787 7.37041 2.54231 7.40244L1.76018 7.61956C1.64473 7.65159 1.57639 7.77232 1.60853 7.88788L1.82555 8.66991C1.85768 8.78547 1.97831 8.8537 2.09386 8.82156L2.876 8.60454C2.99156 8.57251 3.05979 8.45178 3.02776 8.33623L2.81063 7.55419Z"
                        fill="white" />
                </svg>
              </span>
              <span class="navlink-active">Transactions</span>
            </a>
            
            {{-- <a href="{{Auth::user()->doctor->subscriptions_list}}" class="nav-link">
              <span class="icon">
                <i class="fa fa-money-bill-alt fa-fw"></i>
              </span>
              <span class="navlink-active">Subscriptions</span>
            </a> --}}
                
            <a class="nav-link" href="{{ route('dr_patients', Auth::user()->doctor) }}">
                <span class="icon">
                    <svg width="26" height="26" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M7.12903 4.19355V3.35484H7.54839C7.77967 3.35484 7.96774 3.16676 7.96774 2.93548V2.72581H9.1136L9.70075 3.60629L10.5 1.40816L10.9747 2.51613H13V2.09677H11.2511L10.4679 0.269264L9.58977 2.68403L9.33802 2.30645H7.96774V0.419355C7.96774 0.188075 7.77967 0 7.54839 0H5.45161C5.22033 0 5.03226 0.188075 5.03226 0.419355V1.46774H3.21662L2.74178 2.57572L1.94269 0.377583L1.35553 1.25806H0V1.67742H1.57995L1.8315 1.29984L2.70963 3.71461L3.49305 1.8871H5.03226V2.93548C5.03226 3.16676 5.22033 3.35484 5.45161 3.35484H5.87097V4.19355H6.29032V5.45161H5.24194C4.88565 5.45161 4.52905 5.53567 4.21054 5.69508L4.06506 5.76777C3.93104 5.34319 3.5381 5.03226 3.06971 5.03226H2.30645C2.06954 5.03226 1.85311 5.11427 1.67742 5.24736V4.40323C1.67742 4.05646 1.39515 3.77419 1.04839 3.77419C0.701621 3.77419 0.419355 4.05646 0.419355 4.40323V7.54839C0.188075 7.54839 0 7.73646 0 7.96774V8.3871C0 8.61838 0.188075 8.80645 0.419355 8.80645H1.04839V11.1153C0.785676 11.313 0.629032 11.6207 0.629032 11.9516C0.629032 12.5297 1.09937 13 1.67742 13C2.25547 13 2.72581 12.5297 2.72581 11.9516C2.72581 11.6209 2.56752 11.3106 2.30645 11.1139V8.80645H10.6935V11.1139C10.4325 11.3104 10.2742 11.6209 10.2742 11.9516C10.2742 12.5297 10.7445 13 11.3226 13C11.9006 13 12.371 12.5297 12.371 11.9516C12.371 11.6209 12.2127 11.3106 11.9516 11.1139V8.80645H12.5806C12.8119 8.80645 13 8.61838 13 8.3871V7.96774C13 7.73646 12.8119 7.54839 12.5806 7.54839H12.57C12.4636 6.37458 11.4752 5.45161 10.2742 5.45161H6.70968V4.19355H7.12903ZM2.30645 5.45161H3.06971C3.41647 5.45161 3.69874 5.73388 3.69874 6.08065C3.69874 6.42741 3.41647 6.70968 3.06971 6.70968H2.30645C1.95969 6.70968 1.67742 6.42741 1.67742 6.08065C1.67742 5.73388 1.95969 5.45161 2.30645 5.45161ZM3.14516 7.12903C3.41811 7.12903 3.64878 7.30492 3.7356 7.54839H1.71602C1.80284 7.30492 2.0335 7.12903 2.30645 7.12903H3.14516ZM1.67742 6.91393C1.67977 6.91577 1.68162 6.91772 1.68387 6.91935C1.68162 6.92099 1.67977 6.92294 1.67742 6.92478V6.91393ZM0.83871 4.40323C0.83871 4.28774 0.932696 4.19355 1.04839 4.19355C1.16408 4.19355 1.25806 4.28774 1.25806 4.40323V7.54839H0.83871V4.40323ZM1.67742 12.5806C1.33065 12.5806 1.04839 12.2984 1.04839 11.9516C1.04839 11.8794 1.06477 11.8109 1.08801 11.7449C1.17544 11.9868 1.40549 12.1613 1.67742 12.1613C1.94914 12.1613 2.17919 11.987 2.26683 11.7451C2.29007 11.8111 2.30645 11.8797 2.30645 11.9516C2.30645 12.2984 2.02419 12.5806 1.67742 12.5806ZM1.8871 11.5323C1.8871 11.6477 1.79311 11.7419 1.67742 11.7419C1.56173 11.7419 1.46774 11.6477 1.46774 11.5323V8.80645H1.8871V11.5323ZM11.3226 12.5806C10.9758 12.5806 10.6935 12.2984 10.6935 11.9516C10.6935 11.8797 10.7099 11.8111 10.7332 11.7451C10.8208 11.987 11.0509 12.1613 11.3226 12.1613C11.5943 12.1613 11.8244 11.987 11.912 11.7451C11.9352 11.8111 11.9516 11.8797 11.9516 11.9516C11.9516 12.2984 11.6693 12.5806 11.3226 12.5806ZM11.5323 11.5323C11.5323 11.6477 11.4383 11.7419 11.3226 11.7419C11.2069 11.7419 11.1129 11.6477 11.1129 11.5323V8.80645H11.5323V11.5323ZM12.1489 7.54839H11.3226V7.96774H12.5806V8.3871H0.419355V7.96774H10.9032V7.54839H4.17236C4.11656 7.27472 3.95387 7.03955 3.72976 6.88833C3.93104 6.7235 4.06854 6.48741 4.10427 6.21712L4.39821 6.0702C4.65857 5.93997 4.95025 5.87097 5.24194 5.87097H10.2742C11.244 5.87097 12.0443 6.60627 12.1489 7.54839ZM5.45161 0.419355H7.54839L7.54859 2.93548H5.45161V0.419355ZM6.70968 3.35484V3.77419H6.29032V3.35484H6.70968Z"
                            fill="white" />
                    </svg>


                </span>
                <span class="navlink-active">Patients</span>
            </a>

            <a href="{{Auth::user()->doctor->prescriptions_list}}" class="nav-link">
              <span class="icon">
                <i class="fa fa-prescription fa-fw"></i>
              </span>
              <span class="navlink-active">Prescriptions</span>
            </a>
        
            <a class="nav-link" href="{{ route('dr_messages', Auth::user()->doctor) }}">
              
                <span>
                  <span class="icon">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path d="M23.9806 0.789727C23.9636 0.710216 23.9346 0.633205 23.8981 0.558694C23.8886 0.539692 23.8791 0.521189 23.8686 0.502186C23.8256 0.426676 23.7756 0.354165 23.7111 0.289656C23.6465 0.225147 23.5735 0.17514 23.498 0.132134C23.48 0.121633 23.462 0.112631 23.443 0.10313C23.3665 0.0656247 23.288 0.0351204 23.206 0.018118C23.2035 0.017618 23.202 0.0171179 23.2 0.0166178C23.1145 -0.00038456 23.0275 -0.00288491 22.9404 0.00261586C22.9214 0.00361601 22.9024 0.00561629 22.8834 0.00811664C22.7954 0.0186181 22.7079 0.0371207 22.6244 0.0711255L0.621767 9.07239C0.229211 9.23292 -0.019324 9.62347 0.00117888 10.0465C0.0216818 10.4701 0.306722 10.8346 0.71328 10.9562L10.1986 13.8021L13.044 23.2874C13.1661 23.6935 13.5306 23.9785 13.9537 23.999C13.9702 23.9995 13.9862 24 14.0027 24C14.4067 24 14.7738 23.756 14.9283 23.3784L23.9296 1.37531C23.9296 1.37481 23.9296 1.37481 23.9296 1.37431C23.9631 1.2923 23.9811 1.20679 23.9916 1.12027C23.9941 1.09877 23.9966 1.07777 23.9976 1.05626C24.0026 0.971252 24.0006 0.88574 23.9841 0.801729C23.9831 0.797728 23.9816 0.793727 23.9806 0.789727ZM18.7813 3.80415L10.7172 11.8688L3.99725 9.8525L18.7813 3.80415ZM14.1472 20.0034L12.1314 13.283L20.1951 5.21935L14.1472 20.0034Z"
                          fill="white" />
                      <path d="M8.70845 15.2918C8.31789 14.9013 7.6848 14.9013 7.29425 15.2918L4.79389 17.7922C4.40334 18.1827 4.40334 18.8158 4.79389 19.2064C4.98942 19.4019 5.24496 19.4994 5.50099 19.4994C5.75703 19.4994 6.01257 19.4019 6.20809 19.2064L8.70845 16.706C9.099 16.3155 9.099 15.6824 8.70845 15.2918Z"
                          fill="white" />
                      <path d="M1.70761 18.2062L3.20782 16.706C3.59838 16.3155 3.59838 15.6824 3.20782 15.2918C2.81726 14.9013 2.18417 14.9013 1.79362 15.2918L0.293405 16.792C-0.0971506 17.1826 -0.0971506 17.8157 0.293405 18.2062C0.488933 18.4018 0.744469 18.4993 1.00051 18.4993C1.25654 18.4993 1.51208 18.4018 1.70761 18.2062Z"
                          fill="white" />
                      <path d="M7.29411 20.7926L5.79389 22.2928C5.40334 22.6833 5.40334 23.3164 5.79389 23.707C5.98942 23.9025 6.24496 24 6.50099 24C6.75703 24 7.01257 23.9025 7.20809 23.707L8.70831 22.2067C9.09886 21.8162 9.09886 21.1831 8.70831 20.7926C8.31775 20.402 7.68466 20.402 7.29411 20.7926Z"
                            fill="white" />
                    </svg>
                  </span>
                  <span class="navlink-active">Chats</span>
                </span> 
                <span class="badge badge-danger float-right">1</span>
              
            </a>

            <a href="{{route('dr_dashboard', Auth::user()->doctor)}}" class="nav-link" title="View Dashboard">
              <span class="icon">
                <i class="fa fa-tachometer-alt fa-fw"></i>
              </span>
              <span class="navlink-active">Dashboard</span>
            </a>

            <a href="#" class="nav-link"
            onclick="event.preventDefault();
            document.getElementById('doctor-logout-form').submit();">
              <span class="icon">
                <i class="fa fa-sign-out-alt fa-fw"></i>
              </span>
              <span>{{ __('Doctor Sign Out') }}</span>
            </a>

            <form id="doctor-logout-form" action="{{ route('doctor.logout') }}" method="POST" style="display: none;">
              @csrf
              {{method_field('PATCH')}}
            </form> 
          </li>
        </ul>
      </li>
    @elseif (Auth::user()->is_doctor)
      <li class="nav-item">

        <a class="nav-link" data-toggle="collapse" href="#doctorSubmenu" role="button" aria-expanded="false" aria-controls="doctorSubmenu">
          
            <span>
              <i class="icon fa fa-user-md fa-fw"></i>
              <span class="navlink-active">Doctor</span>
              <span class="sub-online-status sub-offline ml-1" title="offline"></span>
            </span>
            <small class="text-sm float-right"><i class="fa fa-plus fa-fw"></i></small>
          
        </a>

        <ul id="doctorSubmenu" class=" collapse sub-menu nav flex-sm-column">
          <li class="nav-item">

            @if (is_null(Auth::user()->doctor_password))
              <a href="{{route('doctor.password')}}" class="nav-link">
                <span class="icon fa fa-key"></span>
                <span class="navlink-active">Add Doctor's Password</span>
              </a>
            @else
              <a href="{{route('doctor.login')}}" 
                class="nav-link"
                data-toggle="modal" data-target="#doctor-sign-in-modal"
                >
                <span class="icon fa fa-sign-in-alt"></span>
                <span class="navlink-active">Doctor Sign In</span>
              </a>
            @endif
          </li>
        </ul>
      </li>
    @endif

    @if (Auth::user()->is_administrator || Auth::user()->is_doctor)
      <li class="nav-item"><hr></li>
    @endif

                

    {{-- <li class="nav-item">
      <a class="nav-link" href="{{route('user_dashboard')}}">
        <span class="icon">
          <svg width="25" height="22" viewBox="0 0 15 12" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M14.6829 0H1.27713C1.12408 0 1 0.12408 1 0.277129V11.6168C1 11.7698 1.12408 11.8939 1.27713 11.8939H14.6829C14.8359 11.8939 14.96 11.7698 14.96 11.6168V0.277129C14.96 0.12408 14.8359 0 14.6829 0V0ZM1.55426 0.554259H14.4057V1.70378H1.55426V0.554259ZM14.4057 11.3396H1.55426V2.25804H14.4057V11.3396Z"
                fill="white" />
            <path
                d="M0.779985 0.862149L0.766352 0.858953C0.617349 0.824019 0.468134 0.916254 0.4332 1.06536C0.39816 1.21426 0.490607 1.36347 0.639609 1.39841L0.653242 1.40171C0.674543 1.40672 0.695845 1.40906 0.716826 1.40906C0.842504 1.40906 0.956359 1.323 0.986394 1.1953C1.02133 1.0463 0.928987 0.897083 0.779985 0.862149Z"
                fill="white" />
            <path
                d="M1.4859 0.862182L1.47227 0.858987C1.32337 0.823947 1.17405 0.916288 1.13901 1.06529C1.10397 1.21429 1.19642 1.36351 1.34542 1.39844L1.35905 1.40174C1.38035 1.40675 1.40166 1.40909 1.42264 1.40909C1.54831 1.40909 1.66217 1.32304 1.6922 1.19533C1.72724 1.04633 1.6348 0.897223 1.4859 0.862182Z"
                fill="white" />
            <path
                d="M2.19186 0.862182L2.17822 0.858987C2.02933 0.823947 1.88001 0.916288 1.84507 1.06529C1.81003 1.21429 1.90237 1.36351 2.05137 1.39844L2.06501 1.40174C2.08631 1.40675 2.10761 1.40909 2.1287 1.40909C2.25438 1.40909 2.36823 1.32304 2.39816 1.19533C2.4332 1.04633 2.34086 0.897223 2.19186 0.862182Z"
                fill="white" />
            <path
                d="M0.745289 5.40437L0.759028 5.40756C0.780329 5.41257 0.801631 5.41502 0.822612 5.41502C0.94829 5.41502 1.06215 5.32886 1.09207 5.20115C1.12711 5.05215 1.03467 4.90304 0.885771 4.868L0.872031 4.86481C0.723135 4.82987 0.57392 4.92221 0.538879 5.07122C0.503945 5.22022 0.596286 5.36933 0.745289 5.40437Z"
                fill="white" />
            <path
                d="M9.33622 0.851562H7.27713C7.12408 0.851562 7 0.975642 7 1.12869C7 1.28174 7.12408 1.40582 7.27713 1.40582H9.33622C9.48927 1.40582 9.61335 1.28174 9.61335 1.12869C9.61335 0.975642 9.48927 0.851562 9.33622 0.851562Z"
                fill="white" />
            <path
                d="M3.34483 8.46132C3.22725 8.76082 3.13874 9.07139 3.08144 9.38793C3.053 9.54534 3.03223 9.70404 3.01924 9.86337C3.01285 9.94208 3.00859 10.0209 3.00561 10.0997C3.00284 10.172 2.99357 10.2512 3.00742 10.3226C3.03245 10.4513 3.14864 10.5467 3.27954 10.5467H12.6142C12.7316 10.5467 12.839 10.4698 12.8767 10.3585C12.8999 10.29 12.8914 10.2141 12.8895 10.1432C12.8874 10.0608 12.8831 9.9785 12.8769 9.89628C12.8529 9.57602 12.7977 9.25841 12.712 8.94891C12.6635 8.7737 12.6049 8.60116 12.5372 8.43246C12.1752 7.52779 11.5485 6.73666 10.7165 6.17314C10.7165 6.17314 10.7165 6.17314 10.7163 6.17303C10.0396 5.71463 9.26807 5.43505 8.46033 5.35165C7.86858 5.29031 7.26533 5.33568 6.68998 5.48734C6.53075 5.52931 6.37387 5.57894 6.21975 5.63656C6.19292 5.64657 6.16629 5.65658 6.13966 5.66702C6.13317 5.66958 6.12677 5.67224 6.12028 5.6749C5.88298 5.76916 5.6525 5.88142 5.43161 6.01221C4.70523 6.44217 4.09687 7.05469 3.67191 7.78373C3.54645 7.99908 3.43855 8.22339 3.34749 8.45418C3.34664 8.45663 3.34568 8.45898 3.34483 8.46132ZM6.38835 6.16515C6.98852 5.93744 7.63565 5.84446 8.27575 5.89164C8.45767 5.90506 8.63862 5.9303 8.81744 5.9663C9.34678 6.07324 9.84182 6.2757 10.2839 6.55486V7.16205C9.56831 6.77724 8.76962 6.57584 7.94686 6.57584C7.21932 6.57584 6.50296 6.73581 5.84986 7.0417V6.41352C6.02272 6.31916 6.2025 6.23598 6.38835 6.16515ZM11.9533 8.47485C12.0048 8.58977 12.0513 8.70682 12.0928 8.82568C11.7617 8.317 11.3372 7.86936 10.8382 7.50915V6.96895C11.3099 7.38273 11.6927 7.89556 11.9533 8.47485ZM9.01224 8.78425L9.38747 8.22221C9.47246 8.09494 9.43816 7.92282 9.31089 7.83783C9.18351 7.75284 9.0115 7.78724 8.92651 7.91452L8.51486 8.5313C8.33593 8.47261 8.14507 8.44055 7.94686 8.44055C7.0325 8.44055 6.27269 9.11495 6.13881 9.99246H3.83007C4.17845 9.05009 4.83698 8.25885 5.71396 7.73963C6.38761 7.34087 7.15967 7.12999 7.94686 7.12999C8.82852 7.12999 9.67876 7.39029 10.4057 7.88278C11.1676 8.39901 11.7466 9.13902 12.0635 9.99246H9.75491C9.67919 9.49624 9.40302 9.06542 9.01224 8.78425ZM5.2956 6.77277V7.34609C4.69171 7.72983 4.18591 8.23137 3.80376 8.81726C4.09197 7.9978 4.61662 7.28879 5.2956 6.77277ZM6.70233 9.99246C6.82929 9.42233 7.33903 8.99481 7.94686 8.99481C8.55459 8.99481 9.06443 9.42233 9.19128 9.99246H6.70233Z"
                fill="white" />
            <path
                d="M0.81546 4.33295C0.968509 4.33295 1.09259 4.20887 1.09259 4.05582V3.24957H1.69829C1.85134 3.24957 1.97542 3.12549 1.97542 2.97244C1.97542 2.81929 1.85134 2.69531 1.69829 2.69531H0.81546C0.66241 2.69531 0.53833 2.81929 0.53833 2.97244V4.05582C0.53833 4.20887 0.66241 4.33295 0.81546 4.33295Z"
                fill="white" />
            <path
                d="M6.27713 3.46442H10.5966C10.7497 3.46442 10.8737 3.34034 10.8737 3.18729C10.8737 3.03413 10.7497 2.91016 10.5966 2.91016H6.27713C6.12408 2.91016 6 3.03413 6 3.18729C6 3.34034 6.12408 3.46442 6.27713 3.46442Z"
                fill="white" />
            <path
                  d="M9.33622 3.93262H7.27713C7.12408 3.93262 7 4.0567 7 4.20975C7 4.3628 7.12408 4.48688 7.27713 4.48688H9.33622C9.48927 4.48688 9.61335 4.3628 9.61335 4.20975C9.61335 4.0567 9.48927 3.93262 9.33622 3.93262Z"
                  fill="white" />
          </svg>


        </span>
        <span class="navlink-active">Dashboard</span>
        @if ($events_count)
        <span class="badge badge-warning float-right">
          {{ $events_count }}
        </span>
        @endif
      </a>
    </li>  --}}
    

    <li class="nav-item">
    
        <a class="nav-link" href="{{Auth::user()->link}}">
          <span class="icon">
            <i class="fa fa-user fa-fw"></i>
          </span>
          <span class="navlink-active">Profile</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="{{ route('messages.index', Auth::user()) }}">
            <span>
              <span class="icon">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M23.9806 0.789727C23.9636 0.710216 23.9346 0.633205 23.8981 0.558694C23.8886 0.539692 23.8791 0.521189 23.8686 0.502186C23.8256 0.426676 23.7756 0.354165 23.7111 0.289656C23.6465 0.225147 23.5735 0.17514 23.498 0.132134C23.48 0.121633 23.462 0.112631 23.443 0.10313C23.3665 0.0656247 23.288 0.0351204 23.206 0.018118C23.2035 0.017618 23.202 0.0171179 23.2 0.0166178C23.1145 -0.00038456 23.0275 -0.00288491 22.9404 0.00261586C22.9214 0.00361601 22.9024 0.00561629 22.8834 0.00811664C22.7954 0.0186181 22.7079 0.0371207 22.6244 0.0711255L0.621767 9.07239C0.229211 9.23292 -0.019324 9.62347 0.00117888 10.0465C0.0216818 10.4701 0.306722 10.8346 0.71328 10.9562L10.1986 13.8021L13.044 23.2874C13.1661 23.6935 13.5306 23.9785 13.9537 23.999C13.9702 23.9995 13.9862 24 14.0027 24C14.4067 24 14.7738 23.756 14.9283 23.3784L23.9296 1.37531C23.9296 1.37481 23.9296 1.37481 23.9296 1.37431C23.9631 1.2923 23.9811 1.20679 23.9916 1.12027C23.9941 1.09877 23.9966 1.07777 23.9976 1.05626C24.0026 0.971252 24.0006 0.88574 23.9841 0.801729C23.9831 0.797728 23.9816 0.793727 23.9806 0.789727ZM18.7813 3.80415L10.7172 11.8688L3.99725 9.8525L18.7813 3.80415ZM14.1472 20.0034L12.1314 13.283L20.1951 5.21935L14.1472 20.0034Z"
                      fill="white" />
                  <path d="M8.70845 15.2918C8.31789 14.9013 7.6848 14.9013 7.29425 15.2918L4.79389 17.7922C4.40334 18.1827 4.40334 18.8158 4.79389 19.2064C4.98942 19.4019 5.24496 19.4994 5.50099 19.4994C5.75703 19.4994 6.01257 19.4019 6.20809 19.2064L8.70845 16.706C9.099 16.3155 9.099 15.6824 8.70845 15.2918Z"
                      fill="white" />
                  <path d="M1.70761 18.2062L3.20782 16.706C3.59838 16.3155 3.59838 15.6824 3.20782 15.2918C2.81726 14.9013 2.18417 14.9013 1.79362 15.2918L0.293405 16.792C-0.0971506 17.1826 -0.0971506 17.8157 0.293405 18.2062C0.488933 18.4018 0.744469 18.4993 1.00051 18.4993C1.25654 18.4993 1.51208 18.4018 1.70761 18.2062Z"
                      fill="white" />
                  <path d="M7.29411 20.7926L5.79389 22.2928C5.40334 22.6833 5.40334 23.3164 5.79389 23.707C5.98942 23.9025 6.24496 24 6.50099 24C6.75703 24 7.01257 23.9025 7.20809 23.707L8.70831 22.2067C9.09886 21.8162 9.09886 21.1831 8.70831 20.7926C8.31775 20.402 7.68466 20.402 7.29411 20.7926Z"
                        fill="white" />
                </svg>
              </span>
              <span class="navlink-active">Chats</span>
            </span> 
            <span class="badge badge-danger float-right">1</span>
        </a>
    </li>
                
    <li class="nav-item">
    
        <a class="nav-link" href="{{Auth::user()->appointments_list}}">
            <span class="icon">
                <svg width="24" height="24" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M13.3342 1.17901H12.587V0.675267C12.587 0.302947 12.284 0 11.9117 0C11.5392 0 11.2361 0.302947 11.2361 0.675267V1.17901H10.7819V0.675267C10.7819 0.302947 10.479 0 10.1067 0C9.73413 0 9.43108 0.302947 9.43108 0.675267V1.17901H8.88384C8.7678 1.17901 8.67424 1.27289 8.67424 1.38861C8.67424 1.50434 8.7678 1.59822 8.88384 1.59822H9.43108V2.10186C9.43108 2.47449 9.73413 2.77744 10.1067 2.77744C10.479 2.77744 10.7819 2.47449 10.7819 2.10186V1.59822H11.2361V2.10186C11.2361 2.47449 11.5392 2.77744 11.9117 2.77744C12.284 2.77744 12.587 2.47449 12.587 2.10186V1.59822H13.3342C13.4701 1.59822 13.5807 1.70896 13.5807 1.84473V3.49302C13.4492 3.49302 2.08599 3.49302 1.41931 3.49302V1.84473C1.41931 1.70896 1.52995 1.59822 1.66583 1.59822H2.41291V2.10186C2.41291 2.47449 2.71585 2.77744 3.08817 2.77744C3.46081 2.77744 3.76376 2.47449 3.76376 2.10186V1.59822H4.21797V2.10186C4.21797 2.47449 4.52102 2.77744 4.89323 2.77744C5.26587 2.77744 5.56882 2.47449 5.56882 2.10186V1.59822H8.04533C8.16105 1.59822 8.25493 1.50434 8.25493 1.38861C8.25493 1.27289 8.16105 1.17901 8.04533 1.17901H5.56882V0.675267C5.56882 0.302947 5.26587 0 4.89323 0C4.52102 0 4.21797 0.302947 4.21797 0.675267V1.17901H3.76376V0.675267C3.76376 0.302947 3.46081 0 3.08817 0C2.71585 0 2.41291 0.302947 2.41291 0.675267V1.17901H1.66583C1.29881 1.17901 1 1.47772 1 1.84473V12.7568C1 13.3891 1.51456 13.9033 2.14687 13.9033H2.51134C2.62707 13.9033 2.72094 13.8097 2.72094 13.6937C2.72094 13.578 2.62707 13.484 2.51134 13.484H2.14687C1.7457 13.484 1.41931 13.1578 1.41931 12.7568V11.724H13.5807V12.7568C13.5807 13.1578 13.2542 13.484 12.8531 13.484H3.34986C3.23413 13.484 3.14015 13.578 3.14015 13.6937C3.14015 13.8097 3.23413 13.9033 3.34986 13.9033H12.8531C13.4853 13.9033 14 13.3891 14 12.7568C14 12.3182 14 2.31072 14 1.84473C14 1.47772 13.7012 1.17901 13.3342 1.17901ZM10.2875 2.28303C10.2414 2.32938 10.1771 2.35824 10.1067 2.35824C9.96527 2.35824 9.85039 2.24336 9.85039 2.10186C9.85039 1.37101 9.85039 1.40686 9.85039 0.675267C9.85039 0.534188 9.96527 0.41931 10.1067 0.41931C10.2478 0.41931 10.3627 0.534188 10.3627 0.675267C10.3627 2.21726 10.3905 2.18003 10.2875 2.28303ZM12.1678 2.10186C12.1678 2.24336 12.0529 2.35824 11.9117 2.35824C11.7703 2.35824 11.6554 2.24336 11.6554 2.10186C11.6554 1.37069 11.6554 1.40686 11.6554 0.675267C11.6554 0.534188 11.7703 0.41931 11.9117 0.41931C12.0529 0.41931 12.1678 0.534188 12.1678 0.675267V2.10186ZM4.63728 0.675267C4.63728 0.534188 4.75215 0.41931 4.89323 0.41931C5.03474 0.41931 5.14961 0.534188 5.14961 0.675267V2.10186C5.14961 2.24336 5.03474 2.35824 4.89323 2.35824C4.75215 2.35824 4.63728 2.24336 4.63728 2.10186C4.63728 1.6747 4.63728 1.10264 4.63728 0.675267ZM2.83222 0.675267C2.83222 0.534188 2.94709 0.41931 3.08817 0.41931C3.22967 0.41931 3.34455 0.534188 3.34455 0.675267V2.10186C3.34455 2.24336 3.22967 2.35824 3.08817 2.35824C2.94709 2.35824 2.83222 2.24336 2.83222 2.10186C2.83222 1.6747 2.83222 1.10264 2.83222 0.675267ZM3.51618 11.3047H1.41931V9.12989H3.51618V11.3047ZM3.51618 8.71058H1.41931V6.53607H3.51618V8.71058ZM3.51618 6.08684H1.41931C1.41931 5.64335 1.41931 4.35062 1.41931 3.91233H3.51618V6.08684ZM6.03225 11.3047H3.93538V9.12989H6.03225V11.3047ZM6.03225 8.71058H3.93538V6.53607H6.03225V8.71058ZM6.03225 6.08684H3.93538V3.91233H6.03225V6.08684ZM8.54844 11.3047H6.45157V9.12989H8.54844V11.3047ZM8.54844 8.71058H6.45157V6.53607H8.54844V8.71058ZM8.54844 6.08684H6.45157V3.91233H8.54844V6.08684ZM11.0645 11.3047H8.96764V9.12989H11.0645V11.3047ZM11.0645 8.71058H8.96764V6.53607H11.0645V8.71058ZM11.0645 6.08684H8.96764V3.91233H11.0645V6.08684ZM13.5807 11.3047H11.4838V9.12989H13.5807V11.3047ZM13.5807 8.71058H11.4838V6.53607H13.5807V8.71058ZM13.5807 6.08684H11.4838V3.91233H13.5807V6.08684Z"
                        fill="white" />
                    <path
                        d="M7.54405 8.4068C7.63231 8.49506 7.77869 8.48731 7.85676 8.38845L8.85534 7.12373C8.92704 7.03283 8.91156 6.90098 8.82065 6.82927C8.72975 6.75756 8.598 6.77305 8.5263 6.86385L7.67378 7.94368L7.35789 7.62769C7.276 7.5458 7.14331 7.5458 7.06142 7.62769C6.97953 7.70958 6.97953 7.84228 7.06142 7.92417L7.54405 8.4068Z"
                        fill="white" />
                    <path
                        d="M1.23643 5.78466C1.30081 5.78466 1.36128 5.75506 1.40095 5.70489L2.39942 4.44006C2.47113 4.34927 2.45564 4.21742 2.36484 4.14571C2.27394 4.074 2.14209 4.08938 2.07038 4.18029L1.21797 5.26002L0.902083 4.94413C0.820194 4.86224 0.687389 4.86224 0.605606 4.94413C0.523717 5.02602 0.523717 5.15872 0.605606 5.2406C1.12113 5.75612 1.12155 5.78466 1.23643 5.78466Z"
                        fill="white" />
                    <path
                        d="M7.69224 11.0328C7.75673 11.0328 7.81719 11.0032 7.85687 10.953L8.85534 9.68818C8.92704 9.59738 8.91156 9.46553 8.82065 9.39371C8.72985 9.32201 8.598 9.3375 8.5263 9.4284L7.67378 10.5081L7.35789 10.1922C7.276 10.1104 7.14331 10.1104 7.06142 10.1922C6.97953 10.2741 6.97953 10.4068 7.06142 10.4886C7.57694 11.0042 7.57736 11.0328 7.69224 11.0328Z"
                        fill="white" />
                </svg>



            </span>
            <span class="navlink-active">Appointments</span>
        </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="{{route('doctors.index')}}">
        <span>
          <span class="icon">
            <svg width="22" height="25" viewBox="0 0 12 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M11.7196 1.40203C11.3459 0.754689 10.6765 0.368237 9.92898 0.368237V1.0978C10.4128 1.0978 10.8459 1.3479 11.0878 1.76682C11.3297 2.18581 11.3297 2.686 11.0879 3.10499L8.74438 7.16401C8.50253 7.58293 8.06931 7.83303 7.58553 7.8331C7.10176 7.8331 6.66854 7.583 6.42661 7.16401L4.08317 3.10492C3.84132 2.686 3.84132 2.18574 4.08317 1.76682C4.32502 1.3479 4.75831 1.09773 5.24209 1.09773V0.368164C4.49457 0.368164 3.82512 0.754616 3.45136 1.40203C3.07761 2.04945 3.07761 2.82236 3.45136 3.4697L5.79481 7.52872C6.10648 8.06853 6.62403 8.42602 7.22075 8.5302V10.4878C7.22075 12.4 6.09189 13.9558 4.70432 13.9558C3.31676 13.9558 2.18797 12.4 2.18797 10.4878V8.15695C3.01895 7.98755 3.64623 7.25098 3.64623 6.37053C3.64623 5.36526 2.82839 4.54742 1.82312 4.54742C0.817845 4.54742 0 5.36526 0 6.37053C0 7.2509 0.627282 7.98748 1.45833 8.15695V10.4878C1.45833 12.8023 2.91448 14.6853 4.70432 14.6853C6.4941 14.6853 7.95024 12.8023 7.95024 10.4878V8.5302C8.54688 8.42602 9.06451 8.06853 9.37611 7.52872L11.7196 3.4697C12.0935 2.82236 12.0935 2.04938 11.7196 1.40203Z"
                    fill="white" />
            </svg>
          </span>
          <span class="navlink-active">Doctors</span>
        </span>
      </a>
    </li>

    <li class="nav-item mb-4">
    
        <a class="nav-link" href="{{Auth::user()->transactions_list}}">
            <span class="icon">
                <svg width="24" height="24" viewBox="0 0 11 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M10.58 1.43719L3.843 0.0114537C3.55797 -0.0488492 3.27545 0.135043 3.21515 0.420075L3.08716 1.2426L10.8605 2.88757L10.9885 2.06504C11.0488 1.78011 10.865 1.49751 10.58 1.43719Z"
                        fill="white" />
                    <path
                        d="M7.74697 3.06258C7.66828 2.7792 7.37214 2.6117 7.08885 2.69026L5.80993 3.0453L2.79493 2.40723L2.46334 3.97393L0.391586 4.54896C0.108316 4.62754 -0.0591843 4.92368 0.0193802 5.20697L1.18694 9.41429C1.26563 9.69756 1.56178 9.86517 1.84506 9.7865L8.54232 7.92793C8.82559 7.84924 8.99309 7.55321 8.91453 7.26981L8.71412 6.54754L9.46523 6.70634C9.75027 6.76675 10.0328 6.58286 10.0931 6.29783L10.5683 4.05221L7.86274 3.47968L7.74697 3.06258ZM8.52041 5.20091L8.68604 4.41811C8.71092 4.3009 8.82714 4.2253 8.94433 4.25005L9.72713 4.41579C9.84445 4.44066 9.92005 4.55676 9.8953 4.67407L9.72967 5.45688C9.70479 5.57409 9.58859 5.64979 9.47138 5.62494L8.68857 5.4593C8.57115 5.43434 8.49553 5.31812 8.52041 5.20091ZM0.50813 4.96881L2.36152 4.45465L6.73458 3.2411L7.20516 3.11035C7.21375 3.10803 7.22233 3.10694 7.2307 3.10694C7.26845 3.10694 7.31358 3.13171 7.32677 3.17914L7.38203 3.37811L7.55513 4.00188L0.667703 5.91317L0.439343 5.09053C0.425036 5.03891 0.456526 4.98312 0.50813 4.96881ZM8.49455 7.38623C8.50335 7.41815 8.49411 7.44455 8.48475 7.46107C8.47551 7.47757 8.45768 7.49916 8.42576 7.50795L1.72862 9.36651C1.72015 9.36883 1.71145 9.37004 1.70308 9.37004C1.66533 9.37004 1.6202 9.34516 1.60701 9.29773L0.926008 6.84366L7.81344 4.93227L8.23351 6.44583L8.49455 7.38623Z"
                        fill="white" />
                    <path
                        d="M2.81063 7.55419C2.77849 7.43864 2.65787 7.37041 2.54231 7.40244L1.76018 7.61956C1.64473 7.65159 1.57639 7.77232 1.60853 7.88788L1.82555 8.66991C1.85768 8.78547 1.97831 8.8537 2.09386 8.82156L2.876 8.60454C2.99156 8.57251 3.05979 8.45178 3.02776 8.33623L2.81063 7.55419Z"
                        fill="white" />
                </svg>

            </span>
            <span class="navlink-active">Payments</span>
        </a>
    </li>

</ul>
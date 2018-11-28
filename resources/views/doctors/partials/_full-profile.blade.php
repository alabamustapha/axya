<div>
            <h1>
              {{$doctor->user->name}} 
              <small style="font-size: 14px;" class="badge badge-secondary badge-pill">
                ${{$doctor->rate}} / hour
              </small>
              <span class="{{$doctor->availabilityText()}}"></span>
            </h1>
            <span class="h6">
              <ul class="list-unstyled">
                <li class="pb-1" title="Speicialty">
                  <span>
                    <i class="fa fa-user-md"></i> {{ $doctor->specialty->name }}
                  </span>
                </li>

                @if(Auth::check() && (Auth::user()->can('edit', $doctor) || Auth::user()->is_admin))
                <li class="pb-1" title="Email">
                  <span>
                    <i class="fa fa-at"></i> {{$doctor->user->email}}
                  </span>
                </li>
                <li class="pb-1" title="Phone">
                  <span>
                    <i class="fa fa-mobile"></i> {{$doctor->user->phone}}
                  </span>
                </li>
                @endif
              </ul>
            </span>
            
            <hr>

            <ul class="list-group list-group-unbordered mb-3" style="font-size:90%">
              <li class="list-group-item p-1 px-3 mt-0 border-top-0{{--  tf-flex --}}">
                <b class="d-inline-block w-35"><i class="fa fa-procedures"></i> Patients Served</b> <a>{{$doctor->patients->count()}}</a>
              </li>
              <li class="list-group-item p-1 px-3{{--  tf-flex --}}">
                <b class="d-inline-block w-35"><i class="fa fa-university"></i> Alma mater</b> <span>{{ $doctor->graduate_school }}</span>
              </li>
              <li class="list-group-item p-1 px-3{{--  tf-flex --}}">
                <b class="d-inline-block w-35"><i class="fa fa-calendar-alt"></i> Availabilty</b> <span>{{$doctor->available ? 'Available':'Unavailable'}}</span>
              </li>
              <li class="list-group-item p-1 px-3{{--  tf-flex --}}">
                <b class="d-inline-block w-35"><i class="fa fa-calendar"></i> Practice Years</b> <span>{{$doctor->practice_years}} yrs</span>
              </li>

              <li class="list-group-item p-1 px-3{{--  tf-flex --}}">
                <b class="d-inline-block w-35"><i class="fa fa-map-marker"></i> Location</b> <span>{{$doctor->user->address}}</span>
              </li>
              <li class="list-group-item p-1 px-3{{--  tf-flex --}}">
                <b class="d-inline-block w-35"><i class="fa fa-hospital-alt"></i> Place of Work</b> 
                <span>
                  @if($present_workplace)
                    <span>{{ $present_workplace->name }}, {{ $present_workplace->address }}</span>
                  @else
                    <span>---</span>
                  @endif
                </span>
              </li>
              <li class="list-group-item p-1 px-3 border-bottom-0{{--  tf-flex --}}">
                <b class="d-inline-block w-35"><i class="fa fa-info-circle"></i> About</b> <span> {{ $doctor->about }}</span>
              </li>
            </ul>
          </div>
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
                <li class="pb-1" title="Current rating">
                  <span>
                    <i class="fa fa-star text-light"></i> 
                    <span>
                      @for($i=1; $i <= $doctor->rating_digit; $i++)
                        <i class="fas fa-star"></i>
                      @endfor
                      
                      @for($i=1; $i <= (5 - $doctor->rating_digit); $i++)
                        <i class="fas fa-star text-light"></i>
                      @endfor
                    </span>

                    <span class="text-bold">{{ $doctor->rating }}</span>
                  </span>
                </li>

                @if(Auth::check() && (Auth::user()->can('edit', $doctor) || Auth::user()->is_admin))
                <li class="pb-1" title="Email">
                  <span>
                    <i class="fa fa-at"></i> {{$doctor->email}}
                  </span>
                </li>
                @endif
              </ul>
            </span>
            
            <hr>

            <ul class="list-group list-group-unbordered mb-3" style="font-size:90%">
              <li class="list-group-item p-1 px-3 mt-0 border-top-0">
                <b class="d-inline-block w-35"><i class="fa fa-procedures"></i> Patients Served</b> <a>{{$doctor->patients_count}}</a>
              </li>
              <li class="list-group-item p-1 px-3">
                <b class="d-inline-block w-35"><i class="fa fa-university"></i> Education</b> <span>{{ $doctor->graduate_school }}</span>
              </li>
              <li class="list-group-item p-1 px-3">
                <b class="d-inline-block w-35"><i class="fa fa-calendar-alt"></i> Availabilty</b> <span>{{$doctor->available ? 'Available':'Unavailable'}}</span>
              </li>
              <li class="list-group-item p-1 px-3">
                <b class="d-inline-block w-35"><i class="fa fa-calendar"></i> Practice Years</b> <span>{{$doctor->practice_years}} yrs</span>
              </li>

              <li class="list-group-item p-1 px-3">
                <b class="d-inline-block w-35"><i class="fa fa-map-marker"></i> Location</b> <span>{{$doctor->location}}</span>
              </li>
              <li class="list-group-item p-1 px-3" title="Phone">
                <b class="d-inline-block w-35"><i class="fa fa-mobile"></i> Contact Number</b> <span>{{$doctor->phone}}</span>
              </li>
              <li class="list-group-item p-1 px-3">
                <b class="d-inline-block w-35"><i class="fa fa-hospital-alt"></i> Place of Work</b> 
                <span>
                  @if($current_workplace)
                    <span>{{ $current_workplace->name }}, {{ $current_workplace->address }}</span>
                  @else
                    <span>---</span>
                  @endif
                </span>
              </li>
              <li class="list-group-item p-1 px-3 border-bottom-0">
                <b class="d-inline-block w-35"><i class="fa fa-info-circle"></i> About</b> <span> {{ $doctor->about }}</span>
              </li>
            </ul>
          </div>

<a href="{{route('doctors.show', $doctor)}}" class="search-item p-0">
    <table class="table border-less">
        <tr>
            <td class="text-md-left text-center">
                <div class="row">
                    <div class="col-md-3">
                        <img src="{{ $doctor->avatar }}" height="60" class="rounded-circle doc-img" alt="doctor's image">
                        
                        {{-- $doctor->availability_status --}}
                        @if ($doctor->is_active)
                            <span class="bg-success doc-avail-indicator" title="Available"></span>
                        @else
                            <span class="bg-danger doc-avail-indicator" title="Unavailable"></span>
                        {{-- @elseif ($doctor->is_suspended) { {
                            <span class="bg-warning doc-avail-indicator" title="***"></span> --}}
                        @endif
                    </div>

                    <!-- personal detail -->
                    <div id="p-d" class="col-md-5">
                        <span class="name">{{ $doctor->name }}</span>
                        <br>
                        <span class="speciality text-muted">{{ $doctor->specialty->name }}</span>
                    </div>

                    <!-- work detail -->
                    <div id="w-d" class="col-md-4">
                        <span class="name mb-2">
                            <span>{{ $doctor->location }}</span>
                        </span>
                        <span class="fee">{{-- Fee -  --}}<strong>{{setting('base_currency')}} {{ $doctor->rate }}</strong> </span>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td class="border-top-0">
                <div class="row mx-auto text-center">

                    <!-- schedule detail -->
                    
                    <div id="s-d" class="offset-md-3 col-md-6 col-8 search-cell text-center">
                        <ul class="nav">
                            <li class="nav-item {{$doctor->has_sunday_schedules ? 'has':''}}"   >S</li>
                            <li class="nav-item {{$doctor->has_monday_schedules ? 'has':''}}"   >M</li>
                            <li class="nav-item {{$doctor->has_tuesday_schedules ? 'has':''}}"  >T</li>
                            <li class="nav-item {{$doctor->has_wednesday_schedules ? 'has':''}}">W</li>
                            <li class="nav-item {{$doctor->has_thursday_schedules ? 'has':''}}" >T</li>
                            <li class="nav-item {{$doctor->has_friday_schedules ? 'has':''}}"   >F</li>
                            <li class="nav-item {{$doctor->has_saturday_schedules ? 'has':''}}" >S</li>
                        </ul>
                    </div>
                    

                    <!-- ratings -->
                    <div class="ratings" class=" col-md-3 col-4 search-cell text-center">
                        <ul class="nav">
                            @php
                              // Reduce queries by 7
                              $rating = $doctor->rating_digit;
                            @endphp
                            @if ($rating)
                                @for($i=1; $i <= $rating; $i++)
                                  <li class="nav-item text-review review-star" ><i class="fa fa-star"></i></li>
                                @endfor
                            @else
                                <li class="nav-item" ><i class="fa fa-star text-secondary"></i></li>
                                <li class="nav-item" ><i class="fa fa-star text-secondary"></i></li>
                                <li class="nav-item" ><i class="fa fa-star text-secondary"></i></li>
                                <li class="nav-item" ><i class="fa fa-star text-secondary"></i></li>
                                <li class="nav-item" ><i class="fa fa-star text-secondary"></i></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </td>
        </tr>
    </table>
</a>
<ul class="list-inline mx-auto">
  <li class="nav-item list-inline-item mr-0 {{$doctor->has_sunday_schedules ? 'has':''}}"    title="{{$doctor->has_sunday_schedules ? 'Available on ':'Not available on '}}Sundays">S</li>
  <li class="nav-item list-inline-item mr-0 {{$doctor->has_monday_schedules ? 'has':''}}"    title="{{$doctor->has_moday_schedules ? 'Available on ':'Not available on '}}Mondays">M</li>
  <li class="nav-item list-inline-item mr-0 {{$doctor->has_tuesday_schedules ? 'has':''}}"   title="{{$doctor->has_tuesday_schedules ? 'Available on ':'Not available on '}}Tuesdays">T</li>
  <li class="nav-item list-inline-item mr-0 {{$doctor->has_wednesday_schedules ? 'has':''}}" title="{{$doctor->has_wednesday_schedules ? 'Available on ':'Not available on '}}Wednesdays">W</li>
  <li class="nav-item list-inline-item mr-0 {{$doctor->has_thursday_schedules ? 'has':''}}"  title="{{$doctor->has_thursday_schedules ? 'Available on ':'Not available on '}}Thursdays">T</li>
  <li class="nav-item list-inline-item mr-0 {{$doctor->has_friday_schedules ? 'has':''}}"    title="{{$doctor->has_friday_schedules ? 'Available on ':'Not available on '}}Fridays">F</li>
  <li class="nav-item list-inline-item mr-0 {{$doctor->has_saturday_schedules ? 'has':''}}"  title="{{$doctor->has_saturday_schedules ? 'Available on ':'Not available on '}}Saturdays">S</li>
</ul>
@extends('layouts.master')

@section('title')
    @if (Request::is('doctors/*/appointments'))
        {{$doctor->name}} - Doctors Appointment Index
    @else
        {{$user->name}} - Appointments Index
    @endif
@endsection

@section('page-title')
    @if (Request::is('doctors/*/appointments'))
        Doctor Appointments - <strong>{{$doctor->name}}</strong>
    @else
        Appointments - <strong>{{$user->name}}</strong>
    @endif
@endsection

@section('content')

    <div class="row">
        
        <div class="col-md-3">
            <div class="card transaction-menu " >
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <a class="nav-link active" id="v-pills-all-appointnments-tab" data-toggle="pill" href="#v-pills-all-appointnments" role="tab"
                            aria-controls="v-pills-home" aria-selected="true">
                            <i class="fas fa-calendar-alt fa-fw"></i> Appointments</a>
                        </li>

                        <li class="list-group-item">
                            <a class="nav-link tf-flex" id="v-pills-upcoming-appointments-tab" data-toggle="pill" href="#v-pills-upcoming-appointments" role="tab"
                            aria-controls="v-pills-home" aria-selected="false">
                                <span><i class="fas fa-calendar-plus fa-fw"></i> Upcoming</span>
                                @if (count($upcoming_appointments))
                                    <span class="badge badge-danger">{{ count($upcoming_appointments) }}</span>
                                @endif
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a class="nav-link tf-flex" id="v-pills-pending-appointments-tab" data-toggle="pill" href="#v-pills-pending-appointments" role="tab"
                            aria-controls="v-pills-home" aria-selected="false">
                                <span><i class="fas fa-calendar fa-fw"></i> Pending</span>
                                @if (count($pending_appointments))
                                    <span class="badge badge-danger">{{ count($pending_appointments) }}</span>
                                @endif
                            </a>
                        </li>

                        <li class="list-group-item">
                            <a class="nav-link tf-flex" id="v-pills-past-appointments-tab" data-toggle="pill" href="#v-pills-past-appointments" role="tab"
                            aria-controls="v-pills-home" aria-selected="false">
                                <span><i class="fas fa-calendar-check fa-fw"></i> Past</span>
                                @if (count($past_appointments))
                                    <span class="badge badge-danger">{{ count($past_appointments) }}</span>
                                @endif
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-all-appointnments" role="tabpanel" aria-labelledby="v-pills-all-appointnments-tab">
                   <div class="card p-3">
                        <h5 class="card-title text-center">All Appointments
                        </h5>

                        <div class="card-body">
                            <div class="table-responsive-md transaction-table">
                                <table class="table table-borderless">
                                    <thead >
                                        <tr>
                                            <th scope="col">Fee <small class="text-sm">({{ setting('base_currency') }})</small></th>
                                            <th scope="col">
                                                @if(\Route::input('doctor.slug'))
                                                    Patient
                                                @else
                                                    Doctor
                                                @endif
                                            </th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($appointments as $appointment)
                                            <tr>                                                
                                                <td>{{ $appointment->fee }}</td>
                                                <td>
                                                    @if($appointment->creator)
                                                        <a href="{{route('doctors.show', $appointment->doctor)}}" style="color:inherit;">{{$appointment->doctor->name}}</a>
                                                    @else
                                                        <a href="{{route('users.show', $appointment->user)}}" style="color:inherit;">{{$appointment->user->name}}</a>
                                                    @endif
                                                </td>
                                                <td title="{{ $appointment->description_preview }}">
                                                    <a href="{{ route('appointments.show', $appointment) }}" class="text-primary"> 
                                                        {{ $appointment->day }}
                                                    </a>
                                                </td>
                                                <td>{{ $appointment->statusTextOutput() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="bg-white p-4 text-center">
                                                    <div class="display-3"><i class="fa fa-calendar-alt"></i></div> 

                                                    <br>

                                                    <p><strong>0</strong> {{ request()->status }} appointments at this time.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="4" class="text-center py-3">{{ $appointments->appends(request()->query())->links() }}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                   </div>
                </div>

                <div class="tab-pane fade " id="v-pills-upcoming-appointments" role="tabpanel" aria-labelledby="v-pills-upcoming-appointments-tab">
                    <div class="card p-3">
                        <h5 class="card-title text-center">Upcoming Appointments
                            <small class="text-sm font-weight-bold text-info">(awaiting schedule time)</small>
                        </h5>

                        <div class="card-body">
                            <div class="table-responsive-md transaction-table">
                                <table class="table table-borderless">
                                    <thead >
                                        <tr>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Doctor</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($upcoming_appointments as $upcoming_appointment)
                                            <tr>                                                
                                                <td>{{ $upcoming_appointment->fee }}</td>
                                                <td>
                                                    @if($appointment->creator)
                                                        <a href="{{route('doctors.show', $upcoming_appointment->doctor)}}" style="color:inherit;">{{$upcoming_appointment->doctor->name}}</a>
                                                    @else
                                                        <a href="{{route('users.show', $upcoming_appointment->user)}}" style="color:inherit;">{{$upcoming_appointment->user->name}}</a>
                                                    @endif
                                                </td>
                                                <td title="{{ $upcoming_appointment->description_preview }}">
                                                    <a href="{{ route('appointments.show', $upcoming_appointment) }}" class="text-primary"> 
                                                        {{ $upcoming_appointment->day }}
                                                    </a>
                                                </td>
                                                <td>{{ $upcoming_appointment->statusTextOutput() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="bg-white p-4 text-center">
                                                    <div class="display-3"><i class="fa fa-calendar-plus"></i></div> 

                                                    <br>

                                                    <p><strong>0</strong> {{ request()->status }} appointments at this time.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="4" class="text-center py-3">{{ $upcoming_appointments->appends(request()->query())->links() }}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="tab-pane fade " id="v-pills-pending-appointments" role="tabpanel" aria-labelledby="v-pills-pending-appointments-tab">
                    <div class="card p-3">
                        <h5 class="card-title text-center">Pending Appointments
                            <small class="text-sm font-weight-bold text-warning">(not confirmed yet)</small>
                        </h5>

                        <div class="card-body">
                            <div class="table-responsive-md transaction-table">
                                <table class="table table-borderless">
                                    <thead >
                                        <tr>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Doctor</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($pending_appointments as $pending_appointment)
                                            <tr>                                                
                                                <td>{{ $pending_appointment->fee }}</td>
                                                <td>
                                                    @if($appointment->creator)
                                                        <a href="{{route('doctors.show', $pending_appointment->doctor)}}" style="color:inherit;">{{$pending_appointment->doctor->name}}</a>
                                                    @else
                                                        <a href="{{route('users.show', $pending_appointment->user)}}" style="color:inherit;">{{$pending_appointment->user->name}}</a>
                                                    @endif
                                                </td>
                                                <td title="{{ $pending_appointment->description_preview }}">
                                                    <a href="{{ route('appointments.show', $pending_appointment) }}" class="text-primary"> 
                                                        {{ $pending_appointment->day }}
                                                    </a>
                                                </td>
                                                <td>{{ $pending_appointment->statusTextOutput() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="bg-white p-4 text-center">
                                                    <div class="display-3"><i class="fa fa-calendar"></i></div> 

                                                    <br>

                                                    <p><strong>0</strong> {{ request()->status }} appointments at this time.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="4" class="text-center py-3">{{ $pending_appointments->appends(request()->query())->links() }}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div class="tab-pane fade " id="v-pills-past-appointments" role="tabpanel" aria-labelledby="v-pills-past-appointments-tab">
                    <div class="card p-3">
                        <h5 class="card-title text-center">Past Appointments
                            <small class="text-sm font-weight-bold text-success">(successful)</small>
                        </h5>

                        <div class="card-body">
                            <div class="table-responsive-md transaction-table">
                                <table class="table table-borderless">
                                    <thead >
                                        <tr>
                                            <th scope="col">Cost</th>
                                            <th scope="col">Doctor</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @forelse($past_appointments as $past_appointment)
                                            <tr>                                                
                                                <td>{{ $past_appointment->fee }}</td>
                                                <td>
                                                    @if($appointment->creator)
                                                        <a href="{{route('doctors.show', $past_appointment->doctor)}}" style="color:inherit;">{{$past_appointment->doctor->name}}</a>
                                                    @else
                                                        <a href="{{route('users.show', $past_appointment->user)}}" style="color:inherit;">{{$past_appointment->user->name}}</a>
                                                    @endif
                                                </td>
                                                <td title="{{ $past_appointment->description_preview }}">
                                                    <a href="{{ route('appointments.show', $past_appointment) }}" class="text-primary"> 
                                                        {{ $past_appointment->day }}
                                                    </a>
                                                </td>
                                                <td>{{ $past_appointment->statusTextOutput() }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4" class="bg-white p-4 text-center">
                                                    <div class="display-3"><i class="fa fa-calendar-check"></i></div> 

                                                    <br>

                                                    <p><strong>0</strong> {{ request()->status }} appointments at this time.</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="4" class="text-center py-3">{{ $past_appointments->appends(request()->query())->links() }}</td>
                                        </tr>
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
        
            </div>
        </div>
        
    </div>

@endsection
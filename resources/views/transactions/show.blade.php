@extends('layouts.master')

@section('title', Auth::user()->name .' Transaction '. $transaction->transaction_id)

@section('page-title', 'Transaction '. $transaction->transaction_id)

@section('content')


            <div class="card shadow-none">
                <div class="card-body pb-0">
                    <p class="text-center">
                        <kbd><i class="fa fa-clock"></i> Created: {{$transaction->created_at}}</kbd>
                    </p>

                    <h5 class="card-title tf-flex text-center pb-3 mb-3 border-bottom">
                        <span>
                            <span class="text-muted mb-2" style="font-size: 1rem;">Patient</span>
                            <br>

                            <img src="{{$transaction->user->avatar}}" height="55" alt="user avatar" class="rounded-circle">
                            <a href="{{route('users.show', $transaction->user)}}">{{$transaction->user->name}}</a>
                        </span>

                        {{-- @if (Auth::user()->is_admin) --}}
                        @unless ($transaction->status == '1')
                            <span>
                                @if ($transaction->status == '2')
                                <a href="{{route('mockedPayment', $transaction)}}" class="btn btn-sm btn-block btn-warning">
                                    Mock Payment Now
                                </a>
                                @endif
                                @if ($transaction->status == '3' && $transaction->appointment->within_booking_time_limit)
                                    <a href="{{route('mockedPayment', $transaction)}}" class="btn btn-sm btn-block btn-success">
                                        Retry Payment
                                    </a>
                                @endif
                            </span>
                        @endunless
                        {{-- @endif --}}

                        <span>
                            <span class="text-muted mb-2" style="font-size: 1rem;">Doctor <small>(${{$transaction->doctor->rate}})</small></span>
                            <br>

                            <img src="{{$transaction->doctor->avatar}}" height="55" alt="doctor avatar" class="rounded-circle">
                            <a href="{{route('doctors.show', $transaction->doctor)}}">{{$transaction->doctor->name}}</a>
                        </span>
                    </h5>

                    <div class="mb-3 border-bottom">
                        <h2>
                            <div class="tf-flex mb-3">
                                <span class="border p-2">
                                    <span class="text-muted" style="font-size: 1rem;">Amount:</span>
                                    <span class="text-bold">${{$transaction->appointment->fee}}</span>
                                </span>
                                <span class="border p-2">
                                    <span class="text-muted" style="font-size: 1rem;">Sessions:</span>
                                    <span class="text-bold">{{$transaction->appointment->no_of_sessions}}</span>
                                </span>

                                <span class="border p-2">
                                    <span class="text-muted" style="font-size: 1rem;">Duration:</span>
                                    <span class="text-bold">{{$transaction->appointment->duration}}</span>
                                </span>
                            </div>
                        </h2>
                    </div>

                    <div class="card-text pb-3">
                        <span class="text-muted">Description:&nbsp;</span>
                        {{$transaction->appointment->description}}
                    </div>

                    <blockquote class="blockquote">
                        <footer class="blockquote-footer">
                            <cite title="{{$transaction->appointment->schedule}}">
                                <i class="fa fa-stopwatch"></i>&nbsp; {{$transaction->appointment->schedule}}
                            </cite>, {{$transaction->appointment->day}}
                        </footer>
                    </blockquote>
                </div>
                <div class="card-footer text-bold text-white bg-{{$transaction->status_indicator}}">
                    <span class="text-muted text-sm">
                        Status:&nbsp;
                    </span>
                     
                    {{$transaction->status_text}}
                </div>
            </div> 

@endsection
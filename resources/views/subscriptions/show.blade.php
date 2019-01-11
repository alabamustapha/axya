@extends('layouts.master')

@section('title', Auth::user()->name .' Subscription '. $subscription->transaction_id)

@section('page-title', 'Subscription '. $subscription->transaction_id)

@section('content')

    <div class="card shadow-none">
        <div class="card-body pb-0">
            <p class="text-center">
                <kbd><i class="fa fa-clock"></i> Created: {{$subscription->created_at}}</kbd>
            </p>

            <h3 class="card-text pb-3">
                Doctor's subscription.
            </h3>

            <h5 class="card-title tf-flex text-center pb-3 mb-3 border-bottom">
                <span>
                    <span class="text-muted mb-2" style="font-size: 1rem;">Doctor</span>
                    <br>

                    <img src="{{$subscription->doctor->avatar}}" height="55" alt="user avatar" class="rounded-circle">
                    <a href="{{route('doctors.show', $subscription->doctor)}}">{{$subscription->doctor->name}}</a>
                </span>

                {{-- @if (Auth::user()->is_admin) --}}
                @unless ($subscription->status == '1')
                    <span>
                        @if ($subscription->status == '2')
                        <a href="{{route('mockedPayment', $subscription)}}" class="btn btn-sm btn-block btn-warning">
                            Mock Payment Now
                        </a>
                        @endif
                        @if ($subscription->status == '3')
                            <a href="{{route('mockedPayment', $subscription)}}" class="btn btn-sm btn-block btn-success">
                                Retry Payment
                            </a>
                        @endif
                    </span>
                @endunless
                {{-- @endif --}}
            </h5>

            <div class="mb-3 border-bottom">
                {{-- <h2>
                    <div class="tf-flex mb-3">
                        <span class="border p-2">
                            <span class="text-muted" style="font-size: 1rem;">Amount:</span>
                            <span class="text-bold">${{$subscription->amount}}</span>
                        </span>
                        <span class="border p-2">
                            <span class="text-muted" style="font-size: 1rem;">Sessions:</span>
                            <span class="text-bold">{{$subscription->appointment->no_of_sessions}}</span>
                        </span>

                        <span class="border p-2">
                            <span class="text-muted" style="font-size: 1rem;">Duration:</span>
                            <span class="text-bold">{{$subscription->appointment->duration}}</span>
                        </span>
                    </div>
                </h2> --}}
                
    <div class="table-responsive">
        <table class="table border">
            <tr>
                <td colspan="2"><kbd class="bg-info"><a href="{{route('subscriptions.show', $subscription)}}" class="card-link"><i class="fa fa-eye"></i> View Subscription</a></kbd></td>
                <td></td>
                <td colspan="2"><kbd><i class="fa fa-clock"></i> Created: {{$subscription->created_at}}</kbd></td>
            </tr>

            <tr>
                <td title="View {{$subscription->doctor->name}}'s subscription payments" data-toggle="tooltip">
                    <span class="border p-1">
                        <img src="{{$subscription->doctor->avatar}}" height="45" alt="doctor avatar" class="rounded-circle">
                        <a href="{{route('subscriptions.index', $subscription->doctor)}}">
                            {{$subscription->doctor->name}}&nbsp;
                            <span class="text-muted mb-2 text-sm">Doctor</span>
                        </a> 
                    </span>
                </td>
                <td>
                    <span class="border px-4 text-center">
                        <span class="text-muted" style="font-size: .5rem;">Amount:</span> <br>
                        <span class="text-bold">${{$subscription->amount}}</span>
                    </span>
                </td>
                <td>
                    <span class="border px-4 text-center">
                        <span class="text-muted" style="font-size: .5rem;">Type:</span> <br>
                        <span class="text-bold">{{$subscription->type_text}}</span>
                    </span>
                </td>
                <td>
                    <span class="border px-4 text-center">
                        <span class="text-muted" style="font-size: .5rem;">Multiples:</span> <br>
                        <span class="text-bold">{{$subscription->multiple}}</span>
                    </span>
                </td>
                <td>
                    <span class="border px-4 text-center">
                        <span class="text-muted" style="font-size: .5rem;">End Date:</span> <br>
                        <span class="text-bold">{{$subscription->end}}</span>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="card-footer text-bold text-white bg-{{$subscription->status_indicator}}">
                    <span class="text-muted text-sm">
                        Status:&nbsp;
                    </span>
                     
                    {{$subscription->status_text}}
                </td>
            </tr>
        </table>
    </div>
            </div>

            <blockquote class="blockquote">
                <footer class="blockquote-footer">                            
                    <i class="fa fa-stopwatch"></i>&nbsp; 

                    @if ($subscription->doctor->is_subscribed)
                        <span class="text-warning">
                            Current subscription expires by: <strong>{{$subscription->doctor->subscription_ends_at->format('D M d, Y')}}</strong>
                        </span>
                    @else
                        <span class="text-danger">No subscription at this time.</span>
                    @endif
                </footer>
            </blockquote>
        </div>
        <div class="card-footer text-bold text-white bg-{{$subscription->status_indicator}}">
            <span class="text-muted text-sm">
                Status:&nbsp;
            </span>
             
            {{$subscription->status_text}}
        </div>
    </div> 

@endsection
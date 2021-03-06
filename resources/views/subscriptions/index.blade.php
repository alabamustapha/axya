@extends('layouts.master')

@section('title', $user->name .' - Subscriptions Dashboard')

@section('page-title', 'Subscriptions by '. $user->name)

@section('content')

    @forelse($subscriptions as $subscription)
        <div class="mb-5">
            <div class="table-responsive">
                <table class="table border">
                    <tr>
                        <td><kbd class="bg-info"><a href="{{route('subscriptions.show', $subscription)}}" class="card-link"><i class="fa fa-eye"></i> View Subscription</a></kbd></td>
                        <td colspan="2">Doctor's subscription.</td>
                        <td colspan="2"><kbd><i class="fa fa-clock"></i> Created: {{$subscription->created_at}}</kbd></td>
                    </tr>

                    <tr>
                        <td>
                            <span class="border p-1 text-sm tf-flex">
                                <span title="View subscription payments" data-toggle="tooltip">
                                    <img src="{{$subscription->doctor->avatar}}" height="45" alt="doctor avatar" class="rounded-circle">
                                    <a href="{{route('subscriptions.index', $subscription->doctor)}}">
                                        {{$subscription->doctor->name}}&nbsp;
                                    </a>
                                </span> 
                                <a href="{{route('doctors.show', $subscription->doctor)}}" class="text-bold" title="View profile" data-toggle="tooltip">
                                    Profile
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
                                <span class="text-bold">{{$subscription->subscriptionPlan->name}}</span>
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
                        <td colspan="5">
                            <blockquote class="blockquote">
                                <footer class="blockquote-footer">                            
                                    <i class="fa fa-stopwatch"></i>&nbsp; 

                                    @if ($subscription->doctor->is_subscribed)
                                        <span>
                                            Current subscription expires by: 
                                            <strong class="text-warning">
                                                {{$subscription->doctor->subscription_ends_at->format('D M d, Y')}}
                                            </strong>
                                        </span>
                                    @else
                                        <span class="text-danger">No subscription at this time.</span>
                                    @endif
                                </footer>
                            </blockquote>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="5" class="card-footer text-bold text-white bg-{{$subscription->status_indicator}}">
                            <span class="tf-flex">
                                <span>
                                    <span class="text-light text-sm">
                                        Status:&nbsp;
                                    </span>
                                     
                                    {{$subscription->status_text}}
                                </span>

                                {{-- @if ($subscription->user) --}}
                                @unless ($subscription->status == '1')
                                    <span>
                                        @if ($subscription->status == '2')
                                        <a href="{{route('mockedPayment', $subscription)}}" class="btn btn-sm btn-block btn-secondary">
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
                            </span>
                        </td>
                    </tr>
                </table>
            </div>

        </div>
    @empty
        <div class="text-center">
            <div class="display-3"><i class="fa fa-rss"></i></div> 

            <br>

            <p>You have <strong>0</strong> subscriptions at this time.</p>
        </div>
    @endforelse
    
    <div class="text-center py-3">{{ $subscriptions->appends(request()->query())->links() }}</div>

@endsection
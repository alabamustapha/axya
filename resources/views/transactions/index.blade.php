@extends('layouts.master')

@section('title', $user->name .' - Transactions Dashboard')

@section('page-title', 'Transaction Dashboard for '. $user->name)

@section('content')

    @forelse($transactions as $transaction)
        <div class="card shadow-none mb-4">
            <div class="card-body pb-0">
                <p class="tf-flex">
                    <kbd><i class="fa fa-clock"></i> Created: {{$transaction->created_at}}</kbd>

                    <kbd class="bg-info"><a href="{{route('transactions.show', $transaction)}}" class="card-link"><i class="fa fa-eye"></i> View Transaction</a></kbd>
                </p>

                <h5 class="card-title tf-flex text-center pb-3 mb-3 border-bottom">
                    <span>
                        <span class="text-muted mb-2" style="font-size: 1rem;">Patient</span>
                        <br>

                        <img src="{{$transaction->user->avatar}}" height="45" alt="user avatar" class="rounded-circle">
                        <a href="{{route('users.show', $transaction->user)}}">{{$transaction->user->name}}</a>
                    </span>
                    <span>
                        <span class="text-muted mb-2" style="font-size: 1rem;">Doctor <small>(${{$transaction->doctor->rate}})</small></span>
                        <br>

                        <img src="{{$transaction->doctor->avatar}}" height="45" alt="doctor avatar" class="rounded-circle">
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
                        <cite title="{{$transaction->appointment->schedule}}">{{$transaction->appointment->schedule}}</cite>, {{$transaction->appointment->day}}
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
    @empty
        
        <div class="col empty-list">No transactions at this time</div>

    @endforelse
    
    <div class="text-center py-3">{{ $transactions->appends(request()->query())->links() }}</div>

@endsection
@extends('layouts.master')

@section('title', 'Admin Transactions Dashboard')

@section('page-title', 'Admin Transactions Dashboard')

@section('content')

    @forelse($transactions as $transaction)
    <div class="table-responsive">
        <table class="table border">
            <tr>
                <td colspan="2"><kbd class="bg-info"><a href="{{route('transactions.show', $transaction)}}" class="card-link"><i class="fa fa-eye"></i> View Transaction</a></kbd></td>
                <td></td>
                <td colspan="2"><kbd><i class="fa fa-clock"></i> Created: {{$transaction->created_at}}</kbd></td>
            </tr>

            <tr>
                <td title="View {{$transaction->user->name}}'s fee payment transactions" data-toggle="tooltip">
                    <span class="border p-1">
                        <img src="{{$transaction->user->avatar}}" height="45" alt="user avatar" class="rounded-circle">
                        <a href="{{route('transactions.index', $transaction->user)}}">
                            {{$transaction->user->name}}&nbsp;
                            <span class="text-muted mb-2 text-sm">Patient</span>
                        </a> 
                    </span>
                </td>
                <td title="View {{$transaction->doctor->name}}'s client transactions" data-toggle="tooltip">
                    <span class="border p-1">
                        <img src="{{$transaction->doctor->avatar}}" height="45" alt="doctor avatar" class="rounded-circle">
                        <a href="{{route('dr_transactions', $transaction->doctor)}}">
                            {{$transaction->doctor->name}} &nbsp;
                            <span class="text-muted mb-2 text-sm">Doctor <small>(${{$transaction->doctor->rate}})</small></span>
                        </a>
                    </span>
                </td>
                <td>
                    <span class="border px-4 text-center">
                        <span class="text-muted" style="font-size: .5rem;">Amount:</span> <br>
                        <span class="text-bold">${{$transaction->appointment->fee}}</span>
                    </span>
                </td>
                <td>
                    <span class="border px-4 text-center">
                        <span class="text-muted" style="font-size: .5rem;">Sessions:</span> <br>
                        <span class="text-bold">{{$transaction->appointment->no_of_sessions}}</span>
                    </span>
                </td>
                <td>
                    <span class="border px-4 text-center">
                        <span class="text-muted" style="font-size: .5rem;">Duration:</span> <br>
                        <span class="text-bold">{{$transaction->appointment->duration}}</span>
                    </span>
                </td>
            </tr>
            <tr>
                <td colspan="5" class="card-footer text-bold text-white bg-{{$transaction->status_indicator}}">
                    <span class="text-muted text-sm">
                        Status:&nbsp;
                    </span>
                     
                    {{$transaction->status_text}}
                </td>
            </tr>
        </table>
    </div>
        {{-- <div class="card shadow-none mb-4">
            <div class="card-body pb-0">
                <p class="tf-flex">
                    <kbd class="bg-info"><a href="{{route('transactions.show', $transaction)}}" class="card-link"><i class="fa fa-eye"></i> View Transaction</a></kbd>

                    <kbd><i class="fa fa-clock"></i> Created: {{$transaction->created_at}}</kbd>
                </p>

                <h5 class="card-title tf-flex text-center border-bottom">
                    <span>
                        <span class="text-muted mb-2 text-sm">Patient</span>
                        <br>

                        <img src="{{$transaction->user->avatar}}" height="45" alt="user avatar" class="rounded-circle">
                        <a href="{{route('users.show', $transaction->user)}}">{{$transaction->user->name}}</a>
                    </span>
                    <span>
                        <span class="text-muted mb-2 text-sm">Doctor <small>(${{$transaction->doctor->rate}})</small></span>
                        <br>

                        <img src="{{$transaction->doctor->avatar}}" height="45" alt="doctor avatar" class="rounded-circle">
                        <a href="{{route('doctors.show', $transaction->doctor)}}">{{$transaction->doctor->name}}</a>
                    </span>
                </h5>

                <div class="mb-3">
                    <h2>
                        <div class="tf-flex mb-3">
                            <span class="border p-1">
                                <span class="text-muted" style="font-size: .5rem;">Amount:</span>
                                <span class="text-bold">${{$transaction->appointment->fee}}</span>
                            </span>
                            <span class="border p-1">
                                <span class="text-muted" style="font-size: .5rem;">Sessions:</span>
                                <span class="text-bold">{{$transaction->appointment->no_of_sessions}}</span>
                            </span>

                            <span class="border p-1">
                                <span class="text-muted" style="font-size: .5rem;">Duration:</span>
                                <span class="text-bold">{{$transaction->appointment->duration}}</span>
                            </span>
                        </div>
                    </h2>
                </div>

            </div>
            <div class="card-footer text-bold text-white bg-{{$transaction->status_indicator}}">
                <span class="text-muted text-sm">
                    Status:&nbsp;
                </span>
                 
                {{$transaction->status_text}}
            </div>
        </div>  --}}
    @empty
        
        <div class="col empty-list">No transactions at this time</div>

    @endforelse
    
    <div class="text-center py-3">{{ $transactions->appends(request()->query())->links() }}</div>

@endsection
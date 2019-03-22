<div class="transaction-body">

    @if (\Route::input('doctor.slug'))
    <div class="px-4 pt-4 pb-0 mb-4 bg-light border-bottom tf-flex">
        <div>
            <span class="h5 card-title">Earnings</span>
        </div>

        <div>
            <p class="text-right text-theme-blue font-weight-bold">
                Current Balance: 
                <span class="current-earned h2 text-muted">
                    <small class="text-sm">{{ setting('base_currency') }}</small>{{ $doctor->current_balance }}
                </span>
            </p>
            <p class="text-right font-weight-bold">
                Total Earned: 
                <span class="total-earning h3 text-muted">
                    <small class="text-sm">{{ setting('base_currency') }}</small>{{ $doctor->total_earning }}
                </span>
            </p>
        </div>
    </div>
    @endif

    <div class="table-responsive-md transaction-table">
        <table class="table table-borderless">
            <thead >
                <tr>
                    <th scope="col">Duration</th>
                    <th scope="col">Cost</th>
                    <th scope="col">Paid {{ \Route::input('doctor.slug') ? 'by':'to' }}</th>
                    <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $transaction)
                    <tr title="{{$transaction->appointment->description}}">
                        
                        <td>{{ $transaction->appointment->duration }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>
                            <span>
                                @if (\Route::input('doctor.slug'))
                                    <img src="{{$transaction->user->avatar}}" height="25" alt="user avatar" class="rounded-circle">
                                    <a href="{{route('users.show', $transaction->user)}}">{{$transaction->user->name}}</a>
                                @else
                                    <img src="{{$transaction->doctor->avatar}}" height="25" alt="doctor avatar" class="rounded-circle">
                                    <a href="{{route('doctors.show', $transaction->doctor)}}">{{$transaction->doctor->name}}</a>
                                @endif
                            </span>
                        </td>
                        <td>{{ $transaction->confirmed_at ?:'--' }}</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div class="border-bottom border-warning mb-2 pb-1">
                                <table cols="{{ \Route::input('doctor.slug') ? 3:2 }}" cellspacing="0" cellpadding="0" class="w-100">
                                    <tbody>
                                        <tr>
                                            @if (\Route::input('doctor.slug'))
                                            <td class="bg-info" title="Transactionn ID">
                                                <span class="text-bold">Earned:&nbsp;</span>
                                                <kbd>
                                                    {{ setting('base_currency') }} {{ $transaction->doctor_earning }}
                                                </kbd>
                                            </td>
                                            @endif
                                            <td class="bg-info" title="Transactionn ID">
                                                <span class="text-bold">ID:&nbsp;</span>
                                                <kbd>
                                                    <a href="{{route('transactions.show', [$transaction->user, $transaction])}}" class="card-link">
                                                        <i class="fa fa-eye"></i> {{ $transaction->transaction_id }}
                                                    </a>
                                                </kbd>
                                            </td>
                                            <td class="text-bold text-white bg-{{$transaction->status_indicator}}">
                                                <span class="text-muted text-sm">Status:&nbsp;</span>
                                                {{ $transaction->status_text }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            <div class="display-1"><i class="fa fa-handshake"></i></div> 

                            <br>

                            <p>You have <strong>0</strong> transactions at this time.</p>
                        </td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="4" class="text-center py-3">{{ $transactions->links() }}</td>
                </tr>
                
            </tbody>
        </table>
    </div>
</div>
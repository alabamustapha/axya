
<div class="transaction-body">
    <div class="transaction-body">
        <div class="px-4 pt-4 pb-0 mb-4 bg-light border-bottom tf-flex">
            <div>
                <span class="h5 card-title">Payout History</span>
            </div>

            <div>
                <p class="text-right text-theme-blue font-weight-bold">
                    Current Balance: <span class="current-earned">{{ $doctor->currentBalance() }}</span>
                </p>
            </div>
        </div>
       
        <div class="table-responsive-md transaction-table">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Account</th>
                        <th scope="col">Transaction ID</th>
    
                    </tr>
                </thead>
                <tbody>
                    @forelse($payouts as $payout)
                        <tr class="text-sm">
                            <td class="{{ $payout->status_indicator }}">{{ $payout->status_text }}</td>
                            <td>{{ $payout->confirmed_at }}</td>
                            <td>
                                <small class="text-sm text-muted">{{ setting('base_currency') }}</small>{{ $payout->amount }}
                            </td>
                            <td title="{{ $payout->bankAccount->name }}">{{ $payout->bankAccount->account_number }}</td>
                            <td>{{ $payout->transaction_id }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="display-1"><i class="fa fa-handshake"></i></div> 

                                <br>

                                <p>You have <strong>0</strong> payouts at this time.</p>
                            </td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="4" class="text-center py-3">{{ $payouts->links() }}</td>
                    </tr> 
    
                </tbody>
            </table>
        </div>
    
    </div>
</div>
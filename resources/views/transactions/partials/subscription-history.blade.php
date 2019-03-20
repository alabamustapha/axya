
<div class="transaction-body card">
    <div class="px-4 pt-4 pb-0 mb-4 bg-light border-bottom tf-flex">
        <div>
            <span class="h5 card-title">Subscription History</span>
        </div>

        <div>
            <p class="text-right text-theme-blue font-weight-bold">
                Current Subscription: <span class="subscription-type">{{ $latestSubscription->subscriptionPlan->name }}</span>
            </p>
            <p class="text-right font-weight-bold">
                End{{ $latestSubscription->isActive() ? 's':'ed'}} on: 
                <span class="subscription-exp">
                    <span class="{{ $latestSubscription->isActive() ? 'text-success':'text-danger' }}">{{ $latestSubscription->end->format('D d M, Y') }}</span>
                </span>
            </p>
        </div>
    </div>

    <div class="table-responsive-md transaction-table">
        <table class="table table-borderless text-center">
            <thead>
                <tr>
                    <th scope="col">view</th>
                    <th scope="col">subscription</th>
                    <th scope="col">start date</th>
                    <th scope="col">end date</th>
                    <th scope="col">amount</th>
                  
                </tr>
            </thead>
            <tbody>
                @forelse($subscriptions as $subscription)
                    <tr>
                        <td>
                            <a href="{{route('subscriptions.show', $subscription)}}" class="card-link"><i class="fa fa-eye"></i></a>
                        </td>
                        <td>
                            {{ $subscription->subscriptionPlan->name }}
                        </td>
                        <td>
                            {{ $subscription->start->format('D d M, Y') }}
                        </td>
                        <td class="{{ $latestSubscription->isActive() ? 'text-success':'text-danger' }}">
                            {{ $subscription->end->format('D d M, Y') }}
                        </td>
                        <td>
                            <small class="text-sm">{{ setting('base_currency') }}</small>
                            <span>{{ $subscription->amount }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            <div class="display-1"><i class="fa fa-rss"></i></div> 

                            <br>

                            <p>You have <strong>0</strong> subscriptions at this time.</p>
                        </td>
                    </tr>
                @endforelse
                <tr>
                    <td colspan="4" class="text-center py-3">{{ $subscriptions->links() }}</td>
                </tr>               

            </tbody>
        </table>
    </div>
</div>
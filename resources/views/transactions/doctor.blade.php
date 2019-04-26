@extends('layouts.doctor')

@section('title', $doctor->name .' - Doctors Transaction Dashboard')

@section('page-title', 'Transaction Dashboard - Doctor')

@section('content')

    <div class="row">
        
        <div class="col-md-3">
            <div class="card transaction-menu " >
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" title="Appointment Fees">
                            <a class="nav-link active" id="v-pills-earnings-tab" data-toggle="pill" href="#v-pills-earnings" role="tab"
                            aria-controls="v-pills-home" aria-selected="true">Earnings</a>
                        </li>

                        <li class="list-group-item">
                            <a class="nav-link" id="v-pills-payout-history-tab" data-toggle="pill" href="#v-pills-payout-history" role="tab"
                            aria-controls="v-pills-home" aria-selected="false">Payout History</a>
                        </li>

                        <li class="list-group-item">
                            <a class="nav-link" id="v-pills-subscription-history-tab" data-toggle="pill" href="#v-pills-subscription-history" role="tab"
                            aria-controls="v-pills-home" aria-selected="false">Subscriptions</a>
                        </li>

                        <li class="list-group-item">
                            <a class="nav-link" id="v-pills-pay-method-tab" data-toggle="pill" href="#v-pills-pay-method" role="tab"
                            aria-controls="v-pills-home" aria-selected="false">Payment Method</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-earnings" role="tabpanel" aria-labelledby="v-pills-earnings-tab">

                    @include('transactions.partials.payment-history')

                </div>

                <div class="tab-pane fade show" id="v-pills-payout-history" role="tabpanel" aria-labelledby="v-pills-payout-history-tab">

                    @include('transactions.partials.payout-history')

                </div>

                <div class="tab-pane fade show" id="v-pills-subscription-history" role="tabpanel" aria-labelledby="v-pills-subscription-history-tab">

                    @include('transactions.partials.subscription-history')

                </div>

                <div class="tab-pane fade" id="v-pills-pay-method" role="tabpanel" aria-labelledby="v-pills-pay-method-tab">

                    @include('transactions.partials.payment-method')
                
                   
                </div>
        
            </div>
        </div>

        
    </div>
    
@endsection
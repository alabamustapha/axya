<div class="text-center">
    <div class="mb-3">
        <h2>{{title_case('Subscription Form')}}</h2>
    </div>

    <form action="{{route('subscriptions.store')}}" method="post">
        <div class="card shadow-none">
            <div class="card-body pb-0">
                <div class="card-text">
                    <div class="form-group">
                        <label for="type">Subscription Type</label>
                        <select name="type" id="type" class="form-control" required>
                            <option>Select Type</option>
                            <option value="1">Weekly</option>
                            <option value="2">Monthly</option>
                            <option value="3">Yearly</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="multiple">Multiples</label>
                        <input type="number" name="multiple" min="1" value="1" id="multiple" class="form-control text-center" required>
                    </div>

                    <div id="selection" class="pb-3 mb-3 border-bottom" style="display: none;">
                        <div class="tf-flex">
                            <span class="text-secondary">Selection: </span>
                            <span>
                                <span id="sel_multiple"class="text-dark text-bold"></span><span id="sel_type" class="text-muted text-sm"></span>
                            </span>
                        </div>
                        <div class="tf-flex">
                            <span class="text-secondary">Total Amount: </span>
                            <span>
                                $<span id="amount" class="text-dark text-bold"></span>
                                <br>
                                <span class="text-sm">
                                    $<span id="discounted" class="text-dark"></span>&nbsp;
                                    <span class="text-muted">saved!</span>
                                </span>
                            </span>
                        </div>
                    </div>
                </div>

                <blockquote class="blockquote">
                    <footer class="blockquote-footer">
                        @if (Auth::check() && Auth::user()->is_doctor && Auth::user()->doctor->is_subscribed)
                            Your current subscription expires by: <strong>{{Auth::user()->doctor->subscription_ends_at->format('D M d, Y')}}</strong>
                            <br>
                        @endif
                        You can only attend to patients and receive appointments with an active subscription. 
                    </footer>
                </blockquote>
            </div>
        </div>

        @csrf
        {{-- <input type="hidden" name="doctor_id" value="{{$doctor->id}}"> --}}
        <button type="submit" class="btn btn-lg btn-block btn-info" onclick="return confirm('Go ahead and make payment for a new subscription?');">
            @if (Auth::check() && Auth::user()->is_doctor && Auth::user()->doctor->is_subscribed)
                Extend Current Subscription?
            @else
                Subscribe Now
            @endif
        </button>
        <input type="hidden" name="w_rate" value="{{--md5($app->subscription_weekly_rate)--}}">
        <input type="hidden" name="m_rate" value="{{--md5($app->subscription_monthly_rate)--}}">
        <input type="hidden" name="y_rate" value="{{--md5($app->subscription_yearly_rate)--}}">
    </form>
</div>
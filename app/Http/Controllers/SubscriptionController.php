<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\Appointment;
use App\Subscription;
use Illuminate\Http\Request;
use App\Notifications\Subscriptions\SubscriptionFailedNotification;
use App\Notifications\Subscriptions\SubscriptionSuccessfulNotification;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('doctoradmin')->only('index','show');
        $this->middleware('admin')->only('admindex');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->authorize('index', Subscription::class); 

        $subscriptions = Subscription::where('doctor_id', $user->id)
                                    ->latest()
                                    ->paginate(15);
        return view('subscriptions.index', compact('user','subscriptions'));
    }

    public function admindex()
    {
        // Display/Group by Date...
        $subscriptions = Subscription::latest()
                                    ->paginate(15);
        return view('subscriptions.admin', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Subscription::class);

        $request->validate([
            'type'     => 'required|integer|in:1,2,3',//|exists:subscription_categories,id',
            'multiple' => 'required|integer',
        ],[
            'type.integer' => '',
            'type.in' => 'The selected subscription type is invalid.',
        ]);

        $transactionId = strtoupper('SUB'. date('Ymd') .'-'. str_random(18));
        $app_weekly_rate      = 100;
        $app_monthly_discount = 5; //5% Got from admin setting.
        $app_yearly_discount  = 8; //8% Got from admin setting. Cost higher for yearly discount...Ratify soon
        $monthly_discount     = ($app_monthly_discount / 100); // = 0.05;
        $yearly_discount      = ($app_yearly_discount / 100);  // = 0.08;

        $typeWeeksCount = $request->type == '3' ?  48 : ($request->type == '2' ?  4 : 1); // Discount+Fee Calculation (Adjusted: 48wks from 52wks based on discounting descrepancies).
        $typeDaysCount  = $request->type == '3' ? 365 : ($request->type == '2' ? 30 : 7); // Sub start+End date Calculation.
        $typeDiscount   = $request->type == '3' ? $yearly_discount : ($request->type == '2' ? $monthly_discount : 0.0); // Yearly 8%, Monthly 5%, Weekly 0%.
        
        // Get a unit Discount for a type
        $discount       =  $app_weekly_rate * $typeWeeksCount * $typeDiscount;
        $typeFee        = ($app_weekly_rate * $typeWeeksCount) - $discount;

        // Get total Fee for present subscription by multiplying the multiple.
        $subscriptionAmount = $typeFee * $request->multiple;
        $noOfDays       = $typeDaysCount * $request->multiple; // No of days subscription will last.
        // dd(
        //     'transactionId     : '. $transactionId,
        //     'request->type     : '. $request->type,
        //     'request->multiple : '. $request->multiple,
        //     'typeDaysCount     : '. $typeDaysCount,
        //     'typeDiscount      : '. $typeDiscount,  

        //     'discount          : '. $discount,
        //     'Base Fee          : '. $app_weekly_rate,
        //     'Base Type Fee     : '. $app_weekly_rate * $typeWeeksCount,
        //     'typeFee           : '. $typeFee,
        //     'subscriptionAmount: '. $subscriptionAmount,
        //     'noOfDays          : '. $noOfDays
        // );

        $request->merge([
            'user_id'       => auth()->id(),
            'doctor_id'     => auth()->id(),

            'type'          => $request->type,    // For future reference.
            'multiple'      => $request->multiple,// For future reference.
            'days'          => $noOfDays, // Used internally to adjust Subscription Start and End dates.

            'amount'        => $subscriptionAmount,
            'transaction_id'=> $transactionId,

            'status'        => '2',
        ]);
        
        $subscription = Subscription::create($request->all());

        $this->mockedPayment($subscription);

        if ($subscription) {
            $msg = 'Subscription created successfully.';

            // flash($msg)->success();

            if (request()->expectsJson()) {
                return response(['status' => $msg]);
            }
        }

        // return redirect()->route('doctors.show', $subscription->doctor);
        return redirect()->route('subscriptions.show', $subscription);
    }

    public function mockedPayment(Subscription $subscription)
    {
        $response = array_rand(['success' => 1,'failed' => 0]);
        // dd($response);
        // $response      = $response_from_pymt_processor;

        if ($response == 'success'){
            $doctor = $subscription->doctor;
            $subscription_end = Carbon::parse($doctor->adjusted_subscription_end)
                                        ->addDays($subscription->days)
                                        ;

            $subscription->update([
                'start'        => $doctor->adjusted_subscription_end,
                'end'          => $subscription_end,
                'status'       => '1',
                'confirmed_at' => Carbon::now(),
                // 'currency'      => ,
                // 'channel'       => ,
                // 'processor_id'  => ,
                // 'processor_trxn_id' => ,
            ]);
            
            $doctor->update([
                'available' => '1',
                'subscription_ends_at' => $subscription_end,
            ]); 
            
            $subscription->user->update([
                'application_status' => '1',
            ]); 

            // Notify concerned parties of success.
            $subscription->user->notify(new SubscriptionSuccessfulNotification($subscription->user, $subscription));
            // $admin->notify(new SubscriptionSuccessfulNotification($admin->user, $subscription));
            
            flash('Subscription transaction was successful.')->success(); 

            return redirect()->route('subscriptions.show', $subscription);
        }
        else {
            // No need to change status on appointment model, status quo maintained.
            $subscription->update(['status' => '3']);

            // Notify doctor of failure. 
            $subscription->user->notify(new SubscriptionFailedNotification($subscription->user, $subscription));

            flash('Subscription transaction was not successful, try again')->error();

            return redirect()->route('subscriptions.show', $subscription);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function show(Subscription $subscription)
    {
        $this->authorize('view', $subscription);
        
        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function edit(Subscription $subscription)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subscription $subscription)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subscription  $subscription
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subscription $subscription)
    {
        //
    }
}

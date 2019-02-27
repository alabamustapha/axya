<?php

namespace App\Http\Controllers;

use App\Doctor;
use App\Http\Requests\SubscriptionPlanRequest;
use App\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
        $this->middleware('admin')->except('index');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $subscriptionPlans = SubscriptionPlan::orderBy('name')->get();

        return view('subscription_plans.index', compact('subscriptionPlans'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionPlanRequest $request)
    {
        $this->authorize('create', SubscriptionPlan::class);
        
        $subscriptionPlan = SubscriptionPlan::create($request->all());

        if ($subscriptionPlan){
            flash($subscriptionPlan->name . ' created successfully')->success();
        }

        return redirect()->route('subscription_plans.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubscriptionPlan  $subscriptionPlan
     * @return \Illuminate\Http\Response
     */
    public function show(SubscriptionPlan $subscriptionPlan)
    {
        $doctors = collect();//Doctor::where('subscriptionPlan_id', $subscriptionPlan->id)->get();

        return view('subscription_plans.show', compact('subscriptionPlan', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubscriptionPlan  $subscriptionPlan
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriptionPlanRequest $request, SubscriptionPlan $subscriptionPlan)
    {
        $this->authorize('update', $subscriptionPlan);

        if ($subscriptionPlan->update($request->all())){
            flash($subscriptionPlan->name . ' updated successfully')->success();
        }

        return redirect()->route('subscription_plans.show', $subscriptionPlan);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubscriptionPlan  $subscriptionPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $this->authorize('delete', $subscriptionPlan);

        if ($subscriptionPlan->delete()){
            flash($subscriptionPlan->name . ' deleted successfully')->info();
        }

        return redirect()->route('subscription_plans.index');
    }
}

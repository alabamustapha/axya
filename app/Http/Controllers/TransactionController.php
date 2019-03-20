<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Doctor;
use App\Notifications\Transactions\TransactionFailedNotification;
use App\Notifications\Transactions\TransactionSuccessfulNotification;
use App\Subscription;
use App\Transaction;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('patient')->only('index','drindex','show');
        $this->middleware('admin')->only('admindex');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $transactions = Transaction::where('user_id', $user->id)
                                    ->latest()
                                    ->paginate(25);
        return view('transactions.index', compact('user','transactions'));
    }

    public function drindex(Doctor $doctor)
    {
        // $this->authorize('doctor permitted?', Transaction::class);

        $transactions = Transaction::where('doctor_id', $doctor->id)
                                    ->latest()
                                    ->paginate(25);

        $subscriptions = Subscription::with(['doctor', 'subscriptionPlan'])
                                    ->where('doctor_id', $doctor->id)
                                    ->where('status', '1')
                                    ->latest()
                                    ->paginate(25);
        $latestSubscription = Subscription::with(['doctor', 'subscriptionPlan'])
                                    ->where('doctor_id', $doctor->id)
                                    ->where('status', '1')
                                    ->latest()
                                    ->first()
                                    ;
        return view('transactions.doctor', compact('doctor','transactions','subscriptions','latestSubscription'));
    }

    public function admindex()
    {
        $successful_transactions_count = Transaction::completed()->count();

        // Display/Group by Date...
        $transactions = Transaction::latest()
                                    ->paginate(15);
        return view('transactions.admin', compact('transactions','successful_transactions_count'));
        // return view('admin.dashboard.transactions', compact('transactions','successful_transactions_count'));
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
    public function store(Request $request, User $user)
    {
        $this->authorize('create', Transaction::class);

        $request->validate(['appointment_id' => 'required|integer|exists:appointments,id']);

        $appointment = Appointment::find($request->appointment_id);

        $transactionExists = 
            Transaction::where('user_id', auth()->id())
                ->where('doctor_id', $appointment->doctor_id)
                ->where('appointment_id', $appointment->id)
                ->where('amount', $appointment->fee)
                ->where('status', '1')
                // ->exists()
                ->first()
                ;
        if ($transactionExists){            
            flash('This payment was made successfully sometimes ago with a transaction ID of: <a class="font-weight-bold" href="' . $transactionExists->link . '">' . $transactionExists->transaction_id . '</a>')->important()->info(); 

            return redirect()->route('transactions.index', $transactionExists->user);
        }

        $adminCut        = setting('fee_commission') / 100; // 15% = 0.15
        $doctorEarning   = $appointment->fee * (1 - $adminCut);
        $platformEarning = $appointment->fee - $doctorEarning;

        $request->merge([
            'user_id'       => auth()->id(),
            'doctor_id'     => $appointment->doctor_id,
            'appointment_id'=> $appointment->id,
            'amount'        => $appointment->fee,
            'transaction_id'=> $appointment->makeTransactionId(),
            'status'        => '2',
            'currency'      => setting('base_currency'),
            'doctor_earning'   => $doctorEarning,
            'platform_earning' => $platformEarning,

            // 'channel'       => ,
            // 'processor_id'  => ,
            // 'processor_trxn_id' => ,
        ]);
        
        $transaction = Transaction::create($request->all());

        // return redirect()->route('mobilpay_pay', ['model'=> $transaction]);
        $this->mockedPayment($transaction);

        // if ($transaction) {
        //     $msg = 'Transaction created successfully.';

        //     flash($msg)->success();

        //     if (request()->expectsJson()) {
        //         return response(['status' => $msg]);
        //     }
        // }

        // return redirect()->route('appointments.show', $transaction->appointment);
    }

    public function mockedPayment(Transaction $transaction)
    {
        $response = 'success';//array_rand(['success' => 1,'failed' => 0]);
        // dd($response);
        // $response = $response_from_pymt_processor;

        if ($response == 'success'){
            $transaction->update([
                'status' => '1',
                'confirmed_at' => Carbon::now(),
            ]);
            
            // Update status to '5'.
            $transaction->appointment->activateFeePayment(); 
            
            // Add this to event.
            $transaction->user
                        ->calendar_events()
                        ->create(\App\CalendarEvent::patientAppointmentEventData($transaction))
                        ;
            $transaction->doctor->user
                        ->calendar_events()
                        ->create(\App\CalendarEvent::doctorAppointmentEventData($transaction))
                        ;

            // Notify concerned parties of success.
            $transaction->user->notify(new TransactionSuccessfulNotification($transaction->user, $transaction));
            $transaction->doctor->user->notify(new TransactionSuccessfulNotification($transaction->doctor->user, $transaction));
            
            flash('Payment was successful, notification has been sent to the attending doctor.')->success(); 

            return redirect()->route('transactions.index', $transaction->user);
        }
        else {
            // No need to change status on appointment model, status quo maintained.
            $transaction->update(['status' => '3']);

            // Notify patient of failure. 
            $transaction->user->notify(new TransactionFailedNotification($transaction->user, $transaction));

            flash('Payment was not successful, try again')->error();

            return redirect()->route('transactions.index', $transaction->user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Transaction $transaction)
    {
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}

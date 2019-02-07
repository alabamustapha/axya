<?php

namespace App\Http\Controllers;

use App\User;
use App\Doctor;
use Carbon\Carbon;
use App\Appointment;
use App\Transaction;
use Illuminate\Http\Request;
use App\Notifications\Transactions\TransactionFailedNotification;
use App\Notifications\Transactions\TransactionSuccessfulNotification;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        $this->middleware('patient')->only('index');
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
                                    ->paginate(15);
        return view('transactions.index', compact('user','transactions'));
    }

    public function drindex(Doctor $doctor)
    {
        // $this->authorize('doctor permitted?', Transaction::class);

        $transactions = Transaction::where('doctor_id', $doctor->id)
                                    ->latest()
                                    ->paginate(15);
        return view('transactions.doctor', compact('doctor','transactions'));
    }

    public function admindex()
    {
        // Display/Group by Date...
        $transactions = Transaction::latest()
                                    ->paginate(15);
        return view('transactions.admin', compact('transactions'));
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
        $this->authorize('create', Transaction::class);

        $request->validate(['appointment_id' => 'required|integer|exists:appointment,id']);

        $appointment = Appointment::find($request->appointment_id);

        $request->merge([
            'user_id'       => auth()->id(),
            'doctor_id'     => $appointment->doctor_id,
            'appointment_id'=> $appointment->id,
            'amount'        => $appointment->fee,
            'transaction_id'=> $appointment->makeTransactionId(),
            'status'        => '2',
            // 'currency'      => ,
            // 'channel'       => ,
            // 'processor_id'  => ,
            // 'processor_trxn_id' => ,
        ]);
        
        $transaction = Transaction::create($request->all());

        return redirect()->route('mobilpay_pay', ['model'=> $transaction]);

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
        $response = array_rand(['success' => 1,'failed' => 0]);
        // dd($response);
        // $response = $response_from_pymt_processor;

        if ($response == 'success'){
            $transaction->update([
                'status' => '1',
                'confirmed_at' => Carbon::now(),
            ]);
            
            $transaction->appointment->activateFeePayment(); 

            // Notify concerned parties of success.
            $transaction->user->notify(new TransactionSuccessfulNotification($transaction->user, $transaction));
            $transaction->doctor->user->notify(new TransactionSuccessfulNotification($transaction->doctor->user, $transaction));
            
            flash('Payment was successful, notification has been sent to the attending doctor.')->success(); 

            return redirect()->route('transactions.show', $transaction);
        }
        else {
            // No need to change status on appointment model, status quo maintained.
            $transaction->update(['status' => '3']);

            // Notify patient of failure. 
            $transaction->user->notify(new TransactionFailedNotification($transaction->user, $transaction));

            flash('Payment was not successful, try again')->error();

            return redirect()->route('transactions.show', $transaction);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
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

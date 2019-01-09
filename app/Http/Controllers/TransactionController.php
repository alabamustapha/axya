<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        // $this->middleware('patient')->only('show');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $this->authorize('view', Transaction::class);

        $transactions = Transaction::where('user_id', auth()->id())
                                    ->latest()
                                    ->paginate(15);
        return view('transactions.index', compact('transactions'));
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

        $appointment = Appointment::find($request->appointment_id);

        $request->merge([
            'user_id'       => auth()->id(),
            'doctor_id'     => $appointment->doctor_id,
            'appointment_id'=> $appointment->id,
            'amount'        => $appointment->fee,
            // 'currency'      => ,
            // 'channel'       => ,
            'transaction_id'=> $appointment->makeTransactionId(),
            // 'processor_id'  => ,
            // 'processor_trxn_id' => ,
            'status'        => '2'
        ]);
        
        $transaction = Transaction::create($request->all());

        if ($transaction) {
            $msg = 'Transaction created successfully.';

            flash($msg)->success();

            if (request()->expectsJson()) {
                return response(['status' => $msg]);
            }
        }

        return redirect()->route('appointments.show', $transaction->appointment);
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

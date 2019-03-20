<?php

namespace App\Http\Controllers;

use App\BankAccount;
use Illuminate\Http\Request;

class BankAccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
        // $this->middleware('doctoradmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bank_accounts = BankAccount::where('user_id', auth()->id())
                                    ->orderBy('name')
                                    ->get()
                                    ;
        return view('bank_accounts.index', compact('bank_accounts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', BankAccount::class);
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
        $this->authorize('create', BankAccount::class);
        
        $request->merge(['user_id' => auth()->id()]);
        
        $bank_account = BankAccount::create($request->all());

        flash($bank_account->name . ' created successfully')->success();

        return redirect()->route('bank_accounts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(BankAccount $bankAccount)
    {
        $this->authorize('edit', $bankAccount);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BankAccount $bankAccount)
    {
        $this->authorize('edit', $bankAccount);

        if ($bankAccount->update($request->all())){
            flash($bankAccount->name . ' updated successfully')->success();
        }

        return redirect()->route('bank_accounts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BankAccount  $bankAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(BankAccount $bankAccount)
    {
        $this->authorize('delete', $bankAccount);
        
        if ($bankAccount->delete()){
            flash($bankAccount->name . ' deleted successfully')->info();
        }

        return redirect()->route('bank_accounts.index');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payout extends Model
{
    protected $dates = ['confirmed_at'];

    protected $fillable = ['user_id', 'amount', 'status', 'transaction_id', 'processor_transaction_id', 'bank_account_id', 'confirmed_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }
}

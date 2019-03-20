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

    public function getStatusTextAttribute()
    {
        return $this->status == '0' 
                ? 'Processing' 
                : ($this->status == '1' 
                    ? 'Successful' : 'Failed')
                ;
    }

    public function getStatusIndicatorAttribute()
    {
        return $this->status == '0' 
                ? 'bg-warning' 
                : ($this->status == '1' 
                    ? 'bg-success' : 'bg-danger')
                ;
    }
}

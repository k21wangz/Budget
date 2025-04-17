<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $fillable = [
        'type', 'contact_name', 'account_id', 'currency_id', 'amount', 'paid', 'date', 'due_date', 'description', 'is_settled'
    ];

    public function account() {
        return $this->belongsTo(Account::class);
    }

    public function currency() {
        return $this->belongsTo(Currency::class);
    }
}

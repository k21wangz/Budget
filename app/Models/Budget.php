<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'budget_name', 'category', 'account_id', 'currency_id', 'amount', 'period', 'year', 'month', 'carry_over'
    ];
    public function account() {
        return $this->belongsTo(Account::class);
    }
    public function currency() {
        return $this->belongsTo(Currency::class);
    }
}

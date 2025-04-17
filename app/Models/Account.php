<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'currency_id', 'initial_balance', 'min_balance', 'type', 'description'
    ];
    public function currency() {
        return $this->belongsTo(Currency::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_account_id', 'to_account_id', 'amount', 'admin_fee', 'date', 'description'
    ];
    public function fromAccount() {
        return $this->belongsTo(Account::class, 'from_account_id');
    }
    public function toAccount() {
        return $this->belongsTo(Account::class, 'to_account_id');
    }
}

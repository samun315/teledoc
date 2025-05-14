<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Model;

class BalanceAdjust extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'balance_adjust';

    protected $fillable = [
        'id',
        'user_id',
        'balance',
        'type',
        'details',
        'before_balance',
        'after_balance',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}

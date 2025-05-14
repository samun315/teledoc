<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_id';

    protected $table = 'accounts';

    protected $fillable = [
        'account_id',
        'user_id',
        'current_balance',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];
}

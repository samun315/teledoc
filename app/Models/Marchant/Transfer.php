<?php

namespace App\Models\Marchant;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transfer extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'balance_transfers';

    protected $fillable = [
        'id',
        'transfer_from_user',
        'transfer_to_user',
        'amount',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    public function fromUser():BelongsTo
    {
        return $this->belongsTo(User::class,'transfer_from_user','id');
    }
    public function toUser():BelongsTo
    {
        return $this->belongsTo(User::class,'transfer_to_user','id');
    }
}

<?php

namespace App\Models\Doctor;

use App\Models\Order\Order;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DoctorEarning extends Model
{
    use HasFactory;

    /**
     * The model is not using Laravel's automatic timestamps
     * because the doctor_earnings table only has created_at (no updated_at).
     */
    public $timestamps = false;

    protected $primaryKey = 'earning_id';

    protected $table = 'doctor_earnings';

    protected $fillable = [
        'doctor_id',
        'order_id',
        'consultation_fee',
        'platform_commission',
        'doctor_amount',
        'status',
        'created_at'
    ];

    protected $casts = [
        'consultation_fee' => 'decimal:2',
        'platform_commission' => 'decimal:2',
        'doctor_amount' => 'decimal:2',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id', 'doctor_id');
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }
}

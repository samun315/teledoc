<?php

namespace App\Models\Feedback;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $primaryKey = 'feedback_id';
    protected $table = 'feedbacks';

    protected $fillable = [
        'feedback_id',
        'name',
        'phone',
        'email',
        'message',
        'status',
        'admin_notes',
        'created_at',
        'updated_at'
    ];
}

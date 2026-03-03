<?php

namespace App\Models\PrivacyPolicy;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrivacyPolicy extends Model
{
    use HasFactory;

    protected $primaryKey = 'privacy_policy_id';
    protected $table = 'privacy_policy';

    protected $fillable = [
        'privacy_policy_id',
        'privacy_policy',
        'created_by',
        'updated_by'
    ];
}

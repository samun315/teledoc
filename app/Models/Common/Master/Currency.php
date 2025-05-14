<?php

namespace App\Models\Common\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = 'currencies';

    protected $fillable = ['id', 'name', 'code', 'dial_code', 'currency_name', 'currency_symbol', 'currency_code', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}

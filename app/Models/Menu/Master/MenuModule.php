<?php

namespace App\Models\Menu\Master;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuModule extends Model
{
    use HasFactory;

    protected $primaryKey = 'module_id';

    protected $table = 'menu_modules';

    protected $fillable = [
        'module_id', 'module_name', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}

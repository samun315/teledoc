<?php

namespace App\Models\Menu\Menu;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $primaryKey = 'menu_id';

    protected $table = 'menus';

    protected $fillable = [
        'menu_id', 'menu_name','description', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'
    ];
}

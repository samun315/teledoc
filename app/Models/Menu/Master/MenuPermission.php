<?php

namespace App\Models\Menu\Master;

use App\Models\Common\Master\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MenuPermission extends Model
{
    use HasFactory;

    protected $primaryKey = 'menu_permission_id';

    protected $table = 'menu_permissions';

    protected $fillable = ['menu_permission_id', 'item_id', 'name', 'slug', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public function moduleItem(): BelongsTo
    {
        return $this->belongsTo(ModuleItem::class, 'item_id');
    }

    public function roles(){
        return $this->belongsToMany(UserRole::class, 'menu_role_permissions', 'menu_permission_id', 'role_id');
    }
}

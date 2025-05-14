<?php

namespace App\Models\Menu\Master;

use App\Models\Common\Master\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RolePermission extends Model
{
    use HasFactory;

    protected $primaryKey = 'menu_role_permission_id';

    protected $table = 'menu_role_permissions';

    protected $fillable = ['menu_role_permission_id', 'role_id', 'menu_permission_id','active', 'created_at', 'updated_at'];

    public function userRole(): BelongsTo
    {
        return $this->belongsTo(UserRole::class, 'role_id');
    }

    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'menu_permission_id');
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}

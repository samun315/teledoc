<?php

namespace App\Models\Common\Master;

use App\Models\Menu\Master\Permission;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    protected $primaryKey = 'role_id';

    protected $table = 'user_roles';

    protected $fillable = ['role_id', 'role_name', 'active', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public function permissions(){
        return $this->belongsToMany(Permission::class, 'menu_role_permissions', 'role_id', 'menu_permission_id');
    }

    public function users(){
        return $this->hasMany(User::class);
    }
}

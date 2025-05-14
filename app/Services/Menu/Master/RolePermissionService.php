<?php

namespace App\Services\Menu\Master;

use App\Models\Menu\Master\RolePermission;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class RolePermissionService
{

    public function getRolePermissionList(Request $request): JsonResponse
    {
        $query = RolePermission::query()
            ->with('userRole', 'permission')
            ->leftJoin('user_roles', 'menu_role_permissions.role_id', '=', 'user_roles.role_id')
            ->select('user_roles.role_name', 'menu_role_permissions.role_id', DB::raw('count(menu_role_permissions.menu_permission_id) as permissions_count'))
            ->groupBy('user_roles.role_name', 'menu_role_permissions.role_id')
            ->latest('menu_role_permissions.role_id')
            ->get();

        $searchKeyword = $request->input('search');

        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('menu_role_permission_id', 'like', '%' . $searchKeyword . '%')
                    ->orWhereHas('userRole', function ($q) use ($searchKeyword) {
                        $q->where('role_name', 'like', '%' . $searchKeyword . '%');
                    });
            });
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editRoute = route('menu.master.rolePermission.edit', $row->role_id);

                return view('menu.master.rolePermission.partials.editButton', ['editRoute' => $editRoute]);
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function getRolePermissionById(int $rolePermissionId): Model|Collection|Builder|array|null
    {

        return RolePermission::query()->where('role_id', $rolePermissionId)->get();
    }


    public function createRolePermission(array $data): bool
    {

        $role_id = $data['role_id'];

        $rolePermissionData = [];

        $currentDate = createdAtDateConvertToDB();


        foreach ($data['menu_permission_id'] as $permission_id) {

            $rolePermissionData[] = [
                'role_id' => $role_id,
                'menu_permission_id' => $permission_id,

                'created_at' => $currentDate,
            ];
        }

        return RolePermission::query()->insert($rolePermissionData);
    }


    public function updateRolePermission(array $updateData, int $rolePermissionId): bool|int
    {
        $rolePermission = $this->getRolePermissionById($rolePermissionId);

        if ($rolePermissionId) {
            DB::table('menu_role_permissions')->where('role_id', $rolePermissionId)->delete();
        }

        $rolePermissionData = [];

        $currentDate = createdAtDateConvertToDB();


        foreach ($updateData['menu_permission_id'] as $permission_id) {

            $rolePermissionData[] = [
                'role_id' => $rolePermissionId,
                'menu_permission_id' => $permission_id,

                'created_at' => $currentDate,
            ];
        }

        return RolePermission::query()->insert($rolePermissionData);
    }
}

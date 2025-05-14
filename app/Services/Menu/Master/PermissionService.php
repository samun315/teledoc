<?php

namespace App\Services\Menu\Master;

use App\Models\Menu\Master\Permission;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PermissionService
{
    /**
     * @throws Exception
     */
    public function getPermissionList(Request $request): JsonResponse
    {
        $query = Permission::query()->with('moduleItem')->latest();

        // Get the search keyword from the request.
        $searchKeyword = $request->input('search');


        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('name', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('slug', 'like', '%' . $searchKeyword . '%')
                    ->orWhereHas('moduleItem', function ($q) use ($searchKeyword) {
                        $q->where('item_name', 'like', '%' . $searchKeyword . '%');
                    });
            });
        }


        // Return the data as a JSON response using Datatables.
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                return '<button data-id="'.$row->menu_permission_id.'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm editPermissionButton"> <i class="fas fa-edit"></i> </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function getPermissionById(int $permissionId): Model|Collection|Builder|array|null
    {
        return Permission::query()->findOrFail($permissionId);
    }


    public function createPermission(array $data): Builder|Model
    {
        return Permission::query()->create($data);
    }


    public function updatePermission(array $updateData, int $permissionId): bool
    {
        $permission = $this->getPermissionById($permissionId);

        return $permission->update($updateData);
    }
}

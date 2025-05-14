<?php

namespace App\Services\Common\Master;

use App\Models\Common\Master\UserRole;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UserRoleService
{
    public function getUserRoleList(Request $request): JsonResponse
    {
        $query = UserRole::query()->select(['role_id', 'role_name', 'active'])->latest();

        $searchKeyword = $request->input('search');

        // If search keyword is present, apply search filter
        if ($searchKeyword) {
            $query->where('role_name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('active', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

             return '<button data-id="'.$row->role_id.'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm editUserRoleButton"> <i class="fas fa-edit"></i> </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function getUserRoleById(int $userRoleId): Model|Collection|Builder|array|null
    {
        return UserRole::query()->findOrFail($userRoleId);
    }

    public function createUserRole(array $data): Builder|Model
    {

        return UserRole ::query()->create($data);
    }


    public function updateUserRole(array $updateData, int $userRoleId): bool
    {
       $userRole = $this->getUserRoleById($userRoleId);

        return $userRole->update($updateData);
    }
}

<?php

namespace App\Http\Controllers\Menu\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\Master\RolePermissionRequest;
use App\Models\Common\Master\UserRole;
use App\Models\Menu\Master\ModuleItem;
use App\Models\Menu\Master\Permission;
use App\Models\Menu\Master\RolePermission;
use App\Services\Menu\Master\RolePermissionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class RolePermissionController extends Controller
{
    public function __construct(protected RolePermissionService $rolePermissionService)
    {
    }


    public function index(Request $request): View|JsonResponse
    {
        Gate::authorize('menu.master.rolePermission.index');

        if ($request->ajax()) {
            return $this->rolePermissionService->getRolePermissionList($request);
        }

        $userRoles = UserRole::query()->where('active', 'YES')->get();


        $permissions = Permission::query()->where('active', 'YES')->get();

        $data = [
            'userRoles' => $userRoles,
            'permissions' => $permissions
        ];

        return view('menu.master.rolePermission.index', $data);
    }

    public function create(): View
    {
        Gate::authorize('menu.master.rolePermission.create');

        $userRoles = UserRole::query()->where('active', 'YES')->get();
        $permissions = Permission::query()->where('active', 'YES')->get();
        $itemNames = ModuleItem::query()->get();

        $data = [
            'userRoles' => $userRoles,
            'permissions' => $permissions,
            'itemNames' =>  $itemNames
        ];

        return view('menu.master.rolePermission.create', $data);
    }


    public function store(RolePermissionRequest $request): RedirectResponse
    {
        Gate::authorize('menu.master.rolePermission.create');
        try {
            // dd($request);
            $this->rolePermissionService->createRolePermission($request->validated());

            return back()->with('success', 'Role permission created successfully');
        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(int $rolePermissionId): View
    {
        Gate::authorize('menu.master.rolePermission.edit');

        $data['userRoles'] = UserRole::query()->where([['active', 'YES'],[ 'role_id', $rolePermissionId]])->get();

        $data['permissions'] = Permission::query()->where('active', 'YES')->get();

        $data['itemNames'] = ModuleItem::query()->get();

        // $data = $this->rolePermissionService->getRolePermissionById($rolePermissionId);
        $data['editModeData'] = $this->rolePermissionService->getRolePermissionById($rolePermissionId);
// dd( $data['editModeData']);
      $data['roleId'] = $rolePermissionId;
        return view('menu.master.rolePermission.edit', $data);
    }


    public function update(RolePermissionRequest $request, int $rolePermissionId): RedirectResponse
    {
        Gate::authorize('menu.master.rolePermission.edit');
        // dd($rolePermissionId);
        try {

            $this->rolePermissionService->updateRolePermission($request->fields(), $rolePermissionId);

            return redirect(route('menu.master.rolePermission.index'))->with('success', 'Role permission updated successfully.');
        } catch (\Exception $e) {

            return back()->with('error', $e->getMessage());
        }
    }

    // public function updateStatus(Request $request): JsonResponse
    // {

    //     $rolePermissionId = $request->input('menu_role_permission_id');
    //     $active = $request->input('active');

    //     try {

    //         $this->rolePermissionService->updateRolePermission(['active' => $active], $rolePermissionId);

    //         return response()->json('success');
    //     } catch (\Exception $e) {
    //         // Return an error response if an exception occurs.
    //         return response()->json(['error', $e->getMessage()]);
    //     }
    // }
}

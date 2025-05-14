<?php

namespace App\Http\Controllers\Menu\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\Master\PermissionRequest;
use App\Models\Menu\Master\ModuleItem;
use App\Services\Menu\Master\PermissionService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function __construct(protected PermissionService $permissionService)
    {
    }

    public function index(Request $request): View|JsonResponse
    {
        Gate::authorize('menu.master.permission.index');

        if ($request->ajax()) {
            return $this->permissionService->getPermissionList($request);
        }

        $moduleItems = ModuleItem::query()->where('active', 'YES')->get(['item_id', 'item_name']);
        return view('menu.master.permission.index', compact('moduleItems'));
    }


    public function create(): View
    {
        Gate::authorize('menu.master.permission.create');

        $moduleItems = ModuleItem::query()->where('active', 'YES')->get(['item_id', 'item_name']);

        return view('menu.master.permission.form', compact('moduleItems'));
    }


    public function store(PermissionRequest $request): JsonResponse
    {
        Gate::authorize('menu.master.permission.create');
        try {

            $this->permissionService->createPermission($request->fields());

            return sendSuccessResponse(201, 'Menu permission created successfully.');
        } catch (\Exception $e) {

            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }


    public function edit($permissionId): JsonResponse
    {
        Gate::authorize('menu.master.permission.edit');

        $data['moduleItems'] = ModuleItem::query()->where('active', 'YES')->get(['item_id', 'item_name']);
        $data = $this->permissionService->getPermissionById($permissionId);


        return sendSuccessResponse(200, 'Menu permission list fetch successfully', 'permission', $data);
    }

    public function update(PermissionRequest $request, $permissionId): JsonResponse
    {
        Gate::authorize('menu.master.permission.edit');
        try {

            $this->permissionService->updatePermission($request->fields(), $permissionId);


            return sendSuccessResponse(200, 'Menu permission updated successfully.');
        } catch (\Exception $e) {

            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }


    // public function updateStatus(Request $request): JsonResponse
    // {

    //     $permissionId = $request->input('menu_permission_id');
    //     $active = $request->input('active');

    //     try {

    //         $this->permissionService->updatePermission(['active' => $active], $permissionId);


    //         return sendSuccessResponse(200, 'Menu permission status updated successfully.');
    //     } catch (\Exception $e) {

    //         return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
    //     }
    // }
}

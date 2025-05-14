<?php

namespace App\Http\Controllers\Menu\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\Master\MenuModuleRequest;
use App\Services\Menu\Master\MenuModuleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class MenuModuleController extends Controller
{
    public function __construct(protected MenuModuleService $menuModuleService)
    {
    }

    public function index(Request $request): View|JsonResponse
    {
        Gate::authorize('menu.master.module.index');
        if ($request->ajax()) {
            return $this->menuModuleService->getModuleList($request);
        }

        return view('menu.master.module.index');
    }


    public function create(): View
    {
        Gate::authorize('menu.master.module.create');

        return view('menu.master.module.form');
    }

    public function store(MenuModuleRequest $request): JsonResponse
    {
        Gate::authorize('menu.master.module.create');
        try {

            $this->menuModuleService->createModule($request->fields());

            return sendSuccessResponse(201, 'Menu module created successfully.');
        } catch (Exception $e) {

            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }


    public function edit($moduleId): JsonResponse
    {
        Gate::authorize('menu.master.module.edit');

        $data = $this->menuModuleService->getModuleById($moduleId);

        return sendSuccessResponse(200, 'Menu module list fetch successfully', 'module', $data);
    }


    public function update(MenuModuleRequest $request, $moduleId): JsonResponse
    {
        Gate::authorize('menu.master.module.edit');
        try {

            $this->menuModuleService->updateModule($request->fields(), $moduleId);

            return sendSuccessResponse(200, 'Menu module updated successfully.');
        } catch (Exception $e) {

            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }


    public function updateStatus(Request $request): JsonResponse
    {

        $moduleId = $request->input('module_id');
        $active = $request->input('active');

        try {

            $this->menuModuleService->updateModule(['active' => $active], $moduleId);

            return sendSuccessResponse(200, 'Menu module status updated successfully.');
        } catch (\Exception $e) {

            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Menu\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\Master\ModuleItemRequest;
use App\Models\Menu\Master\MenuModule;
use App\Services\Menu\Master\ModuleItemService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class ModuleItemController extends Controller
{
    public function __construct(protected ModuleItemService $moduleItemService)
    {
    }

    public function index(Request $request): View|JsonResponse
    {
        Gate::authorize('menu.master.moduleItem.index');

        if ($request->ajax()) {
            return $this->moduleItemService->getModuleItemList($request);
        }

        $modules = MenuModule::query()->where('active', 'YES')->get(['module_id', 'module_name']);
        return view('menu.master.moduleItem.index', compact('modules'));
    }


    public function create(): View
    {
        Gate::authorize('menu.master.moduleItem.create');

        $modules = MenuModule::query()->where('active', 'YES')->get(['module_id', 'module_name']);

        return view('menu.master.moduleItem.form', compact('modules'));
    }


    public function store(ModuleItemRequest $request): JsonResponse
    {
        Gate::authorize('menu.master.moduleItem.create');
        try {

            $this->moduleItemService->createModuleItem($request->fields());

            return sendSuccessResponse(201, 'Module item created successfully.');
        } catch (\Exception $e) {

            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }


    public function edit($moduleItemId): JsonResponse
    {
        Gate::authorize('menu.master.moduleItem.edit');

        $data['modules'] = MenuModule::query()->where('active', 'YES')->get(['module_id', 'module_name']);
        $data = $this->moduleItemService->getModuleItemById($moduleItemId);


        return sendSuccessResponse(200, 'Module item list fetch successfully', 'moduleItem', $data);
    }

    public function update(ModuleItemRequest $request, $moduleItemId): JsonResponse
    {
        Gate::authorize('menu.master.moduleItem.edit');
        try {

            $this->moduleItemService->updateModuleItem($request->fields(), $moduleItemId);


            return sendSuccessResponse(200, 'Module item updated successfully.');
        } catch (Exception $e) {

            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }


    public function updateStatus(Request $request): JsonResponse
    {

        $moduleItemId = $request->input('item_id');
        $active = $request->input('active');

        try {

            $this->moduleItemService->updateModuleItem(['active' => $active], $moduleItemId);


            return sendSuccessResponse(200, 'Module item status updated successfully.');
        } catch (\Exception $e) {

            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }
}

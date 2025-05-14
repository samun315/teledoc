<?php

namespace App\Http\Controllers\Menu\Menu;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\Menu\MenuItemRequest;
use App\Models\Menu\Master\MenuModule;
use App\Models\Menu\Master\ModuleItem;
use App\Models\Menu\Menu\Menu;
use App\Models\Menu\Menu\MenuItem;
use App\Services\Menu\Menu\MenuItemService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class MenuItemController extends Controller
{
    public function __construct(protected MenuItemService $menuItemService) {}

    public function index(int $menuId): View
    {
        $data['menuInfos'] = Menu::query()->where('menu_id', $menuId)->first();
        $data['menuModules'] = MenuModule::query()->orderBy('module_id', 'DESC')->get(['module_id', 'module_name']);
        $data['moduleItems'] = ModuleItem::query()->orderBy('item_id', 'DESC')->get(['item_id', 'item_name']);
        //        $data['parents'] = MenuItem::query()->whereNull('parent_id')->whereNull('url')->where('type', 'menu_item')->orWhere('url', '#')->get(['menu_item_id', 'menu_item_name']);
        $data['parents'] = DB::select("SELECT menu_item_id,menu_item_name FROM menu_items WHERE (parent_id IS NULL OR parent_id IS NOT NULL) AND (url IS NULL AND type = 'menu_item')");
        $data['menuItems'] =  MenuItem::query()->where('menu_id', $menuId)->orderBy('order')->get();
        $data['childDatas'] =  MenuItem::query()->where('menu_id', $menuId)->whereNotNull('parent_id')->where('type', 'menu_item')->orderBy('order')->get();
        $data['grandChildDatas'] =  MenuItem::query()->where('menu_id', $menuId)->whereNotNull('parent_id')->whereNotNull('url')->where('type', 'menu_item')->orderBy('order')->get();

        return view("menu.menuItem.index", $data);
    }

    public function moduleItem(int $moduleId): JsonResponse
    {
        try {
            $moduleItem = ModuleItem::query()->where('module_id', $moduleId)->orderBy('item_id', 'DESC')->get(['item_id', 'item_name']);

            return sendSuccessResponse(200, '', 'data', $moduleItem);
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }

    public function getParent(int $moduleId): JsonResponse
    {
        try {
            $parents = DB::select("SELECT menu_item_id,menu_item_name FROM menu_items WHERE (parent_id IS NULL OR parent_id IS NOT NULL) AND (url IS NULL AND type = 'menu_item') AND module_id = $moduleId");

            return sendSuccessResponse(200, '', 'data', $parents);
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }

    public function store(MenuItemRequest $request): JsonResponse
    {
        try {

            $this->menuItemService->createMenuItem($request->fields());
            return sendSuccessResponse(201, 'Menu Item created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function menuItemList(Request $request, int $menuId): JsonResponse|Collection|bool
    {
        try {
            if ($request->ajax()) {
                $menuItems = $this->menuItemService->getMenuItemList($request, $menuId);
                return sendSuccessResponse(200, '', 'data', $menuItems);
            }
            return true;
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }

    public function edit(int $menuItemId): JsonResponse
    {
        try {
            $itemInfo = $this->menuItemService->getMenuItemInfoById($menuItemId);

            return sendSuccessResponse(200, '', 'itemInfo', $itemInfo);
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }

    public function update(MenuItemRequest $request, int $menuItemId): JsonResponse
    {
        try {

            $this->menuItemService->updateMenuItem($request->fields(), $menuItemId);
            return sendSuccessResponse(200, 'Menu Item updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function order(Request $request, int $menuId): JsonResponse
    {
        try {
            $menuItemOrder = json_decode($request->order);
            $itemOrderInfo = $this->menuItemService->orderMenu($menuItemOrder, 0);

            return sendSuccessResponse(200, 'Successfully updated menu order', 'itemOrderInfo', $itemOrderInfo);
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }

    public function destroy(int $menuItemId): JsonResponse
    {
        try {
            $menuItem = MenuItem::findOrFail($menuItemId);
            $menuChildItem = MenuItem::query()->where('parent_id', $menuItemId)->first();

            if (empty($menuChildItem)) {
                $deleteMenu = $menuItem->delete();
                return sendSuccessResponse(200, 'Successfully deleted menu order', 'data', $deleteMenu);
            } else {
                return sendSuccessResponse(204, 'Could not delete parent, need to delete child first.', '', '');
            }
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }
}

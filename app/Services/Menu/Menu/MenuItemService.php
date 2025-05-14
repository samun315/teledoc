<?php

namespace App\Services\Menu\Menu;

use App\Models\Menu\Menu\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class MenuItemService
{

    public function createMenuItem(array $data): Model|Builder
    {
        return MenuItem::create($data);
    }

    public function updateMenuItem(array $updateData, int $menuItemId): int
    {
        $menuItem = $this->getMenuItemInfoById($menuItemId);

        return $menuItem->update($updateData);
    }

    public function getMenuItemList(Request $request, int $menuId): Builder|Model|Collection|JsonResponse|array
    {
        $data['menuItems'] =  MenuItem::query()->where('menu_id', $menuId)->orderBy('menu_item_id', 'ASC')->get();
        $data['childData'] =  MenuItem::query()->where('menu_id', $menuId)->whereNotNull('parent_id')->whereNotNull('url')->get();

        return $data;
    }

    public function getMenuItemInfoById(int $menuItemId): Model|Builder|Collection
    {
        return MenuItem::query()->with('item', 'module')->findOrFail($menuItemId);
    }

    public function orderMenu(array $menuItems, int $parent): Model|Builder|Collection
    {
        foreach ($menuItems as $index => $item) {

            $parentId = $parent == 0 ? null : $parent;

            $menuItem = MenuItem::findOrFail($item?->id);

            $menuItem->update([
                'order' => $index + 1,
                'parent_id' => $parentId
            ]);

            if (isset($item?->children)) {
                $this->orderMenu($item?->children, $menuItem?->menu_item_id);
            }
        }

        return $menuItem;
    }
}

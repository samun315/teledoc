<?php

use App\Models\Menu\Menu\Menu;
use App\Models\Menu\Menu\MenuItem;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

if (!function_exists('menu')) {

    /**
     * description
     *
     * @param
     * @return array
     */

    function menu($name): array|Collection
    {

        $role = User::query()->where('id', loggedInUserId())->first(['role_id']);

        $modules = [];
        if ($role) {
            $data = DB::select("
        SELECT DISTINCT(mp.item_id)
        FROM menu_role_permissions mrp
        INNER JOIN menu_permissions mp ON mrp.menu_permission_id = mp.menu_permission_id
        WHERE mrp.role_id = ?", [$role->role_id]);

            foreach ($data as $value) {
                $modules[] = $value->item_id;
            }
        }

        $menu = Menu::query()->where('menu_name', $name)->first();

        if ($menu) {

            $parents = [];
            $permissionItems = [];
            $grandParentItems = [];
            $moduleIds = [];
            $dividerIds = [];

            $parentItems = MenuItem::query()
                ->where('menu_id', $menu->menu_id)
                ->whereIn('module_item_id', $modules)
                ->select('menu_item_id', 'parent_id')
                ->distinct()
                ->get();


            foreach ($parentItems as $val) {
                $parents[] = $val->parent_id;
                $permissionItems[] = $val->menu_item_id;
            }

            $grandParentItemsQuery = MenuItem::query()
                ->where('menu_id', $menu->menu_id)
                ->whereIn('menu_item_id', $parents)
                ->select('parent_id')
                ->distinct()
                ->get();

            foreach ($grandParentItemsQuery as $val) {
                $grandParentItems[] = $val->parent_id;
            }

            $moduleIdQuery = MenuItem::query()
                ->where('menu_id', $menu->menu_id)
                ->whereIn('module_item_id', $modules)
                ->select('module_id')
                ->distinct()
                ->get();

            foreach ($moduleIdQuery as $val) {
                $moduleIds[] = $val->module_id;
            }

            $dividerIdQuery = MenuItem::query()
                ->where('menu_id', $menu->menu_id)
                ->whereIn('module_id', $moduleIds)
                ->where('type', 'divider')
                ->select('menu_item_id')
                ->distinct()
                ->get();

            foreach ($dividerIdQuery as $val) {
                $dividerIds[] = $val->menu_item_id;
            }

            $allPermissionItems = array_unique(array_merge($parents, $permissionItems, $grandParentItems, $dividerIds));

            $menuItems = MenuItem::query()
                ->where('menu_id', $menu->menu_id)
                ->whereIn('menu_item_id', $allPermissionItems)
                ->with(['children' => function ($query) use ($allPermissionItems) {
                    $query->whereIn('menu_item_id', $allPermissionItems);
                }])
                ->orderBy('order')
                ->get();
        }
        return $menuItems;
    }
}

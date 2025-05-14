<?php

namespace App\Services\Menu\Menu;

use App\Models\Menu\Menu\Menu;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class MenuService
{

    public function getMenuList(Request $request): JsonResponse
    {
        $query = Menu::query()->latest();

        $searchKeyword = $request->input('search');

        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('menu_name', 'ilike', '%' . $searchKeyword . '%')
                    ->orWhere('active', 'LIKE', '%' . $searchKeyword .  '%');
            });
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $builderBtn = '<a href="' . route('menu.menu.menuItem.index', $row?->menu_id) . '"
                        class="btn btn-bg-light btn-light-primary btn-sm me-2"> <i
                            class="fas fa-list"></i> builder</a>';

                $editBtn = '<button data-id="'.$row?->menu_id.'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm editMenuBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit"></i></button>';
                return $builderBtn . $editBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createMenu(array $data): Model|Builder
    {
        return Menu::create($data);
    }

    public function getMenuById(int $menuId): Model|Builder
    {
        return Menu::findOrFail($menuId);
    }

    public function updateMenu(array $updateData, int $menuId): int
    {
        $menu = $this->getMenuById($menuId);

        return $menu->update($updateData);
    }
}

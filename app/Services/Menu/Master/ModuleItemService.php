<?php

namespace App\Services\Menu\Master;

use App\Models\Menu\Master\ModuleItem;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ModuleItemService
{
    /**
     * @throws Exception
     */
    public function getModuleItemList(Request $request): JsonResponse
    {
        $query = ModuleItem::query()->with('module')->latest();

        $searchKeyword = $request->input('search');

        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('item_name', 'like', '%' . $searchKeyword . '%')
                    ->orWhere('active', 'like', '%' . $searchKeyword . '%')
                    ->orWhereHas('module', function ($q) use ($searchKeyword) {
                        $q->where('module_name', 'like', '%' . $searchKeyword . '%');
                    });
            });
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

        return '<button data-id="'.$row->item_id.'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm editModuleItemButton"> <i class="fas fa-edit"></i> </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function getModuleItemById(int $moduleItemId): Model|Collection|Builder|array|null
    {
        return ModuleItem::query()->findOrFail($moduleItemId);
    }


    public function createModuleItem(array $data): Builder|Model
    {
        return ModuleItem::query()->create($data);
    }


    public function updateModuleItem(array $updateData, int $moduleItemId): bool
    {
        $moduleItem = $this->getModuleItemById($moduleItemId);

        return $moduleItem->update($updateData);
    }
}

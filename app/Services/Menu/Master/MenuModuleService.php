<?php

namespace App\Services\Menu\Master;

use App\Models\Menu\Master\MenuModule;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MenuModuleService
{
    public function getModuleList(Request $request): JsonResponse
    {
        $query = MenuModule::query()->select(['module_id', 'module_name', 'active'])->latest();

        $searchKeyword = $request->input('search');

        // If search keyword is present, apply search filter
        if ($searchKeyword) {
            $query->where('module_name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('active', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

        return '<button data-id="'.$row->module_id.'" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm editMenuModuleButton"> <i class="fas fa-edit"></i> </button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function getModuleById(int $moduleId): Model|Collection|Builder|array|null
    {
        return MenuModule::query()->findOrFail($moduleId);
    }


    public function createModule(array $data): Builder|Model
    {
        // Create and return the new module record
        return MenuModule::query()->create($data);
    }


    public function updateModule(array $updateData, int $moduleId): bool
    {
        // Retrieve the module by ID
        $module = $this->getModuleById($moduleId);

        // Update the module with the provided data
        return $module->update($updateData);
    }
}

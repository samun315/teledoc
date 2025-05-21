<?php

namespace App\Services\Drug;

use App\Models\Drug\DrugType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DrugService
{
    public function getDrugTypeList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = DrugType::query()->select('drug_type_id', 'drug_type', 'status')->latest();

        if ($searchKeyword) {
            $query->where('drug_type', 'like', '%' . $searchKeyword . '%')
                ->orWhere('status', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->drug_type_id . '" class="btn btn-bg-info text-white btn-sm editDrugTypeBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createDrugType(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $drugType = DrugType::query()->create($data);
            DB::commit();

            return $drugType;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDrugTypeById(int $drugTypeId): Model|Builder
    {
        return DrugType::find($drugTypeId);
    }

    public function updateDrugType(array $updateData, int $drugTypeId): int
    {
        $drugType = $this->getDrugTypeById($drugTypeId);

        return $drugType->update($updateData);
    }
}

<?php

namespace App\Services\Drug;

use App\Models\Drug\Drug;
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
    public function getDrugList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = Drug::query()->select('*')->latest();

        if ($searchKeyword) {
            $query->where('trade_name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('generic_name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('note', 'like', '%' . $searchKeyword . '%')
                ->orWhere('side_effect', 'like', '%' . $searchKeyword . '%')
                ->orWhere('additional_advice', 'like', '%' . $searchKeyword . '%')
                ->orWhere('warning', 'like', '%' . $searchKeyword . '%')
                ->orWhere('status', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->drug_id . '" class="btn btn-bg-info text-white btn-sm editDrugBtn me-2" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $viewBtn = '<button data-id="' . $row?->drug_id . '" class="btn btn-bg-light btn-sm viewDrugBtn me-2" data-bs-toggle="modal" data-bs-target="#showViewModal"><i class="fas fa-eye"></i> View</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            ' . $viewBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createDrug(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $drug = Drug::query()->create($data);
            DB::commit();

            return $drug;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDrugById(int $drugId): Model|Builder
    {
        return Drug::find($drugId);
    }

    public function updateDrug(array $updateData, int $drugId): int
    {
        $drug = $this->getDrugById($drugId);

        return $drug->update($updateData);
    }
}

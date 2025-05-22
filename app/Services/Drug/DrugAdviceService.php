<?php

namespace App\Services\Drug;

use App\Models\Drug\DrugAdvice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DrugAdviceService
{
    public function getDrugAdviceList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = DrugAdvice::query()->select('drug_advice_id', 'drug_advice', 'status')->latest();

        if ($searchKeyword) {
            $query->where('drug_advice', 'like', '%' . $searchKeyword . '%')
                ->orWhere('status', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->drug_advice_id . '" class="btn btn-bg-info text-white btn-sm editDrugAdviceBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createDrugAdvice(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $drugAdvice = DrugAdvice::query()->create($data);
            DB::commit();

            return $drugAdvice;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDrugAdviceById(int $drugAdviceId): Model|Builder
    {
        return DrugAdvice::find($drugAdviceId);
    }

    public function updateDrugAdvice(array $updateData, int $drugAdviceId): int
    {
        $drugAdvice = $this->getDrugAdviceById($drugAdviceId);
   
        return $drugAdvice->update($updateData);
    }
}

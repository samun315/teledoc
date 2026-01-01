<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\DrugDosesRequest;
use App\Models\Drug\DrugType;
use App\Services\Drug\DrugDosesService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrugDosesController extends Controller
{
    public function __construct(protected DrugDosesService $drugDosesService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->drugDosesService->getDrugDosesList($request);
        }
      
        $data['drugTypes'] = DrugType::query()->where('status','Active')->get(['drug_type_id','drug_type']);
        
        return view('drugs.drugDoses.index',$data);
    }

    public function store(DrugDosesRequest $request): JsonResponse
    {
        try {

            $drugDose = $this->drugDosesService->createDrugDose($request->fields());
            return sendSuccessResponse(201, 'Drug Doses created successfully.', 'data', $drugDose);
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $drugDosesId): JsonResponse
    {
        $data = $this->drugDosesService->getDrugDoseById($drugDosesId);
        return sendSuccessResponse(200, '', 'drugDoseInfo', $data);
    }

    public function update(DrugDosesRequest $request, int $drugDosesId): JsonResponse
    {
        try {

            $this->drugDosesService->updateDrugDose($request->fields(), $drugDosesId);
            return sendSuccessResponse(201, 'Drug Dose updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}

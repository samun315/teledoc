<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\DrugStrengthRequest;
use App\Services\Drug\DrugStrengthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrugStrengthController extends Controller
{
     public function __construct(protected DrugStrengthService $drugStrengthService) {}

         public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->drugStrengthService->getDrugStrengthList($request);
        }

        return view('drugs.drugStrength.index');
    }

    public function store(DrugStrengthRequest $request): JsonResponse
    {
        try {

            $this->drugStrengthService->createDrugStrength($request->fields());
            return sendSuccessResponse(201, 'Drug strength created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $drugStrengthId): JsonResponse
    {
        $data = $this->drugStrengthService->getDrugStrengthById($drugStrengthId);
        return sendSuccessResponse(200, '', 'drugStrengthInfo', $data);
    }

    public function update(DrugStrengthRequest $request, int $drugStrengthId): JsonResponse
    {
        try {

            $this->drugStrengthService->updateDrugStrength($request->fields(), $drugStrengthId);
            return sendSuccessResponse(201, 'Drug strength updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}

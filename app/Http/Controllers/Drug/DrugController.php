<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\DrugRequest;
use App\Services\Drug\DrugService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrugController extends Controller
{
     public function __construct(protected DrugService $drugService) {}

         public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->drugService->getDrugList($request);
        }

        return view('drugs.drug.index');
    }

    public function store(DrugRequest $request): JsonResponse
    {
        try {

            $this->drugService->createDrug($request->fields());
            return sendSuccessResponse(201, 'Drug  created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $drugId): JsonResponse
    {
        $data = $this->drugService->getDrugById($drugId);
        return sendSuccessResponse(200, '', 'drugInfo', $data);
    }

    public function update(DrugRequest $request, int $drugId): JsonResponse
    {
        try {

            $this->drugService->updateDrug($request->fields(), $drugId);
            return sendSuccessResponse(201, 'Drug  updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}

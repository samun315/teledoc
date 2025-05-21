<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\DrugTypeRequest;
use App\Services\Drug\DrugService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrugController extends Controller
{
    public function __construct(protected DrugService $drugService) {}

     public function index(Request $request):View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->drugService->getDrugTypeList($request);
        }

        return view('drugs.drugType.index');
    }

        public function store(DrugTypeRequest $request): JsonResponse
    {
        try {

            $this->drugService->createDrugType($request->fields());
            return sendSuccessResponse(201, 'Drug Type created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $drugTypeId):JsonResponse
    {
        $data = $this->drugService->getDrugTypeById($drugTypeId);
        return sendSuccessResponse(200, '', 'drugTypeInfo', $data);
    }

    public function update(DrugTypeRequest $request, int $drugTypeId): JsonResponse
    {
        try {

            $this->drugService->updateDrugType($request->fields(), $drugTypeId);
            return sendSuccessResponse(201, 'Drug Type updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}

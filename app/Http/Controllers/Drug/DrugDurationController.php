<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\DrugDurationRequest;
use App\Services\Drug\DrugDurationService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrugDurationController extends Controller
{
    public function __construct(protected DrugDurationService $drugDurationService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->drugDurationService->getDrugDurationList($request);
        }

        return view('drugs.drugDuration.index');
    }

    public function store(DrugDurationRequest $request): JsonResponse
    {
        try {

            $this->drugDurationService->createDrugDuration($request->fields());
            return sendSuccessResponse(201, 'Drug Duration created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $drugDurationId): JsonResponse
    {
        $data = $this->drugDurationService->getDrugDurationById($drugDurationId);
        return sendSuccessResponse(200, '', 'drugDurationInfo', $data);
    }

    public function update(DrugDurationRequest $request, int $drugDurationId): JsonResponse
    {
        try {

            $this->drugDurationService->updateDrugDuration($request->fields(), $drugDurationId);
            return sendSuccessResponse(201, 'Drug Duration updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}

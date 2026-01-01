<?php

namespace App\Http\Controllers\Drug;

use App\Http\Controllers\Controller;
use App\Http\Requests\Drug\DrugAdviceRequest;
use App\Services\Drug\DrugAdviceService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DrugAdviceController extends Controller
{
     public function __construct(protected DrugAdviceService $drugAdviceService) {}

         public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->drugAdviceService->getDrugAdviceList($request);
        }

        return view('drugs.drugAdvice.index');
    }

    public function store(DrugAdviceRequest $request): JsonResponse
    {
        try {

            $drugAdvice = $this->drugAdviceService->createDrugAdvice($request->fields());
            return sendSuccessResponse(201, 'Drug Advice created successfully.', 'data', $drugAdvice);
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $drugAdviceId): JsonResponse
    {
        $data = $this->drugAdviceService->getDrugAdviceById($drugAdviceId);
        return sendSuccessResponse(200, '', 'drugAdviceInfo', $data);
    }

    public function update(DrugAdviceRequest $request, int $drugAdviceId): JsonResponse
    {
        try {

            $this->drugAdviceService->updateDrugAdvice($request->fields(), $drugAdviceId);
            return sendSuccessResponse(201, 'Drug Advice updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}

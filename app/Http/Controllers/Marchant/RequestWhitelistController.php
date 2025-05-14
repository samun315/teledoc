<?php

namespace App\Http\Controllers\Marchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Marchant\RequestWhitelistRequest;
use App\Services\Marchant\RequestWhitelistService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class RequestWhitelistController extends Controller
{
    public function __construct(protected RequestWhitelistService $requestWhitelistService) {}

    public function index(Request $request):View|JsonResponse
    {
        
        if ($request->ajax()) {
            return $this->requestWhitelistService->getWhitelistRequest($request);
        }

        return view('marchant.requestWhitelist.index');
    }

    public function store(RequestWhitelistRequest $request): JsonResponse
    {
        try {

            $storeUserInfo = $this->requestWhitelistService->storeWhitelistRequest($request->fields());

            return sendSuccessResponse(
                200,
                'Whitelist Request Created successfully.',
                'data',
                $storeUserInfo
            );
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }
}

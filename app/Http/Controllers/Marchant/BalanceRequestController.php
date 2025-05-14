<?php

namespace App\Http\Controllers\Marchant;

use App\Http\Controllers\Controller;
use App\Http\Requests\Marchant\BalanceRequest;
use App\Models\Marchant\RequestWhitelist;
use App\Models\Payment\Account;
use App\Services\Marchant\BalanceRequestService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BalanceRequestController extends Controller
{
    public function __construct(protected BalanceRequestService $balanceRequestService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->balanceRequestService->getRequestInfo($request);
        }
        $userId = Auth::user()->id;

        $data['phones'] = RequestWhitelist::query()->where('status', 'Active')->where('created_by', $userId)->get(['mobile_number']);
        $data['account'] = Account::query()->where('user_id', $userId)->first();

        return view('marchant.balanceRequest.index', $data);
    }

    public function store(BalanceRequest $request): JsonResponse
    {
        try {

            $storeBalanceInfo = $this->balanceRequestService->storeBalanceRequest($request->fields());

            if ($storeBalanceInfo) {
                return sendSuccessResponse(
                    200,
                    'Balance Request Created successfully.',
                    'data',
                    $storeBalanceInfo
                );
            } else {
                return sendErrorResponse('Insufficient balance to your account', '', 500);
            }
            
    
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }
}

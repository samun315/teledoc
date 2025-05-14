<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\BalanceAdjustRequest;
use App\Http\Requests\Payment\PaymentGatewayRequest;
use App\Models\Common\Master\Currency;
use App\Models\Payment\Account;
use App\Models\Payment\PaymentGateway;
use App\Models\User;
use App\Services\Payment\BalanceAdjustService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BalanceAdjustController extends Controller
{

    public function __construct(protected BalanceAdjustService $balanceAdjustService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->balanceAdjustService->getBalanceAdjustList($request);
        }

        $data['users'] = User::query()->where(['active' => 'YES', 'role_id' => 2])->get();

        return view('payment.balanceAdjust.index', $data);
    }

    public function store(BalanceAdjustRequest $request): JsonResponse
    {
        try {

            $storeBalanceInfo = $this->balanceAdjustService->storeAdjustBalance($request->fields());

            return sendSuccessResponse(
                200,
                'Balance Adjusted successfully.',
                'data',
                $storeBalanceInfo
            );
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }

    public function getAccount(int $userId): JsonResponse
    {
        try {
            $account = Account::query()->where('user_id', $userId)->first();

            return sendSuccessResponse(200, '', 'account', $account);
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }

}

<?php

namespace App\Services\Common\Currency;

use App\Models\Common\Master\Currency;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CurrencyService
{
    public function getCurrencyList(Request $request): JsonResponse
    {
        $query = Currency::query()->select()->latest();

        $searchKeyword = $request->input('search');

        // If search keyword is present, apply search filter
        if ($searchKeyword) {
            $query->where('currency_name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('currency_code', 'like', '%' . $searchKeyword . '%')
                ->orWhere('active', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function updateCurrencyStatus(array $updateData, int $id): bool
    {
        // Find the currncy by its ID or fail if not found.
        $currency = Currency::query()->where('id',$id)->first();

        // Update the currncy with the provided data and return the result.
        return $currency->update($updateData);
    }
}

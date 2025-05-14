<?php

namespace App\Services\Marchant;

use App\Models\Marchant\RequestWhitelist;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class RequestWhitelistService
{

    public function storeWhitelistRequest(array $data): RequestWhitelist|JsonResponse
    {
        return RequestWhitelist::query()->create($data);
    }

    public function getWhitelistRequest(Request $request): JsonResponse
    {
        $searchKeyword = $request->input('search');

        $query = RequestWhitelist::query()->where(function ($query) use ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('mobile_number', 'like', "%$searchKeyword%")
                    ->orWhere('status', 'like', "%$searchKeyword%");
            });
            $query->where('created_by',loggedInUserId());
        })->latest();

        return Datatables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

}

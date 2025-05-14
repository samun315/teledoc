<?php

namespace App\Services\Marchant;

use App\Models\Marchant\RequestWhitelist;
use FontLib\Table\Type\name;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\DataTables;

class RequestWhitelistApproveService
{


    public function getWhitelistRequest(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = RequestWhitelist::query()->leftJoin('users', 'whitelist_requests.created_by', '=', 'users.id')
            ->where(function ($query) use ($searchKeyword) {
                $query->where(function ($q) use ($searchKeyword) {
                    $q->where('mobile_number', 'like', "%$searchKeyword%")
                        ->orWhere('status', 'like', "%$searchKeyword%")
                        ->orWhereHas('user', function ($q) use ($searchKeyword) {
                            $q->where('full_name', 'like', '%' . $searchKeyword . '%');
                        });
                });
            })->select('whitelist_requests.*', 'users.role_id', 'users.full_name', 'users.phone', 'users.email')->latest();

        // dd( $query);

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('user', function ($row) {
                $name = $row->full_name ?? '';
                $phone = $row->phone ?? '';
                $email = $row->email ?? '';
                $user = $name . '<br>' . $phone . '<br>' . $email;
                return $user;
            })
            ->addColumn('action', function ($row) {
                $approveBtn = '';
                $suspendBtn = '';

                if ($row->status != 'Active') {
                    $approveBtn = '<button type="button" data-id="' . $row->id . '" data-status="Active" class="btn btn-warning btn-sm ms-lg-2 approveWhitelistBtn">Approve</button>';
                } else {
                    $suspendBtn = '<button type="button" data-id="' . $row->id . '" data-status="Suspend" class="btn btn-danger btn-sm ms-lg-2 suspendWhitelistBtn">Suspend</button>';
                }

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $approveBtn . '
                            ' . $suspendBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action', 'user'])
            ->make(true);
    }

    public function updateWhitelistStatus(array $updateData, int $id): Model
    {
        // Find the whitelist by its ID or fail if not found.
        $whitelist = RequestWhitelist::query()->where('id', $id)->first();

        // Update the whitelist with the provided data.
        $whitelist->update($updateData);

        return $whitelist;
    }
}

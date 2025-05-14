<?php

namespace App\Services\User;

use App\Http\Requests\User\UserProfileRequest;
use App\Models\Payment\Account;
use App\Models\User;
use App\Traits\FileUploader;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserService
{
    use FileUploader;
    public function storeUserInfo(array $data): Model|Collection|Builder|JsonResponse
    {
        DB::beginTransaction();
        try {

            $data['password'] =  Hash::make($data['password']);

            $user = User::query()->create($data);

            $userId = (int) $user->id;

            $accountData = [
                'user_id' => $userId,
                'created_by' => $data['created_by'],
            ];

            $Account = Account::query()->create($accountData);

            DB::commit();

            return $user;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getUserList(Request $request): JsonResponse
    {
        $searchKeyword = $request->input('search');

        $query = User::query()->leftJoin('user_roles', function ($join) {
            $join->on('users.role_id', '=', 'user_roles.role_id');
        })->where(function ($query) use ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('full_name', 'like', "%$searchKeyword%")
                    ->orWhere('user_name', 'like', "%$searchKeyword%")
                    ->orWhere('email', 'like', "%$searchKeyword%")
                    ->orWhere('phone', 'like', "%$searchKeyword%")
                    ->orWhere('user_roles.role_name', 'like', "%$searchKeyword%");
            });
        })
            ->select('users.*', 'user_roles.role_name');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $changePassBtn = '<button data-id="' . $row->id . '" class="btn btn-warning btn-sm me-2 changePasswordBtn" data-bs-toggle="modal" data-bs-target="#kt_modal_change_password">Reset Password</button>';

                $editBtn = '<button data-id="' . $row->id . '" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm edit-user me-2" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit"></i></button>';
                return $editBtn . $changePassBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }


    public function getUserInfoById(int $userId): Model|Collection|Builder|array|null
    {
        return User::query()->where('id', $userId)->first();
    }

    public function updateUserInfo(array $updateData, int $userId): bool
    {
        $user = $this->getUserInfoById($userId);

        return $user->update($updateData);
    }

    public function resetPassword(Request $request, int $userId): bool
    {
        $user = $this->getUserInfoById($userId);

        $data['password'] =  Hash::make($request->password);

        return $user->update($data);
    }

    public function updateUserProfile(UserProfileRequest $request, int $userId): int
    {
        try {
            $data = $request->fields();

            $user = $this->getUserInfoById($userId);

            $data['profile_img'] = $this->updateMedia($request, 'profile_img', 'user/profile', $user['profile_img']);

            if (Auth::user()->id == $userId) {
                session()->put('logged_session_data.profile_img', $data['profile_img'] ?? $user['profile_img']);
                session()->put('logged_session_data.full_name', $data['full_name']);
                session()->put('logged_session_data.email', $data['email']);
                session()->put('logged_session_data.phone', $data['phone']);
            }
            $user->update($data);

            return $userId;
        } catch (Exception $exception) {
            throw $exception;
        }
    }
}

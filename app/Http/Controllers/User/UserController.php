<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserProfileRequest;
use App\Http\Requests\UserRequest;
use App\Models\Common\Master\UserRole;
use App\Models\Hrm\Employee\EmployeeDepartment;
use App\Models\User;
use App\Services\User\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function __construct(protected UserService $userService) {}

    public function index(Request $request): View|JsonResponse
    {
        $data['userRoles'] = UserRole::query()->orderBy('role_id', 'DESC')->get(['role_id', 'role_name']);

        if ($request->ajax()) {
            return $this->userService->getUserList($request);
        }

        return view('user.index', $data);
    }

    public function store(UserRequest $request): JsonResponse
    {
        try {

            $storeUserInfo = $this->userService->storeUserInfo($request->fields());

            return sendSuccessResponse(
                200,
                'User Created successfully.',
                'data',
                $storeUserInfo
            );
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }

    public function edit(int $userId): JsonResponse
    {
        try {
            $userInfo = $this->userService->getUserInfoById($userId);

            return sendSuccessResponse(200, '', 'userInfo', $userInfo);
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }

    public function update(UserRequest $request, int $userId): JsonResponse
    {
        try {

            $updateUserInfo = $this->userService->updateUserInfo($request->fields(), $userId);

            return sendSuccessResponse(
                200,
                'User updated successfully.',
                'data',
                $updateUserInfo
            );
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }

    public function resetPassword(Request $request, int $userId): JsonResponse
    {
        try {

            $updateUserInfo = $this->userService->resetPassword($request, $userId);

            return sendSuccessResponse(
                200,
                'User updated successfully.',
                'data',
                $updateUserInfo
            );
        } catch (Exception $exception) {
            return sendErrorResponse('Internal Server Error: ', $exception->getMessage(), $exception->getCode() ?? 500);
        }
    }

    public function viewProfile(): View
    {
        // Gate::authorize('user.profile.viewProfile');
        $userId = (int) getLoggedInUserInfo('logged_session_data.id');

        $data['personalInfoData'] = $this->userService->getUserInfoById($userId);
        // dd($data);
        return view('user.profile.index',$data);
    }

    public function editProfile(): View
    {
        // Gate::authorize('user.profile.editProfile');
        $userId = (int) getLoggedInUserInfo('logged_session_data.id');

        $data['editModeData'] = $this->userService->getUserInfoById($userId);
     
        return view('user.profile.edit', $data);
    }

    public function profileUpdate(UserProfileRequest $request, int $userId): RedirectResponse
    {
        // Gate::authorize('user.profile.editProfile');
        try {
            $this->userService->updateUserProfile($request, $userId);

            return redirect(route('user.profile.viewProfile'))->with(
                'success',
                'User profile updated successfully.'
            );
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function changePassword(): View
    {
        // Gate::authorize('user.profile.changePassword');

        return view('user.profile.changePassword');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        // Gate::authorize('user.profile.changePassword');

        $userId = Auth::user()->id;

        $userData = User::findOrFail($userId);

        $old_pass = $userData->password;

        $current_pass = $request->get('current_password');
        $new_pass = $request->get('new_password');
        $confirm_pass = $request->get('confirm_password');

        if (Hash::check($current_pass, $old_pass)) {
            if (!Hash::check($new_pass, $old_pass)) {
                if ($new_pass == $confirm_pass) {
                    $userData->password = Hash::make($new_pass);
                    $userData->update();

                    session()->flush();
                    return redirect('/')->with('success', 'Password updated successfully.');
                } else {
                    return back()->with('error', 'New password and confirm password does not matched');
                }
            }else{
                return back()->with('error', 'New password can not be same as old password.');
            }
        } else {
            return back()->with('error', 'Previous password is incorrect');
        }
    }
}

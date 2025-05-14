<?php

namespace App\Http\Controllers\Common\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Common\Master\UserRoleRequest;
use App\Services\Common\Master\UserRoleService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Gate;

class UserRoleController extends Controller
{
    public function __construct(protected UserRoleService $userRoleService)
    {
    }


    public function index(Request $request): View|JsonResponse
    {
        Gate::authorize('common.master.userRole.index');
        if ($request->ajax()) {
            return $this->userRoleService->getUserRoleList($request);
        }
        return view('common.master.userRole.index');
    }


    public function create(): View
    {
        Gate::authorize('common.master.userRole.create');

        return view('common.master.userRole.form');
    }


    public function store(UserRoleRequest $request): JsonResponse
    {
        Gate::authorize('common.master.userRole.create');
        try {

            $this->userRoleService->createUserRole($request->fields());

            // Redirect back with success message
            return sendSuccessResponse(201, 'User role created successfolly.');
        } catch (Exception $e) {
            // Redirect back with error message if an exception occurs
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit($userRoleId): JsonResponse
    {
        Gate::authorize('common.master.userRole.edit');

        $data = $this->userRoleService->getUserRoleById($userRoleId);

        return sendSuccessResponse(200, 'User role list fetch successfolly', 'userRole', $data);
    }

    public function update(UserRoleRequest $request, $userRoleId): JsonResponse
    {
        Gate::authorize('common.master.userRole.edit');
        try {

            $this->userRoleService->updateUserRole($request->fields(), $userRoleId);


            return sendSuccessResponse(200, 'User role updated successfolly.');
        } catch (\Exception $e) {
            // Redirect back with error message if an exception occurs
            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }


    public function updateStatus(Request $request): JsonResponse
    {

        $userRoleId = $request->input('role_id');
        $active = $request->input('active');

        try {

            $this->userRoleService->updateUserRole(['active' => $active], $userRoleId);

            return sendSuccessResponse(200, 'User role status updated successfolly.');
        } catch (\Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage(), $e->getCode() ?? 500);
        }
    }
}

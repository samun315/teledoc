<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Doctor\DoctorFeeRequest;
use App\Services\Doctor\DoctorFeeService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorFeeController extends Controller
{
    public function __construct(protected DoctorFeeService $doctorFeeService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->doctorFeeService->getDoctorFeeList($request);
        }

        return view('doctor.fee.index');
    }

    public function edit(int $doctorId): View
    {
        $data['editModeData'] = $this->doctorFeeService->getDoctorForEditById($doctorId);

        return view('doctor.fee.create', $data);
    }

    public function update(DoctorFeeRequest $request, int $doctorId): RedirectResponse
    {
        try {
            $this->doctorFeeService->updateDoctorFee($request, $doctorId);

            return to_route('doctor.fee.index')->with(
                'success',
                'Doctor fee configuration updated successfully.'
            );
        } catch (Exception $exception) {
            return back()->with('error', $exception->getMessage());
        }
    }
}

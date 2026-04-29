<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorAppointment;
use App\Models\Patient\Patient;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $data = [
            'totalPatients' => Patient::count(),
            'pendingAppointments' => DoctorAppointment::whereRaw('LOWER(appointment_status) = ?', ['pending'])->count(),
            'totalDoctors' => Doctor::count(),
        ];

        return view('dashboard.index', $data);
    }
}

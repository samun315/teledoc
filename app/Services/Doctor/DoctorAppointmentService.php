<?php

namespace App\Services\Doctor;

use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorAppointment;
use App\Models\Doctor\DoctorSchedule;
use App\Models\Drug\DrugType;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Patient\Patient;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DoctorAppointmentService
{
    public function getAppointmentList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');
        $filterDate = $request->input('filter_date');

        $query = DoctorAppointment::query()
            ->leftJoin('doctors', 'appointments.doctor_id', '=', 'doctors.doctor_id')
            ->leftJoin('departments', 'doctors.department_id', '=', 'departments.department_id')
            ->leftJoin('patients', 'appointments.patient_id', '=', 'patients.patient_id')
            ->leftJoin('order_items', function($join) {
                $join->on('order_items.reference_id', '=', 'appointments.appointment_id')
                     ->where('order_items.item_type', '=', 'CONSULTATION');
            })
            ->leftJoin('orders', 'order_items.order_id', '=', 'orders.order_id')
            ->select(
                'appointments.*',
                'patients.name as patient_name',
                'patients.patient_id_number as patient_id_number',
                'patients.email as patient_email',
                'patients.phone as patient_phone',
                'patients.date_of_birth as patient_dob',
                'patients.photo as patient_photo',
                'patients.gender as patient_gender',
                'patients.blood_group as patient_blood_group',
                'patients.marital_status as patient_marital_status',
                'doctors.name as doctor_name',
                'doctors.title as doctor_title',
                'doctors.phone as doctor_phone',
                'departments.department_name',
                'orders.status as order_status',
                'orders.order_id as order_id',
                DB::raw('(SELECT p.prescription_id FROM prescriptions p WHERE p.appointment_id = appointments.appointment_id ORDER BY p.prescription_id DESC LIMIT 1) as linked_prescription_id'),
            )->latest();

        if ($searchKeyword) {
            $query->where('patients.name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('appointments.appointment_status', 'like', '%' . $searchKeyword . '%')
                ->orWhere('doctors.name', 'like', '%' . $searchKeyword . '%');
        }

        if (is_string($filterDate) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $filterDate)) {
            $query->whereDate('appointments.appointment_date', $filterDate);
        }

        // $query->orderBy('orders');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('date_of_appointment', function ($row) {
                if (!$row->appointment_date || !$row->slot_time) {
                    return '-';
                }

                // Convert slot_time to 12-hour format with AM/PM
                $slotTime = Carbon::createFromFormat('H:i', $row->slot_time)->format('h:i A');

                // Wrap slot time in a badge
                $slotBadge = '<span class="badge bg-success ms-2">' . $slotTime . '</span>';

                // Concatenate appointment_date and slot badge
                return '<strong>' . $row->appointment_date . '</strong> ' . $slotBadge;
            })
            ->addColumn('doctor_info', function ($row) {
                return "
                <i class='fas fa-user text-primary'></i> : {$row->doctor_title} {$row->doctor_name}<br>
                <i class='fas fa-phone text-dark'></i> : {$row->doctor_phone}<br>
                <p class='badge badge-info'>{$row->department_name}</p>
                ";
            })
            ->addColumn('patient_info', function ($row) {
                $photoPath = !empty($row->patient_photo)
                    ? 'uploads/patient/' . $row->patient_photo
                    : 'assets/media/avatars/blank.png';

                $photo = '<img src="' . $photoPath . '" alt="Patient" class="rounded-circle me-2" width="60" height="60">';

                $name = e($row->patient_name ?? '');
                $idNumber = e($row->patient_id_number ?? '');
                $phoneRaw = $row->patient_phone ?? '';
                $phone = $phoneRaw !== '' ? e($phoneRaw) : '—';

                $ageLabel = '—';
                if (!empty($row->patient_dob)) {
                    try {
                        $ageLabel = (string) Carbon::parse($row->patient_dob)->age;
                    } catch (Exception $e) {
                        $ageLabel = '—';
                    }
                }

                return '
                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            ' . $photo . '
                        </div>
                        <div>
                            <div class="fw-bold">' . $name . '</div>
                            <div class="text-muted fs-7">ID: ' . $idNumber . '</div>
                            <div class="fs-7">Age: ' . e($ageLabel) . '</div>
                            <div class="fs-7"><i class="fas fa-phone text-dark me-1"></i>' . $phone . '</div>
                        </div>
                    </div>';
            })
            ->addColumn('payment_status', function ($row) {
                $orderStatus = $row->order_status ?? null;
                $orderId = $row->order_id ?? null;
                $appointmentId = $row->appointment_id ?? null;

                if (!$orderStatus || !$orderId) {
                    // If no order exists, show message or create order button
                    if ($appointmentId) {
                        return '<span class="badge badge-warning">No Order</span><br>
                                <small class="text-muted">Order not created</small>';
                    }
                    return '<span class="badge badge-secondary">No Order</span>';
                }

                // If status is PENDING, show "Make Payment" button with modal trigger
                if (strtoupper($orderStatus) === 'PENDING' && $orderId && $orderId > 0) {
                    return '<button type="button" class="btn btn-sm btn-primary make-payment-btn" data-order-id="' . (int)$orderId . '" title="Order ID: ' . (int)$orderId . '">
                                <i class="fas fa-credit-card"></i> Make Payment
                            </button>';
                }

                // For other statuses, show badge
                $badgeClass = '';
                switch (strtoupper($orderStatus)) {
                    case 'PAID':
                        $badgeClass = 'badge-success';
                        break;
                    case 'CANCELLED':
                        $badgeClass = 'badge-danger';
                        break;
                    case 'FAILED':
                        $badgeClass = 'badge-danger';
                        break;
                    case 'REFUNDED':
                        $badgeClass = 'badge-info';
                        break;
                    default:
                        $badgeClass = 'badge-secondary';
                }

                return '<span class="badge ' . $badgeClass . '">' . ucfirst(strtolower($orderStatus)) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $status = $row->appointment_status ?? '';

                if (strcasecmp((string) $status, 'Completed') === 0) {
                    $prescriptionId = $row->linked_prescription_id ?? null;
                    if ($prescriptionId) {
                        $viewUrl = route('drug.prescription.edit', $prescriptionId);

                        return '<div class="btn-group" role="group" aria-label="Prescription actions">
                            <a href="' . $viewUrl . '" class="btn btn-icon btn-bg-light btn-active-light-primary btn-sm" title="View prescription"><i class="fas fa-eye text-primary"></i></a>
                            </div>';
                    }

                    return '<span class="text-muted fs-8">No prescription</span>';
                }

                $editBtn = '<a href="' . route('appointment.edit', $row->appointment_id) . '" class="btn btn-icon btn-bg-info text-white btn-sm"><i class="fas fa-edit text-white"></i></a>';

                $prescriptionBtn = '<a href="' . route('drug.prescription.create', $row->patient_id) . '?doctor_id=' . $row->doctor_id . '&appointment_id=' . $row->appointment_id . '" class="btn btn-icon btn-bg-success text-white btn-sm ms-2" title="Create Prescription"><i class="fas fa-file-prescription text-white"></i></a>';

                return '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            ' . $prescriptionBtn . '
                            </div>';
            })
            ->rawColumns(['date_of_appointment', 'doctor_info', 'patient_info', 'payment_status', 'action'])
            ->make(true);
    }

    public function createDoctorAppointment(array $data): Model|Builder
    {
        DB::beginTransaction();

        try {
            // 1. Doctor-slot-date overlap check
            $doctorSlotExists = DoctorAppointment::query()
                ->where('doctor_id', $data['doctor_id'])
                ->where('patient_id', $data['patient_id'])
                ->where('appointment_date', $data['appointment_date'])
                ->where('slot_id', $data['slot_id'])
                ->exists();

            if ($doctorSlotExists) {
                throw new Exception("This slot is already booked for the selected doctor on {$data['appointment_date']}.");
            }

            $data['appointment_code'] = $this->generateAppointmentCode('appointments');
            // Create appointment
            $appointment = DoctorAppointment::query()->create([
                'doctor_id'        => $data['doctor_id'],
                'patient_id'       => $data['patient_id'],
                'appointment_code' => $data['appointment_code'],
                'appointment_date' => $data['appointment_date'],
                'slot_id'          => $data['slot_id'],
                'slot_time'        => $data['slot_time'],
                'created_by'       => $data['created_by'],
                'created_at'       => $data['created_at'],
            ]);

            // Get doctor information for consultation fee
            $doctor = Doctor::findOrFail($data['doctor_id']);
            $consultationFee = $doctor->consultation_fee ?? 0;

            // Generate order number
            $orderNo = $this->generateOrderNumber();

            // Get logged in user id
            $userId = loggedInUserId();

            // Create order
            $order = Order::create([
                'order_no' => $orderNo,
                'user_id' => $userId,
                'doctor_id' => $data['doctor_id'],
                'order_type' => 'CONSULTATION',
                'subtotal' => $consultationFee,
                'discount' => 0,
                'tax' => 0,
                'total_amount' => $consultationFee,
                'status' => 'PENDING',
                'created_at' => $data['created_at'],
            ]);

            // Create order item for consultation
            OrderItem::create([
                'order_id' => $order->order_id,
                'item_type' => 'CONSULTATION',
                'reference_id' => $appointment->appointment_id,
                'item_name' => 'Consultation - ' . $doctor->title . ' ' . $doctor->name,
                'quantity' => 1,
                'unit_price' => $consultationFee,
                'total_price' => $consultationFee,
                'created_at' => $data['created_at'],
            ]);

            DB::commit();

            return $appointment;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function generateAppointmentCode(string $tableName)
    {
        // আজকের তারিখ YYMMDD format
        $date = Carbon::now()->format('ymd'); // e.g., 250914

        // আজকের ticket এর সংখ্যা
        $countToday = DB::table($tableName)
            ->whereDate('created_at', Carbon::today())
            ->count();

        // Incremental number (start from 1 every day)
        $incremental = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT); // 001, 002, ...

        // Final ticket number
        return 'A-' . $date . '-' . $incremental;
    }

    public function generateOrderNumber(): string
    {
        // আজকের তারিখ YYMMDD format
        $date = Carbon::now()->format('ymd'); // e.g., 250115

        // আজকের order এর সংখ্যা
        $countToday = Order::whereDate('created_at', Carbon::today())->count();

        // Incremental number (start from 1 every day)
        $incremental = str_pad($countToday + 1, 4, '0', STR_PAD_LEFT); // 0001, 0002, ...

        // Final order number: ORD-YYMMDD-XXXX
        return 'ORD-' . $date . '-' . $incremental;
    }

    public function getDoctorInfoById(int $doctorId): Model|Builder
    {
        return Doctor::query()->with('department')->find($doctorId);
    }

    public function getPatientInfoById(int $patientId): Model|Builder
    {
        return Patient::query()->find($patientId);
    }

    public function getAppointmentById(int $appointmentId): Model|Builder|Collection
    {
        return DoctorAppointment::query()->with('doctor', 'patient')->where('appointment_id', $appointmentId)->first();
    }

    public function updateAppointment(array $data, int $appointmentId): DoctorAppointment
    {
        DB::beginTransaction();

        try {

            // overlap check (নিজের ছাড়া)
            $doctorSlotExists = DoctorAppointment::query()
                ->where('doctor_id', $data['doctor_id'])
                ->where('patient_id', $data['patient_id'])
                ->where('appointment_date', $data['appointment_date'])
                ->where('slot_id', $data['slot_id'])
                ->where('appointment_id', '!=', $appointmentId)
                ->exists();

            if ($doctorSlotExists) {
                throw new Exception("This slot is already booked for the selected doctor on {$data['appointment_date']}.");
            }

            // বর্তমান appointment বের করা
            $appointment = DoctorAppointment::findOrFail($appointmentId);

            // ✅ check same info (কোনো পরিবর্তন নাই কিনা)
            $sameData =
                $appointment->doctor_id == $data['doctor_id'] &&
                $appointment->patient_id == $data['patient_id'] &&
                $appointment->appointment_date == $data['appointment_date'] &&
                $appointment->slot_id == $data['slot_id'] &&
                $appointment->slot_time == $data['slot_time'];

            if ($sameData) {
                throw new Exception("No changes found. Appointment is already booked with the same details.");
            }

            // update data
            $appointment->update([
                'doctor_id'       => $data['doctor_id'],
                'patient_id'      => $data['patient_id'],
                'appointment_date' => $data['appointment_date'],
                'slot_id'         => $data['slot_id'],
                'slot_time'       => $data['slot_time'],
                'updated_by'      => $data['updated_by'] ?? null,
                'updated_at'      => now(),
            ]);

            DB::commit();

            return $appointment;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}

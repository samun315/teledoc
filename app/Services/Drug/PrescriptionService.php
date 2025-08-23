<?php

namespace App\Services\Drug;

use App\Models\Drug\DrugDoses;
use App\Models\Drug\Prescription;
use App\Models\Drug\PrescriptionClinicalRecord;
use App\Models\Drug\PrescriptionMedication;
use App\Models\Drug\Subscription;
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

class PrescriptionService
{
    public function getPrescriptionList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = Prescription::query()
            ->leftJoin('patients', 'prescriptions.patient_id', '=', 'patients.patient_id')
            ->leftJoin('doctors', 'prescriptions.doctor_id', '=', 'doctors.doctor_id')
            ->select('prescriptions.*', 'patients.name as patient_name', 'patients.email as patient_email', 'patients.phone as patient_phone', 'patients.date_of_birth as patient_dob', 'patients.photo as patient_photo', 'patients.gender as patient_gender', 'patients.blood_group as patient_blood_group', 'patients.marital_status as patient_marital_status', 'doctors.name as doctor_name')->latest();

        if ($searchKeyword) {
            $query->where('patients.name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('subscriptions.status', 'like', '%' . $searchKeyword . '%')
                ->orWhere('doctors.name', 'like', '%' . $searchKeyword . '%');
        }


        // $query->orderBy('orders');

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('info', function ($row) {
                $photoPath = !empty($row->patient_photo)
                    ? 'uploads/patient/' . $row->patient_photo
                    : 'assets/media/avatars/blank.png';

                $photo = '<img src="' . $photoPath . '" alt="Patient" class="rounded-circle me-2" width="60" height="60">';

                $name = $row->patient_name ?? '';
                $gender = $row->patient_gender ?? '';
                $blood_group = $row->patient_blood_group ?? '';
                $marital_status = $row->patient_marital_status ?? '';
                $dob = $row->patient_dob ?? '';
                $email = $row->patient_email ?? '';
                $phone = $row->patient_phone ?? '';

                $info = '
                    <div class="d-flex align-items-start">
                        <div class="me-3">
                            ' . $photo . '
                        </div>
                        <div>
                            <div><i class="fas fa-venus-mars text-danger"></i> :' . $gender . ',
                            <i class="fas fa-tint text-danger ms-1"></i> :' . $blood_group . '</div>
                            <div><i class="fas fa-ring text-warning"></i> :' . $marital_status . '</div>
                            <div><i class="fas fa-calendar-day text-success"></i> :' . $dob . '</div>
                            <div><i class="fas fa-envelope text-primary"></i> :' . $email . '</div>
                            <div><i class="fas fa-phone text-dark"></i> :' . $phone . '</div>
                        </div>
                    </div>';

                return $info;
            })
            ->addColumn('action', function ($row) {

                $editBtn = '<a href="' . route('drug.prescription.edit', $row->prescription_id) . '" class="btn btn-icon btn-bg-info text-white btn-sm"><i class="fas fa-edit text-white"></i></a>';

                $excelBtn = '<button type="button" class="btn btn-icon btn-sm ms-2 btn-success"><i class="fas fa-print"></i></button>';
                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            ' . $excelBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['info', 'action'])
            ->make(true);
    }

    public function createPrescription(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $medicationData = [];
            $clinicalData = [];

            // generate prescription number
            $data['prescription_number'] = $this->generatePrescriptionNumber();

            // make prescription data
            $prescriptionData = [
                'prescription_number' => $data['prescription_number'],
                'patient_id' => $data['patient_id'],
                'doctor_id' => $data['doctor_id'],
                'appointment_id' => 1,
                'created_by' => $data['created_by'],
                'created_at' => $data['created_at'],
            ];

            $prescription = Prescription::query()->create($prescriptionData);

            // make prescription medicaiton data
            if (!empty($data['drug_type_id'])) {
                foreach ($data['drug_type_id'] as $index => $drugTypeId) {

                    $medicationData[$index] = [
                        'prescription_id' => $prescription->prescription_id,
                        'drug_type_id' => $drugTypeId,
                        'drug_id' => $data['drug_id'][$index],
                        'drug_strength_id' => $data['drug_strength_id'][$index],
                        'drug_dose_id' => $data['drug_dose_id'][$index],
                        'drug_duration_id' => $data['drug_duration_id'][$index],
                        'drug_advice_id' => $data['drug_advice_id'][$index],
                        'created_by' => loggedInUserId(),
                        'created_at' => createdAtDateConvertToDB(),
                    ];
                }
            }

            // make prescription clinical data
            if (!empty($data['subscription_details'])) {
                foreach ($data['subscription_type_id'] as $key => $subscriptionTypeId) {
                    // Check jekhane subscription_details er oi index e value thakbe
                    if (isset($data['subscription_details'][$key]) && trim($data['subscription_details'][$key]) !== '') {
                        $clinicalData[$key] = [
                            'prescription_id' => $prescription->prescription_id,
                            'subscription_type_id' => $subscriptionTypeId,
                            'subscription_details' => $data['subscription_details'][$key],
                            'created_by' => loggedInUserId(),
                            'created_at' => createdAtDateConvertToDB(),
                        ];
                    }
                }
            }

            if (!empty($medicationData)) {
                PrescriptionMedication::query()->insert($medicationData);
            }

            if (!empty($clinicalData)) {
                PrescriptionClinicalRecord::query()->insert($clinicalData);
            }

            DB::commit();

            return $prescription;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    function generatePrescriptionNumber(): string
    {
        $now = Carbon::now();

        // Format date part: MMDDYY (month day year last two digits)
        $datePart = $now->format('mdy'); // e.g. 080425

        // Count how many prescriptions created today
        $countToday = DB::table('prescriptions')
            ->whereDate('created_at', $now->toDateString())
            ->count();

        // Increment count for current prescription
        $countToday++;

        // Format count with leading zeros, 3 digits
        $countPart = str_pad($countToday, 3, '0', STR_PAD_LEFT);

        // Compose final prescription number
        return "P-{$datePart}-{$countPart}";
    }

    public function getPatientList(): Collection
    {
        return Patient::query()->where('active', 'YES')->get();
    }

    public function getSubscriptionList(int $subscriptionTypeId): Collection
    {
        return Subscription::query()->where('subscription_type_id', $subscriptionTypeId)->where('status', 'Active')->get();
    }


    public function createSubscription(Request $request, int $subscriptionTypeId): Model
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'subscription_type_id' => 'nullable|exists:subscription_types,subscription_type_id',
                'subscription_name' => 'required|string',
            ]);

            $subscription = Subscription::create([
                'subscription_type_id' => $subscriptionTypeId,
                'subscription_name' => $request->subscription_name,
            ]);
            DB::commit();

            return $subscription;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getDoctorPrescriptionList(int $doctorId, int $patientId): Collection
    {
        return Prescription::query()
            ->leftJoin('prescription_medications', 'prescriptions.prescription_id', '=', 'prescription_medications.prescription_id')
            ->leftJoin('drug_types', 'prescription_medications.drug_type_id', '=', 'drug_types.drug_type_id')
            ->leftJoin('drugs', 'prescription_medications.drug_id', '=', 'drugs.drug_id')
            ->leftJoin('drug_strengths', 'prescription_medications.drug_strength_id', '=', 'drug_strengths.drug_strength_id')
            ->leftJoin('drug_durations', 'prescription_medications.drug_duration_id', '=', 'drug_durations.drug_duration_id')
            ->leftJoin('drug_doses', 'prescription_medications.drug_dose_id', '=', 'drug_doses.drug_dose_id')
            ->leftJoin('drug_advices', 'prescription_medications.drug_advice_id', '=', 'drug_advices.drug_advice_id')
            ->where('prescriptions.doctor_id', $doctorId)
            ->where('prescriptions.patient_id', $patientId)
            ->select('prescription_medications.*', 'drug_types.drug_type', 'drugs.trade_name', 'drug_strengths.drug_strength', 'drug_durations.drug_duration', 'drug_doses.drug_dose', 'drug_advices.drug_advice')
            ->get();
    }

    public function getOldPrescriptionList(int $prescriptionId): Collection
    {
        return Prescription::query()
            ->leftJoin('prescription_medications', 'prescriptions.prescription_id', '=', 'prescription_medications.prescription_id')
            ->leftJoin('drug_types', 'prescription_medications.drug_type_id', '=', 'drug_types.drug_type_id')
            ->leftJoin('drugs', 'prescription_medications.drug_id', '=', 'drugs.drug_id')
            ->leftJoin('drug_strengths', 'prescription_medications.drug_strength_id', '=', 'drug_strengths.drug_strength_id')
            ->leftJoin('drug_durations', 'prescription_medications.drug_duration_id', '=', 'drug_durations.drug_duration_id')
            ->leftJoin('drug_doses', 'prescription_medications.drug_dose_id', '=', 'drug_doses.drug_dose_id')
            ->leftJoin('drug_advices', 'prescription_medications.drug_advice_id', '=', 'drug_advices.drug_advice_id')
            ->where('prescriptions.prescription_id', $prescriptionId)
            ->select('prescription_medications.*', 'prescriptions.created_at as prescription_date', 'drug_types.drug_type', 'drugs.trade_name', 'drug_strengths.drug_strength', 'drug_durations.drug_duration', 'drug_doses.drug_dose', 'drug_advices.drug_advice')
            ->get();
    }


    public function getDrugDoseByType(int $drugTypeId): Collection
    {
        return DrugDoses::query()->where('drug_type_id', $drugTypeId)->where('status', 'Active')->get();
    }


    public function getPrescriptionInfoById(int $prescriptionId): Model|Builder
    {
        return Prescription::query()->with('medication', 'clinicalRecord')->where('prescription_id', $prescriptionId)->first();
    }

    public function updateSubscription(array $updateData, int $prescriptionId): int
    {
        $subscription = $this->getPrescriptionInfoById($prescriptionId);

        return $subscription->update($updateData);
    }
}

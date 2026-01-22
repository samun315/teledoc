<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogCategory;
use App\Models\Doctor\Doctor;
use App\Models\Doctor\DoctorDepartment;
use App\Models\Doctor\DoctorAppointment;
use App\Models\Doctor\DoctorSchedule;
use App\Models\Patient\Patient;
use App\Models\Slider\Slider;
use App\Models\Service\Service;
use App\Models\Speciality\Speciality;
use App\Models\Testimonial\Testimonial;
use App\Models\Faq\Faq;
use App\Models\About\About;
use App\Models\Expertise\Expertise;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class FrontendController extends Controller
{
    function homePage(){
        // Fetch active sliders for home page
        $sliders = Slider::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        // Fetch 3 latest published blogs for home page
        $latestBlogs = Blog::where('status', 'Published')
            ->latest('published_at')
            ->take(3)
            ->get();
        // Fetch all active services
        $services = Service::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        // Fetch 3 active doctors for home page
        $doctors = Doctor::with(['department', 'degrees'])
            ->where('status', 'Active')
            ->inRandomOrder()
            ->take(3)
            ->get();

        // Fetch active about section
        $about = About::where('status', 'Active')->first();

        // Fetch active expertise section
        $expertise = Expertise::where('status', 'Active')->first();

        return view('frontend.home', compact('sliders', 'latestBlogs', 'services', 'doctors', 'about', 'expertise'));
    }

    function homePage2(){
        //dd('test');
        return view('frontend.welcomePage2');
    }

    function contactUs(){
        return view('frontend.contactUs');
    }

    function about(){
        // Fetch 3 latest published blogs for home page
        $latestBlogs = Blog::where('status', 'Published')
            ->latest('published_at')
            ->take(3)
            ->get();
        // Fetch all active services
        $services = Service::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
        // Fetch all active specialities
        $specialities = Speciality::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
        // Fetch all active testimonials
        $testimonials = Testimonial::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
        // Fetch active about section
        $about = About::where('status', 'Active')->first();

        return view('frontend.about', compact('latestBlogs', 'services', 'specialities', 'testimonials', 'about'));
    }

    function blog(){
        // Fetch active blog posts with relationships
        $blogs = Blog::with(['category', 'tags'])
            ->where('status', 'Published')
            ->latest('published_at')
            ->paginate(9);

        return view('frontend.blog', compact('blogs'));
    }

    function blogDetails($slug){
        // Fetch blog post by slug with relationships
        $blog = Blog::with(['category', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail(); // Returns 404 if not found

        // Recent blogs (3 latest, excluding current)
        $recentBlogs = Blog::where('status', 'Published')
            ->where('blog_id', '!=', $blog->blog_id)
            ->latest('created_at')
            ->take(3)
            ->get();

        // All categories
        $categories = BlogCategory::where('status', 'Active')
            ->get();

        return view('frontend.blogDetails', compact('blog', 'recentBlogs', 'categories'));
    }

    public function service(){
        // Fetch all active services
        $services = Service::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        $expertise = Expertise::where('status', 'Active')->first();

        return view('frontend.service', compact('services', 'expertise'));
    }

    public function serviceDetails($id){
        // Fetch service by ID
        $service = Service::where('service_id', $id)
            ->where('status', 'Active')
            ->firstOrFail(); // Returns 404 if not found

        // Fetch all active services
        $services = Service::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        // Fetch 3 latest blogs
        $latestBlogs = Blog::where('status', 'Published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.serviceDetails', compact('service', 'latestBlogs', 'services'));
    }

    public function faqs(){
        // Fetch all active FAQs
        $faqs = Faq::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        return view('frontend.faq', compact('faqs'));
    }

    public function doctors(Request $request){
        // Get search and filter parameters
        $searchKeyword = $request->input('search');
        $departmentId = $request->input('department_id');

        // Query active doctors with relationships
        $query = Doctor::with(['department', 'degrees'])
            ->where('status', 'Active');

        // Apply search filter
        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('name', 'like', "%{$searchKeyword}%")
                    ->orWhere('title', 'like', "%{$searchKeyword}%")
                    ->orWhere('email', 'like', "%{$searchKeyword}%");
            });
        }

        // Apply department filter
        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        // Get paginated doctors
        $doctors = $query->orderBy('name', 'asc')->paginate(12);

        // Get all active departments for filter dropdown
        $departments = DoctorDepartment::where('status', 'Active')
            ->orderBy('department_name', 'asc')
            ->get(['department_id', 'department_name']);

        return view('frontend.doctors', compact('doctors', 'departments'));
    }

    public function doctorDetails($id){
        // Fetch doctor with relationships
        $doctor = Doctor::with(['department', 'degrees', 'schedules' => function($query) {
            $query->where('status', 'Active')->orderBy('start_time', 'asc');
        }])
        ->where('doctor_id', $id)
        ->where('status', 'Active')
        ->firstOrFail();

        // Group schedules by day of week
        $schedulesByDay = $doctor->schedules->groupBy('day_of_week');

        // Define day order
        $dayOrder = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

        // Sort days according to week order
        $orderedSchedules = collect();
        foreach ($dayOrder as $day) {
            if ($schedulesByDay->has($day)) {
                $orderedSchedules->put($day, $schedulesByDay->get($day));
            }
        }

        return view('frontend.doctorDetails', compact('doctor', 'orderedSchedules'));
    }

    public function appointment(Request $request)
    {
        $selectedDoctorId = $request->input('doctor_id');
        $selectedDoctor = null;

        if ($selectedDoctorId) {
            $selectedDoctor = Doctor::with(['department', 'degrees'])
                ->where('doctor_id', $selectedDoctorId)
                ->where('status', 'Active')
                ->first();
        }

        // Get all active departments for filter
        $departments = DoctorDepartment::where('status', 'Active')
            ->orderBy('department_name', 'asc')
            ->get(['department_id', 'department_name']);

        return view('frontend.appointment', compact('selectedDoctor', 'departments'));
    }

    public function getDoctors(Request $request): JsonResponse
    {
        $searchKeyword = $request->input('search');
        $departmentId = $request->input('department_id');

        $query = Doctor::with(['department', 'degrees'])
            ->where('status', 'Active');

        if ($searchKeyword) {
            $query->where(function ($q) use ($searchKeyword) {
                $q->where('name', 'like', "%{$searchKeyword}%")
                    ->orWhere('title', 'like', "%{$searchKeyword}%")
                    ->orWhere('email', 'like', "%{$searchKeyword}%");
            });
        }

        if ($departmentId) {
            $query->where('department_id', $departmentId);
        }

        $doctors = $query->orderBy('name', 'asc')->get();

        $doctorsData = $doctors->map(function ($doctor) {
            $photoPath = $doctor->photo ? asset('uploads/doctor/' . $doctor->photo) : asset('assets/img/home-one/doctor/1.jpg');

            return [
                'doctor_id' => $doctor->doctor_id,
                'name' => $doctor->name,
                'title' => $doctor->title,
                'photo' => $photoPath,
                'department' => $doctor->department->department_name ?? 'General',
                'email' => $doctor->email,
                'phone' => $doctor->phone,
                'address' => $doctor->address,
                'description' => $doctor->description,
            ];
        });

        return response()->json([
            'success' => true,
            'doctors' => $doctorsData
        ]);
    }

    public function getAvailableSlots($doctorId, $date): JsonResponse
    {
        try {
            $dayOfWeek = Carbon::parse($date)->format('l');

            // Get all schedules for that doctor on the given day
            $schedules = DoctorSchedule::where('doctor_id', $doctorId)
                ->where('day_of_week', $dayOfWeek)
                ->where('status', 'Active')
                ->get();

            if ($schedules->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No schedules available for this doctor on ' . $dayOfWeek,
                    'slots' => []
                ]);
            }

            // Get all booked slot IDs for this doctor on this date
            $bookedSlotIds = DoctorAppointment::where('doctor_id', $doctorId)
                ->where('appointment_date', $date)
                ->pluck('slot_id')
                ->toArray();

            $slots = [];
            $slotId = 1;

            foreach ($schedules as $schedule) {
                $start = Carbon::parse($schedule->start_time);
                $end = Carbon::parse($schedule->end_time);
                $duration = (int) $schedule->slot_duration_minutes;

                while ($start->lt($end)) {
                    $slotEnd = (clone $start)->addMinutes($duration);

                    if ($slotEnd->lte($end)) {
                        $isBooked = in_array($slotId, $bookedSlotIds);

                        $slots[] = [
                            'slot_id' => $slotId,
                            'start' => $start->format('H:i'),
                            'end' => $slotEnd->format('H:i'),
                            'start_formatted' => $start->format('h:i A'),
                            'end_formatted' => $slotEnd->format('h:i A'),
                            'is_booked' => $isBooked,
                        ];
                        $slotId++;
                    }

                    $start->addMinutes($duration);
                }
            }

            return response()->json([
                'success' => true,
                'date' => $date,
                'doctor_id' => $doctorId,
                'slots' => $slots
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'slots' => []
            ], 500);
        }
    }

    public function storeAppointment(Request $request): JsonResponse
    {
        try {
            $validationRules = [
                'doctor_id' => 'required|exists:doctors,doctor_id',
                'appointment_date' => 'required|date|after_or_equal:today',
                'slot_id' => 'required|integer',
                'slot_time' => 'required|string',
                'patient_email' => 'nullable|email|max:255',
                'additional_notes' => 'nullable|string|max:1000',
                'is_registered' => 'nullable|boolean',
            ];

            // Conditional validation based on patient type
            // Handle string "1" or "0" as well as boolean
            $isRegistered = filter_var($request->is_registered, FILTER_VALIDATE_BOOLEAN);

            // Convert empty string to null for patient_id
            if ($request->has('patient_id') && ($request->patient_id === '' || $request->patient_id === null)) {
                $request->merge(['patient_id' => null]);
            }

            if ($isRegistered) {
                // For registered patients, patient_id is required
                $validationRules['patient_id'] = 'required|exists:patients,patient_id';
                $validationRules['patient_phone'] = 'nullable|string|max:20';
                $validationRules['patient_name'] = 'nullable|string|max:255';
            } else {
                // For new/guest patients, name and phone are required
                // patient_id is NOT validated - it will be created on the backend
                $validationRules['patient_name'] = 'required|string|max:255';
                $validationRules['patient_phone'] = 'required|string|max:20';
                // Don't include patient_id in validation for new patients
            }

            $request->validate($validationRules);

            DB::beginTransaction();

            // Check if slot is already booked
            $existingAppointment = DoctorAppointment::where('doctor_id', $request->doctor_id)
                ->where('appointment_date', $request->appointment_date)
                ->where('slot_id', $request->slot_id)
                ->first();

            if ($existingAppointment) {
                return response()->json([
                    'success' => false,
                    'message' => 'This time slot is already booked. Please select another time.'
                ], 400);
            }

            $patientId = null;
            $patientIdNumber = null;

            // Handle patient (registered or non-registered)
            // Check if is_registered is true (handle string "1" or boolean true)
            $isRegistered = filter_var($request->is_registered, FILTER_VALIDATE_BOOLEAN);

            if ($isRegistered && $request->patient_id) {
                // Registered patient
                $patientId = $request->patient_id;
                $patient = Patient::find($patientId);

                if (!$patient) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Patient not found.'
                    ], 404);
                }

                $patientIdNumber = $patient->patient_id_number ?? null;
            } else {
                // Non-registered patient - check if phone already exists
                $existingPatient = Patient::where('phone', $request->patient_phone)->first();

                if ($existingPatient) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'This phone number is already used for another patient. Please try a different phone number.'
                    ], 400);
                }

                // Generate patient_id_number
                $totalPatient = Patient::query()->count();
                $patientIdNumber = 'P' . sprintf("%06d", $totalPatient + 1);

                // Create new patient
                $patient = Patient::create([
                    'name' => $request->patient_name,
                    'phone' => $request->patient_phone,
                    'email' => $request->patient_email,
                    'patient_id_number' => $patientIdNumber,
                    'active' => 'YES',
                ]);

                // Refresh to ensure patient_id is available
                $patient->refresh();

                // Ensure patient_id is set
                $patientId = $patient->patient_id ?? $patient->getKey();

                if (!$patientId) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => 'Failed to retrieve patient ID. Please try again.'
                    ], 400);
                }
            }

            // Validate that patient_id is set
            if (!$patientId) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create or retrieve patient. Please try again.'
                ], 400);
            }

            // Generate appointment code
            $appointmentCode = $this->generateAppointmentCode();

            // Create appointment - ensure patient_id is set
            $appointmentData = [
                'doctor_id' => $request->doctor_id,
                'patient_id' => $patientId,
                'appointment_code' => $appointmentCode,
                'appointment_date' => $request->appointment_date,
                'slot_id' => $request->slot_id,
                'slot_time' => $request->slot_time,
                'appointment_status' => 'Pending',
                'payment_status' => 'Pending',
            ];

            // Validate appointment data before creating
            if (empty($appointmentData['patient_id'])) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Patient ID is required to create appointment.'
                ], 400);
            }

            $appointment = DoctorAppointment::create($appointmentData);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully!',
                'appointment_code' => $appointmentCode,
                'patient_id_number' => $patientIdNumber,
                'appointment_id' => $appointment->appointment_id
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function generateAppointmentCode(): string
    {
        $date = Carbon::now()->format('ymd');
        $countToday = DoctorAppointment::whereDate('created_at', Carbon::today())->count();
        $incremental = str_pad($countToday + 1, 3, '0', STR_PAD_LEFT);
        return 'A-' . $date . '-' . $incremental;
    }
}

@extends('master')

@section('title', 'Appointment Create')
@section('page_css')
    <!-- Menu item custom css -->
    <link href="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }}"
        {{ Sri::html('assets/plugins/custom/fullcalendar/fullcalendar.bundle.css') }} rel="stylesheet" type="text/css" />

    <style nonce="{{ $cspNonce }}">
        #appointmentCalendar {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            overflow: hidden;
            /* prevent horizontal scroll */
        }

        /* Remove borders */
        .fc .fc-daygrid-day {
            border: none !important;
        }

        .fc .fc-daygrid-day-frame {
            padding: 0.10rem;
            /* less padding */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 30px;
            /* smaller height */
        }

        /* Selected date circle only behind number */
        .fc-day-selected {
            background-color: #1e3a8a !important;
            color: #fff !important;
            border-radius: 50%;
            width: 2em;
            height: 2em;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
        }

        /* Remove hover background */
        .fc .fc-daygrid-day:hover .fc-daygrid-day-top {
            background-color: transparent;
        }

        /* Date number pointer on hover */
        .fc .fc-daygrid-day-number {
            cursor: pointer;
            z-index: 1;
        }

        /* Slot box default */
        .slot-box {
            width: 90px;
            cursor: pointer;
            transition: all 0.2s ease-in-out;
        }

        /* Hover effect */
        .slot-box:hover {
            background-color: #f0f8ff;
            /* হালকা নীল */
        }

        /* Selected state */
        .slot-box.active {
            background-color: #412147;
            /* Bootstrap primary */
            color: #fff;
            border-color: #5e6877;
        }
    </style>
@endsection
@section('content')
    <x-toolbar-component title="Appointment Create" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Appointment', 'url' => route('appointment.create')],
        ['label' => 'Appointment Create', 'active' => true],
    ]" actionUrl="{{ route('appointment.index') }}"
        actionIcon="fas fa-plus-circle" actionLabel="Appointment List" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                @include('message')

                <form method="POST" action="{{ route('appointment.store') }}" id="appointmentForm">
                    @csrf

                    <div class="row p-3 mb-5">
                        <!-- Doctor Info Card -->
                        <div class="col-md-4">
                            <div class="card shadow-sm text-center p-3 h-375px">
                                <label class="fs-5 fw-bold mb-2">Doctor</label>
                                <select id="kt_doctor_id" name="doctor_id"
                                    class="form-select form-select-light @error('doctor_id') is-invalid @enderror"
                                    data-control="select2" data-placeholder="Select Doctor" required>
                                    <option value=""></option>
                                    @foreach ($doctorInfos as $doctorInfo)
                                        <option value="{{ $doctorInfo->doctor_id }}"
                                            {{ old('doctor_id') == $doctorInfo->doctor_id ? 'selected' : '' }}>
                                            {{ $doctorInfo->title }} {{ $doctorInfo->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('doctor_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                                <!-- Doctor details placeholder -->
                                <div class="mt-4 doctorInfo">
                                    <img id="kt_doctor_image" class="rounded-circle mb-2 mx-auto d-block" width="100"
                                        height="100" alt="Doctor Avatar">

                                    <h5 class="fw-bold mb-1" id="kt_doctor_name"></h5>
                                    <p class="mb-1" id="kt_doctor_department"><strong>Department:</strong></p>
                                    <p class="mb-1" id="kt_doctor_phone"><strong>Phone:</strong></p>
                                    <p class="mb-1" id="kt_doctor_email"><strong>Email:</strong></p>
                                    <p class="mb-0" id="kt_doctor_address"><strong>Address:</strong></p>
                                </div>
                                <div class="text-center p-10 noDoctorDiv">
                                    <p class="mb-1 text-danger"><strong>No Doctor Selected</strong></p>
                                </div>
                            </div>
                        </div>

                        <!-- Calendar -->
                        <div class="col-md-5">
                            <div class="card shadow-sm text-center p-3 h-375px">
                                <div id="appointmentCalendar" class="mt-3">
                                </div>
                                <input type="hidden" name="appointment_date" id="selectedAppointmentDate">
                            </div>

                            <div class="card shadow-sm text-center p-3 mt-10 scheduleSlots">
                                <div id="scheduleSlots">

                                </div>
                            </div>
                        </div>

                        <!-- Patient Selection -->
                        <div class="col-md-3">
                            <div class="card shadow-sm text-center p-3  h-375px">
                                <label class="fs-5 fw-bold mb-2">Patient</label>
                                <select id="kt_patient_id" name="patient_id"
                                    class="form-select form-select-light @error('patient_id') is-invalid @enderror"
                                    data-control="select2" data-placeholder="Select Patient" required>
                                    <option value=""></option>
                                    @foreach ($patientInfos as $patientInfo)
                                        <option value="{{ $patientInfo->patient_id }}"
                                            {{ old('patient_id') == $patientInfo->patient_id ? 'selected' : '' }}>
                                            {{ $patientInfo->title }} {{ $patientInfo->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('patient_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror

                                <!-- Patient details placeholder -->
                                <div class="mt-4 patientInfo">
                                    <img id="kt_patient_image" class="rounded-circle mb-2 mx-auto d-block" width="100"
                                        height="100" alt="Patient Avatar">

                                    <h5 class="fw-bold mb-1" id="kt_patient_name"></h5>
                                    <p class="mb-1 text-muted"><span id="kt_patient_age"></span> years old,
                                        <span id="kt_patient_gender"></span>
                                    </p>
                                    <p class="mb-1" id="kt_patient_phone"></p>
                                    <p class="mb-1" id="kt_patient_email"></p>
                                    <p class="mb-0" id="kt_patient_address"></p>
                                </div>
                                <div class="text-center p-10 noPatientDiv">
                                    <p class="mb-1 text-danger"><strong>No Patient Selected</strong></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-5 text-end">
                        <button type="button" class="btn btn-danger btn-sm resetForm">Cancel</button>
                        <button type="submit" class="btn btn-success btn-sm" id="btnAppointmentSave">Save</button>
                    </div>
                </form>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
@endsection

@section('page_script')


    <script src="{{ asset('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"
        {{ Sri::html('assets/plugins/custom/fullcalendar/fullcalendar.bundle.js') }}></script>

    <script src="{{ asset('assets/custom/js/doctor/appointment/index.js') }}"
        {{ Sri::html('assets/custom/js/doctor/appointment/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

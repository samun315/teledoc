@extends('master')

@section('title', 'Prescription')
@section('page_css')
    <!-- Menu item custom css -->
    <link href="{{ asset('assets/custom/css/prescription/style.css') }}"
        {{ Sri::html('assets/custom/css/prescription/style.css') }} rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <x-toolbar-component title="Prescription Create" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Prescription', 'url' => route('drug.prescription.index')],
        ['label' => 'Prescription Create', 'active' => true],
    ]" actionUrl="{{ route('drug.prescription.index') }}"
        actionIcon="fas fa-plus-circle" actionLabel="Prescription List" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                @include('message')
                <div class="card-body bg-light">
                    <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x border-transparent fs-4 fw-bold" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab"
                                href="#prescription-create" role="tab" aria-selected="true">
                                Prescription Create
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#appointment-history"
                                role="tab" aria-selected="false">
                                Appointment History
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#image-and-documents"
                                role="tab" aria-selected="false">
                                Image/Documents
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#payment" role="tab"
                                aria-selected="false">
                                Payment
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#note" role="tab"
                                aria-selected="false">
                                Note
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#timeline"
                                role="tab" aria-selected="false">
                                Timeline
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="prescription-create" role="tabpanel">
                        <form method="POST" action="{{ route('drug.prescription.store') }}" id="prescriptionForm">
                            @csrf
                            <div class="prescription-form-container">
                                <div class="row p-2">
                                    <!-- Left Column -->
                                    <div class="col-md-3">
                                        <div class="card shadow-sm p-3">
                                            @foreach ($subscriptionTypes as $type)
                                                <input type="hidden" name="subscription_type_id[]"
                                                    value="{{ $type->subscription_type_id }}">
                                                <div class="form-group position-relative mb-7">
                                                    <textarea class="form-control subscription-textarea" id="subscription_details_{{ $type->subscription_type_id }}"
                                                        name="subscription_details[]" placeholder="" rows="3"></textarea>

                                                    <label for="subscription_details_{{ $type->subscription_type_id }}"
                                                        class="subscription-label">
                                                        {{ $type->subscription_type }}
                                                    </label>

                                                    <button type="button"
                                                        data-subscription-type-id="{{ $type->subscription_type_id }}"
                                                        data-subscription-type="{{ $type->subscription_type }}"
                                                        class="btn btn-sm btn-icon btn-dark rounded-circle position-absolute top-0 end-0 translate-middle-y addMoreBtn"
                                                        title="Add More">
                                                        <i class="fas fa-plus fs-5 text-white"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-5">
                                        <div class="card shadow-sm p-2">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h3>Rx</h3>

                                                <button type="button" class="btn btn-icon btn-success btn-sm"
                                                    data-bs-toggle="modal" id="openDrugModal">
                                                    <i class="fas fa-plus-circle"></i>
                                                </button>
                                            </div>

                                            <div class="row g-2 mb-2">
                                                <div class="col-md-6">
                                                    <label class="fs-5 fw-bold mb-2">Form</label>
                                                    <select id="kt_drug_type_id"
                                                        class="form-select form-select-light @error('drug_type_id') is-invalid @enderror"
                                                        data-control="select2" data-placeholder="Form">
                                                        <option value=""></option>
                                                        @foreach ($drugTypes as $drugType)
                                                            <option {{ old('drug_type_id') ? 'selected' : '' }}
                                                                value="{{ $drugType->drug_type_id ?? old('drug_type_id') }}">
                                                                {{ $drugType->drug_type }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('drug_type_id')
                                                        <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="fs-5 fw-bold mb-2">Medicine</label>
                                                    <select id="kt_drug_id"
                                                        class="form-select form-select-light @error('drug_id') is-invalid @enderror"
                                                        data-control="select2" data-placeholder="Medicine">
                                                        <option value=""></option>
                                                        @foreach ($drugs as $drug)
                                                            <option {{ old('drug_id') ? 'selected' : '' }}
                                                                value="{{ $drug->drug_id ?? old('drug_id') }}">
                                                                {{ $drug->trade_name }} ({{ $drug->generic_name }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('drug_id')
                                                        <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-12">
                                                    <label class="fs-5 fw-bold mb-2">Strength</label>
                                                    <select id="kt_drug_strength_id"
                                                        class="form-select form-select-light @error('drug_strength_id') is-invalid @enderror"
                                                        data-control="select2" data-placeholder="Strength">
                                                        <option value=""></option>
                                                        @foreach ($drugStrengths as $drugStrength)
                                                            <option {{ old('drug_strength_id') ? 'selected' : '' }}
                                                                value="{{ $drugStrength->drug_strength_id ?? old('drug_strength_id') }}">
                                                                {{ $drugStrength->drug_strength }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('drug_strength_id')
                                                        <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row g-2 mb-2">
                                                <div class="col-md-6">
                                                    <label class="fs-5 fw-bold mb-2">Frequency</label>
                                                    <select id="kt_drug_dose_id"
                                                        class="form-select form-select-light @error('drug_dose_id') is-invalid @enderror"
                                                        data-control="select2" data-placeholder="Frequency">
                                                        <option value=""></option>
                                                        @foreach ($drugDoses as $drugDose)
                                                            <option {{ old('drug_dose_id') ? 'selected' : '' }}
                                                                value="{{ $drugDose->drug_dose_id ?? old('drug_dose_id') }}">
                                                                {{ $drugDose->drug_dose }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('drug_dose_id')
                                                        <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="fs-5 fw-bold mb-2">Duration</label>
                                                    <select id="kt_drug_duration_id"
                                                        class="form-select form-select-light @error('drug_duration_id') is-invalid @enderror"
                                                        data-control="select2" data-placeholder="Duration">
                                                        <option value=""></option>
                                                        @foreach ($drugDurations as $drugDuration)
                                                            <option {{ old('drug_duration_id') ? 'selected' : '' }}
                                                                value="{{ $drugDuration->drug_duration_id ?? old('drug_duration_id') }}">
                                                                {{ $drugDuration->drug_duration }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('drug_duration_id')
                                                        <div class="text-danger mt-2">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label class="fs-5 fw-bold mb-2">Instruction</label>
                                                <select id="kt_drug_advice_id"
                                                    class="form-select form-select-light @error('drug_advice_id') is-invalid @enderror"
                                                    data-control="select2" data-placeholder="Instruction">
                                                    <option value=""></option>
                                                    @foreach ($drugAdvices as $drugAdvice)
                                                        <option {{ old('drug_advice_id') ? 'selected' : '' }}
                                                            value="{{ $drugAdvice->drug_advice_id ?? old('drug_advice_id') }}">
                                                            {{ $drugAdvice->drug_advice }}</option>
                                                    @endforeach
                                                </select>
                                                @error('drug_advice_id')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <button type="button" class="btn btn-dark fw-bold d-block" id="btnAddDrug">
                                                <i class="fas fa-plus text-white me-1"></i> Add Drug in prescription
                                            </button>
                                            <button type="button" class="btn btn-primary fw-bold d-none"
                                                id="btnUpdateDrug">
                                                <i class="fas fa-plus text-white me-1"></i>Update Drug
                                            </button>
                                        </div>
                                        <hr class="my-4">

                                        <div id="prescriptionDrugList">
                                            <h4 class="mb-3">Added Drugs</h4>
                                            <div id="drugListWrapper" class="d-grid gap-2" tabindex="-1">
                                                {{-- Added drugs will appear here --}}
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-4">
                                        <div class="card shadow-sm p-3 mb-2">
                                            <label class="fs-6 fw-bold mb-2">Prescription Date</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control form-control-light"
                                                    id="kt_prescription_date" name="prescription_date"
                                                    value="{{ date('Y-m-d') }}" placeholder="Select date">
                                                <span class="input-group-text bg-light cursor-pointer" id="dateIcon">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </span>
                                            </div>
                                            @error('prescription_date')
                                                <div class="text-danger mt-2">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="card shadow-sm p-3 mb-2">
                                            <div class="col-md-12 mb-3">
                                                <label class="fs-6 fw-bold mb-2">Doctor Name</label>
                                                <select id="kt_doctor_id" name="doctor_id"
                                                    class="form-select form-select-light @error('doctor_id') is-invalid @enderror"
                                                    data-control="select2" data-placeholder="Doctor Name">
                                                    <option value=""></option>
                                                    @foreach ($doctorInfos as $doctorInfo)
                                                        <option {{ old('doctor_id', $defaultDoctorId ?? '') == $doctorInfo->doctor_id ? 'selected' : '' }}
                                                            value="{{ $doctorInfo->doctor_id ?? old('doctor_id') }}">
                                                            {{ $doctorInfo->title }} {{ $doctorInfo->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('doctor_id')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-12">
                                                <label class="fs-6 fw-bold mb-2">Old Prescription</label>
                                                <select id="kt_prescription_id" name="prescription_id"
                                                    class="form-select form-select-light @error('prescription_id') is-invalid @enderror"
                                                    data-control="select2" data-placeholder="Old Prescription">
                                                    <option value=""></option>
                                                    @foreach ($oldPrescriptionInfos as $oldPrescription)
                                                        <option
                                                            {{ old('prescription_id') == $oldPrescription->prescription_id ? 'selected' : '' }}
                                                            value="{{ $oldPrescription->prescription_id }}">
                                                            {{ $oldPrescription->prescription_number }}
                                                            ({{ \Carbon\Carbon::parse($oldPrescription->created_at)->format('Y-m-d') }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="col-md-12 mt-3">
                                                @php
                                                    $selectedAppointmentId = old('appointment_id', request()->query('appointment_id'));
                                                @endphp
                                                <label class="fs-6 fw-bold mb-2">Appointment <span class="text-muted fw-normal">(optional)</span></label>
                                                <select id="kt_appointment_id" name="appointment_id"
                                                    class="form-select form-select-light @error('appointment_id') is-invalid @enderror"
                                                    data-control="select2" data-placeholder="Link to appointment">
                                                    <option value=""></option>
                                                    @foreach ($appointmentLists as $appt)
                                                        @php
                                                            $apptId = $appt->appointment_id;
                                                        @endphp
                                                        <option value="{{ $apptId }}"
                                                            {{ (string) $selectedAppointmentId === (string) $apptId ? 'selected' : '' }}>
                                                            {{ \Carbon\Carbon::parse($appt->appointment_date)->format('d M Y') }}
                                                            —
                                                            {{ $appt?->doctor?->title }} {{ $appt?->doctor?->name }}
                                                            ({{ \Carbon\Carbon::parse($appt->slot_time)->format('g:i A') }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @error('appointment_id')
                                                    <div class="text-danger mt-2">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="card shadow-sm text-center p-3">
                                            <input type="hidden" name="patient_id" id="kt_patient_id"
                                                value="{{ $patientInfo?->patient_id }}">
                                            <img src="{{ $patientInfo?->photo ? asset('uploads/patient/' . $patientInfo->photo) : asset('assets/media/avatars/blank.png') }}"
                                                class="rounded-circle mb-2 mx-auto d-block" width="100" height="100"
                                                alt="Patient Avatar">

                                            <h5 class="fw-bold mb-1">{{ $patientInfo?->name }}</h5>
                                            <p class="mb-1 text-muted">{{ $patientInfo?->age }} years old,
                                                {{ $patientInfo?->gender }}
                                            </p>
                                            <p class="mb-1"><strong>Phone:</strong> {{ $patientInfo?->phone }}</p>
                                            <p class="mb-1"><strong>Email:</strong> {{ $patientInfo?->email }}</p>
                                            <p class="mb-0"><strong>Address:</strong>
                                                {{ $patientInfo?->address }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="fs-5 fw-bold mb-2 mt-2">Advice</label>
                                        <textarea class="form-control form-control-solid doctor_advice @error('doctor_advice') is-invalid @enderror"
                                            id="kt_doctor_advice" placeholder="Write Advices...." name="doctor_advice" data-kt-autosize="true"></textarea>
                                        <span class="text-danger mt-2 terms_error"></span>
                                        @error('doctor_advice')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label class="fs-5 fw-bold mb-2 mt-2">Follow Up</label>
                                        <textarea class="form-control form-control-solid follow_up @error('follow_up') is-invalid @enderror" id="kt_follow_up"
                                            placeholder="Write Follow Up...." name="follow_up" data-kt-autosize="true"></textarea>
                                        <span class="text-danger mt-2 terms_error"></span>
                                        @error('follow_up')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->

                            <div class="submit-btn-wrapper text-end">
                                <a href="{{ route('drug.prescription.index') }}" class="btn btn-danger btn-sm"><i
                                        class="fas fa-arrow-left"></i>Back</a>
                                <button type="submit" class="btn btn-success btn-sm m-5"
                                    id="btnPrescriptionSubmit">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="appointment-history" role="tabpanel">
                        <div class="timeline">
                            @foreach ($appointmentLists as $appointmentList)
                                <div class="item">
                                    <div class="title">
                                        {{ \Carbon\Carbon::parse($appointmentList->appointment_date)->format('d M Y') }} -
                                        {{ $appointmentList?->appointment_status }}</div>
                                    <div class="status">Appointment with {{ $appointmentList?->doctor?->title }}
                                        {{ $appointmentList?->doctor?->name }}
                                    </div>
                                    <div class="time">At
                                        {{ \Carbon\Carbon::parse($appointmentList->slot_time)->format('g:i A') }}</div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-pane fade" id="image-and-documents" role="tabpanel">

                        <!-- TIMELINE SECTION -->
                        <div class="timeline timeline-with-btn timeline-wrapper">

                            <!-- Upload Button -->
                            <button class="upload-btn btn btn-sm btn-info">
                                <i class="fa fa-upload"></i>
                                <span>Upload</span>
                            </button>

                            @forelse ($prescriptionDocs as $prescriptionDoc)
                                <div class="item">
                                    <div class="title">
                                        <span class="time">
                                            {{ \Carbon\Carbon::parse($prescriptionDoc->created_at)->format('d M Y') }}
                                        </span>

                                        <div class="content">
                                            <a href="{{ asset('uploads/prescription/' . $prescriptionDoc->attachment) }}"
                                                target="_blank" class="prescription-link">
                                                <img src="{{ asset('uploads/prescription/' . $prescriptionDoc->attachment) }}"
                                                    alt="Not Found" class="prescription-thumb">
                                            </a>
                                            <p>{{ $prescriptionDoc->attachment }}</p>
                                        </div>
                                    </div>

                                </div>
                            @empty
                                <div class="item">
                                    <div class="title">
                                        <h3>No Medical Document Found</h3>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                        <!-- UPLOAD CARD (Initially Hidden) -->
                        <div class="card mb-4 border-top-0 rounded-0 floating-margin upload-wrapper d-none">
                            <div class="card-body bg-card-header">

                                <button class="btn btn-primary mb-3 back-btn">
                                    <i class="fa fa-arrow-left"></i> Back
                                </button>

                                <div class="dropzone" id="dropzone">
                                    <div class="dropzone_message">
                                        <h3>Drag and Drop File Here</h3>
                                        <p>Or</p>
                                        <label class="btn btn-primary" for="fileInput">Select File</label>
                                        <input type="file" id="fileInput" class="d-none">
                                    </div>
                                </div>

                                <div class="progress mt-5 d-none" id="uploadProgress">
                                    <div class="progress-bar progress-bar-striped progress-bar-animated"
                                        role="progressbar" style="width:0%">
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>



                    <div class="tab-pane fade" id="payment" role="tabpanel">
                        payment
                    </div>
                    <div class="tab-pane fade" id="note" role="tabpanel">
                        note
                    </div>
                    <div class="tab-pane fade" id="timeline" role="tabpanel">
                        timeline
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

    {{-- start:: Drug add modal --}}
    @include('drugs.drug.modal.addDrugModal')
    {{-- end:: Drug add modal --}}

    {{-- start:: NEW PRESCRIPTION ADD MODAL --}}
    @include('drugs.prescription.modal.addSubscriptionModal')
    {{-- end:: NEW PRESCRIPTION ADD MODAL --}}

@endsection

@section('page_script')

    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"
        {{ Sri::html('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}></script>
    <!-- begin::Page Custom Stylesheets(used by this page) -->

    <script src="{{ asset('assets/custom/js/drugs/prescription/index.js') }}"
        {{ Sri::html('assets/custom/js/drugs/prescription/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

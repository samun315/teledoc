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

                <form action="{{ route('drug.prescription.store') }}" id="prescriptionForm">
                    @csrf
                    <div class="prescription-form-container">
                        <div class="row p-2">
                            <!-- Left Column -->
                            <div class="col-md-3">
                                <div class="card shadow-sm p-3">
                                    @foreach ($subscriptionTypes as $type)
                                        <div class="form-group position-relative mb-7">
                                            <textarea class="form-control subscription-textarea" id="subscription_type_{{ $type->subscription_type_id }}"
                                                name="subscription_type" placeholder="" rows="3"></textarea>

                                            <label for="subscription_type_{{ $type->subscription_type_id }}"
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
                                    <h3>Rx</h3>
                                    <div class="row g-2 mb-2">
                                        <div class="col-md-6">
                                            <label class="fs-5 fw-bold mb-2">Type</label>
                                            <select id="kt_drug_type_id"
                                                class="form-select form-select-light @error('drug_type_id') is-invalid @enderror"
                                                data-control="select2" data-placeholder="Type">
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
                                                        {{ $drug->trade_name }}</option>
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
                                            <label class="fs-5 fw-bold mb-2">Dose</label>
                                            <select id="kt_drug_dose_id"
                                                class="form-select form-select-light @error('drug_dose_id') is-invalid @enderror"
                                                data-control="select2" data-placeholder="Dose">
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
                                        <label class="fs-5 fw-bold mb-2">Advice</label>
                                        <select id="kt_drug_advice_id"
                                            class="form-select form-select-light @error('drug_advice_id') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Advice">
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
                                    <button type="button" class="btn btn-primary fw-bold d-none" id="btnUpdateDrug">
                                        <i class="fas fa-plus text-white me-1"></i>Update Drug
                                    </button>
                                </div>
                                <hr class="my-4">

                                <div id="prescriptionDrugList">
                                    <h4 class="mb-3">Added Drugs</h4>
                                    <div id="drugListWrapper" class="d-grid gap-2">
                                        {{-- Added drugs will appear here --}}
                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4">
                                <div class="card shadow-sm text-center p-3">
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
                        </div>
                    </div>
                    <!--end::Card body-->

                    <div class="submit-btn-wrapper text-end">
                        <button type="submit" class="btn btn-success btn-sm" id="btnPrescriptionSubmit">Submit</button>
                    </div>
                </form>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

    {{-- start:: NEW PRESCRIPTION ADD MODAL --}}
    @include('drugs.prescription.modal.addSubscriptionModal')
    {{-- end:: NEW PRESCRIPTION ADD MODAL --}}

@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/drugs/prescription/index.js') }}"
        {{ Sri::html('assets/custom/js/drugs/prescription/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

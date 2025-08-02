@extends('master')

@section('title', 'Prescription')

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

                <div class="row p-2">
                    <!-- Left Column -->
                    <div class="col-md-4">
                        <div class="card shadow-sm p-3">
                            @foreach ($subscriptionTypes as $type)
                                <div class="position-relative mb-7">
                                    <textarea class="form-control pe-5" rows="3" name="subscription_type"
                                        id="subscription_type_{{ $type->subscription_type_id }}" placeholder="{{ $type->subscription_type }}"></textarea>

                                    <button type="button"
                                        class="btn btn-sm btn-icon btn-dark rounded-circle position-absolute top-0 end-0 translate-middle-y"
                                        title="Add More">
                                        <i class="fas fa-plus fs-5 text-white"></i>
                                    </button>
                                </div>
                            @endforeach


                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="col-md-4">
                        <div class="card shadow-sm p-3">
                            <label>Date</label>
                            <input type="text" class="form-control" value="08/02/2025">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm text-center p-3">
                            <img src="{{ $patientInfo?->photo ? asset('uploads/patient/' . $patientInfo->photo) : asset('assets/media/avatars/blank.png') }}"
                                class="rounded-circle mb-2 mx-auto d-block" width="100" height="100"
                                alt="Patient Avatar">

                            <h5 class="fw-bold mb-1">{{ $patientInfo?->name }}</h5>
                            <p class="mb-1 text-muted">{{ $patientInfo?->age }} years old, {{ $patientInfo?->gender }}</p>
                            <p class="mb-1"><strong>Phone:</strong> {{ $patientInfo?->phone }}</p>
                            <p class="mb-1"><strong>Email:</strong> {{ $patientInfo?->email }}</p>
                            <p class="mb-0"><strong>Address:</strong>
                                {{ $patientInfo?->address }}
                            </p>
                        </div>
                    </div>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/drugs/prescription/index.js') }}"
        {{ Sri::html('assets/custom/js/drugs/prescription/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

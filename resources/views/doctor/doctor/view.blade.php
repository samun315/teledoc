@extends('master')

@section('title', 'Patient')
@section('page_css')
    <style nonce="{{ $cspNonce }}">
        .upload-container {
            position: relative;
            width: 210px;
            height: 210px;
        }

        .upload-box {
            width: 100%;
            height: 100%;
            border: 1px solid #ccc;
            border-radius: 7px;
            overflow: hidden;
            background-color: #f9f9f9;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-box img {
            width: 96%;
            height: 96%;
            object-fit: cover;
            border-radius: 7px;
        }
    </style>
@endsection
@section('content')
    <!--begin::Toolbar -->
    <x-toolbar-component title="Patient View" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Patient', 'url' => route('patient.index')],
        ['label' => 'Patient View', 'active' => true],
    ]" actionUrl="{{ route('patient.index') }}"
        actionIcon="fas fa-list" actionLabel="Patient List" />
    <!--end::Toolbar -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 row">
                            {{-- Photo Upload --}}
                            <div class="col-md-4 fv-row mb-5">
                                <label class="fs-5 fw-bold mb-2">Photo</label>

                                <div class="upload-container"> <!-- move class here instead -->
                                    <label class="upload-box">
                                        <img id="photoPreview" alt="Image Preview"
                                            src="{{ !empty($editModeData?->photo) ? asset('/uploads/patient/' . $editModeData?->photo) : '' }}">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">
                                {{-- Name --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Name</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->name }}" readonly>
                                </div>

                                {{-- Email --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Email</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->email }}" readonly>
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Phone</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->phone }}" readonly>
                                </div>

                                {{-- Date of Birth --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Date of birth</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ !empty($editModeData?->date_of_birth) ? \Carbon\Carbon::parse($editModeData?->date_of_birth)->format('d M, Y') : '' }}"
                                        readonly>
                                </div>

                                {{-- Age --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Age(Year)</label>
                                    <input type="number" class="form-control form-control-solid"
                                        value="{{ $editModeData?->age }}" readonly>
                                </div>

                                {{-- Height --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Height</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->height }}" readonly>
                                </div>

                                {{-- Weight --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Weight</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->weight }}" readonly>
                                </div>

                                {{-- Gender --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Gender</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->gender }}" readonly>
                                </div>

                                {{-- Blood Group --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Blood group</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->blood_group }}" readonly>
                                </div>

                                {{-- Marital status --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Marital status</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->marital_status }}" readonly>
                                </div>

                                <div class="col-md-8 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Note</label>
                                    <textarea class="form-control form-control-solid" data-kt-autosize="true" readonly>{{ $editModeData?->note }}</textarea>
                                </div>

                                <div class="col-md-6 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Address</label>
                                    <textarea class="form-control form-control-solid" data-kt-autosize="true" readonly>{{ $editModeData?->address }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>



        </div>
        <!--end::Container-->
    </div>
@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/patient/index.js') }}" {{ Sri::html('assets/custom/js/patient/index.js') }}>
    </script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

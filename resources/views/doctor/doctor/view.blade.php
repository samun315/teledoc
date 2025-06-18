@extends('master')

@section('title', 'Doctor')
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
    <x-toolbar-component title="Doctor View" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Doctor', 'url' => route('doctor.index')],
        ['label' => 'Doctor View', 'active' => true],
    ]" actionUrl="{{ route('doctor.index') }}"
        actionIcon="fas fa-list" actionLabel="Doctor List" />
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
                                            src="{{ !empty($editModeData?->photo) ? asset('/uploads/doctor/' . $editModeData?->photo) : '' }}">
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="row">

                                {{-- Title --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Title</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->title }}" readonly>
                                </div>
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

                                {{-- department --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Department</label>
                                    <input type="text" class="form-control form-control-solid"
                                        value="{{ $editModeData?->department?->department_name }}" readonly>
                                </div>

                                {{-- Address --}}
                                <div class="col-md-6 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Address</label>
                                    <textarea class="form-control form-control-solid" data-kt-autosize="true" readonly>{{ $editModeData?->address }}</textarea>
                                </div>

                                {{-- description --}}
                                <div class="col-md-6 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Description</label>
                                    <textarea class="form-control form-control-solid" data-kt-autosize="true" readonly>{{ $editModeData?->description }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="divider-line">
                            <span class="divider-text fs-3 text-dark">Degrees</span>
                            <div class="line"></div>
                        </div>

                        @foreach ($editModeData->degrees as $index => $degree)
                            <div class="degree_row_element" data-increment-id="{{ $index + 1 }}">
                                <div class="row">
                                    <!-- degree_title, degree_description, Action columns -->
                                    <div class="col-md-5 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Title</label>
                                        <input type="text" class="form-control form-control-solid"
                                            value="{{ $degree?->degree_title }}" readonly>
                                    </div>
                                    <div class="col-md-7 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Description</label>
                                        <input type="text" class="form-control form-control-solid"
                                            value="{{ $degree?->degree_description }}" readonly>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

            </div>



        </div>
        <!--end::Container-->
    </div>
@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/doctor/index.js') }}" {{ Sri::html('assets/custom/js/doctor/index.js') }}>
    </script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

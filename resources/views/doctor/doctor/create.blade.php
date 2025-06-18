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
            cursor: pointer;
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
            display: none;
        }

        .upload-placeholder {
            text-align: center;
            color: #666;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100%;
            width: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .upload-icon {
            font-size: 48px;
        }

        .remove-btn {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: red;
            color: white;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            font-size: 18px;
            font-weight: bold;
            display: none;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
            z-index: 2;
        }

        input[type="file"] {
            display: none;
        }
    </style>
@endsection
@section('content')
    <!--begin::Toolbar -->
    <x-toolbar-component title="Doctor {{ isset($editModeData) ? 'Edit' : 'Create' }}" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Doctor', 'url' => route('doctor.index')],
        ['label' => 'Doctor ' . (isset($editModeData) ? 'Edit' : 'Create'), 'active' => true],
    ]"
        actionUrl="{{ route('doctor.index') }}" actionIcon="fas fa-list" actionLabel="Doctor List" />
    <!--end::Toolbar -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <form method="POST"
                action="{{ isset($editModeData) ? route('doctor.update', $editModeData?->doctor_id) : route('doctor.store') }}"
                enctype="multipart/form-data">
                @csrf

                @isset($editModeData)
                    @method('PUT')
                    <input type="text" hidden id="kt_doctor_id" name="doctor_id" value="{{ $editModeData?->doctor_id }}">
                @endisset

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 row">
                                {{-- Photo Upload --}}
                                <div class="col-md-4 fv-row mb-5">
                                    <label class="fs-5 fw-bold mb-2">Photo</label>

                                    <div class="upload-container"> <!-- move class here instead -->
                                        <label class="upload-box" for="photoInput">
                                            <img id="photoPreview" alt="Image Preview"
                                                src="{{ !empty($editModeData?->photo) ? asset('/uploads/doctor/' . $editModeData?->photo) : '' }}"
                                                class="{{ !empty($editModeData?->photo) ? 'd-block' : 'd-none' }}">
                                            <div class="upload-placeholder {{ !empty($editModeData?->photo) ? 'd-none' : 'd-flex' }}"
                                                id="uploadPlaceholder">
                                                <div class="upload-icon bi bi-cloud-upload display-1"></div>
                                                <div>Click to upload from File Manager.</div>
                                            </div>
                                        </label>
                                        <button type="button"
                                            class="remove-btn {{ !empty($editModeData?->photo) ? 'd-block' : 'd-none' }}"
                                            id="removeBtn">×</button>
                                        <input type="file" id="photoInput" name="photo" accept="image/*">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row">

                                    {{-- Title --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="required fs-5 fw-bold mb-2">Title</label>
                                        <input type="text" name="title"
                                            class="form-control form-control-light @error('title') is-invalid @enderror"
                                            value="{{ $editModeData?->title ?? old('title') }}" placeholder="Enter Title"
                                            required>
                                        @error('title')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Name --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="required fs-5 fw-bold mb-2">Name</label>
                                        <input type="text" name="name"
                                            class="form-control form-control-light @error('name') is-invalid @enderror"
                                            value="{{ $editModeData?->name ?? old('name') }}" placeholder="Enter Name"
                                            required>
                                        @error('name')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="required fs-5 fw-bold mb-2">Email</label>
                                        <input type="email" name="email"
                                            class="form-control form-control-light @error('email') is-invalid @enderror"
                                            value="{{ $editModeData?->email ?? old('email') }}" placeholder="Enter Email"
                                            required>
                                        @error('email')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Phone --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="required fs-5 fw-bold mb-2">Phone</label>
                                        <input type="text" name="phone"
                                            class="form-control form-control-light @error('phone') is-invalid @enderror"
                                            value="{{ $editModeData?->phone ?? old('phone') }}" placeholder="Enter Phone"
                                            required>
                                        @error('phone')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    @if (empty($editModeData?->doctor_id))
                                        {{-- Password --}}
                                        <div class="col-md-4 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">Password</label>
                                            <input type="password" name="password"
                                                class="form-control form-control-light @error('password') is-invalid @enderror"
                                                placeholder="Enter Password">
                                            @error('password')
                                                <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        {{-- Confirm Password --}}
                                        <div class="col-md-4 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">Confirm Password</label>
                                            <input type="password" name="confirm_password"
                                                class="form-control form-control-light @error('confirm_password') is-invalid @enderror"
                                                placeholder="Enter Confirm Password">
                                            @error('confirm_password')
                                                <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif

                                    {{-- Marital status --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="required fs-5 fw-bold mb-2">Department</label>
                                        <select name="department_id" id="kt_department_id"
                                            class="form-select form-select-light @error('department_id') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select Department" required>
                                            <option value=""></option>
                                            @foreach ($departments as $department)
                                                <option
                                                    @isset($editModeData)
                                            {{ $editModeData?->department_id === $department->department_id ? 'selected' : '' }}
                                            @endisset
                                                    {{ old('department_id') === $department->department_id ? 'selected' : '' }}
                                                    value="{{ $department->department_id }}">
                                                    {{ $department->department_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('department_id')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-8"></div>
                                    <div class="col-md-6 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Address</label>
                                        <textarea class="form-control form-control-light address @error('address') is-invalid @enderror" id="kt_address"
                                            placeholder="Write address...." name="address" data-kt-autosize="true">{{ $editModeData?->address ?? old('address') }}</textarea>

                                        @error('address')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Description</label>
                                        <textarea class="form-control form-control-light description @error('description') is-invalid @enderror"
                                            id="kt_description" placeholder="Write description...." name="description" data-kt-autosize="true">{{ $editModeData?->description ?? old('description') }}</textarea>

                                        @error('description')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="divider-line">
                                <span class="divider-text fs-3 text-dark">Degrees</span>
                                <div class="line"></div>
                            </div>

                            @if (!empty($editModeData) && count($editModeData->degrees))
                                @foreach ($editModeData->degrees as $index => $degree)
                                    <div class="{{ $index === 0 ? 'row static_row' : 'row degree_row_element' }}"
                                        data-increment-id="{{ $index + 1 }}">
                                        <div class="row">
                                            <!-- degree_title, degree_description, Action columns -->
                                            <div class="col-md-5 fv-row mb-5">
                                                <label class="required fs-5 fw-bold mb-2">Title</label>
                                                <input type="text" class="form-control form-control-light degree_title"
                                                    name="degree_title[]" id="degree_title_{{ $index + 1 }}"
                                                    value="{{ $degree->degree_title }}" required />
                                            </div>
                                            <div class="col-md-6 fv-row mb-5">
                                                <label class="fs-5 fw-bold mb-2">Description</label>
                                                <input type="text"
                                                    class="form-control form-control-light degree_description"
                                                    name="degree_description[]"
                                                    id="degree_description_{{ $index + 1 }}"
                                                    value="{{ $degree->degree_description }}" />
                                            </div>
                                            <div class="col-md-1 fv-row mb-5">
                                                @if ($index === 0)
                                                    <label class="fs-5 fw-bold mb-2">Action</label>
                                                @else
                                                    <label class="fs-5 fw-bold mb-2 invisible">Action</label>
                                                @endif
                                                <div class="d-flex align-items-end">
                                                    @if ($index === 0)
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-success mt-1 ms-2"
                                                            id="addMoreBtn">
                                                            <i class="fas fa-plus-circle"></i>
                                                        </button>
                                                    @else
                                                        <button type="button"
                                                            class="btn btn-sm btn-icon btn-danger mt-1 ms-2 deleteDegree">
                                                            <i class="fas fa-trash-alt ms-1"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                                {{-- Place degree_append_div after all existing rows --}}
                                <div class="row static_row">
                                    <div class="degree_append_div"></div>
                                </div>
                            @else
                                {{-- Create mode fallback --}}
                                <div class="row static_row">
                                    <div class="col-md-5 fv-row mb-5">
                                        <label class="required fs-5 fw-bold mb-2">Title</label>
                                        <input type="text" class="form-control form-control-light degree_title"
                                            name="degree_title[]" id="degree_title_1" required />
                                    </div>
                                    <div class="col-md-6 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Description</label>
                                        <input type="text" class="form-control form-control-light degree_description"
                                            name="degree_description[]" id="degree_description_1" />
                                    </div>
                                    <div class="col-md-1 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Action</label>
                                        <div class="d-flex align-items-end">
                                            <button type="button" class="btn btn-icon btn-sm btn-success mt-1 ms-2"
                                                id="addMoreBtn">
                                                <i class="fas fa-plus-circle"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="degree_append_div"></div>
                            @endif

                            <div class="mt-4 text-end">
                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                            </div>
                        </div>

                    </div>

                </div>

            </form>

        </div>
        <!--end::Container-->
    </div>
@endsection

@section('page_script')

    <script nonce="{{ $cspNonce }}">
        let incrementId = {{ isset($editModeData) && count($editModeData->degrees) ? count($editModeData->degrees) : 1 }};
    </script>

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/doctor/doctor/index.js') }}"
        {{ Sri::html('assets/custom/js/doctor/doctor/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

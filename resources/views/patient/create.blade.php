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
    <x-toolbar-component title="Patient {{ isset($editModeData) ? 'Edit' : 'Create' }}" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Patient', 'url' => route('patient.index')],
        ['label' => 'Patient ' . (isset($editModeData) ? 'Edit' : 'Create'), 'active' => true],
    ]"
        actionUrl="{{ route('patient.index') }}" actionIcon="fas fa-list" actionLabel="Patient List" />
    <!--end::Toolbar -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <form method="POST"
                action="{{ isset($editModeData) ? route('patient.update', $editModeData?->patient_id) : route('patient.store') }}"
                enctype="multipart/form-data">
                @csrf

                @isset($editModeData)
                    @method('PUT')
                    <input type="text" hidden id="kt_patient_id" name="patient_id" value="{{ $editModeData?->patient_id }}">
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
                                                src="{{ !empty($editModeData?->photo) ? asset('/uploads/patient/' . $editModeData?->photo) : '' }}"
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
                                        <label class="fs-5 fw-bold mb-2">Email</label>
                                        <input type="email" name="email"
                                            class="form-control form-control-light @error('email') is-invalid @enderror"
                                            value="{{ $editModeData?->email ?? old('email') }}" placeholder="Enter Email">
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

                                    @if (empty($editModeData?->patient_id))
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


                                    {{-- Date of Birth --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Date of birth</label>
                                        <input type="text" name="date_of_birth" id="kt_date_of_birth"
                                            class="form-control form-control-light @error('date_of_birth') is-invalid @enderror"
                                            value="{{ !empty($editModeData?->date_of_birth) ? \Carbon\Carbon::parse($editModeData?->date_of_birth)->format('d-m-Y') : old('date_of_birth') }}"
                                            placeholder="Enter date of birth">
                                        @error('date_of_birth')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Age --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Age(Year)</label>
                                        <input type="number" name="age" id="kt_age"
                                            class="form-control form-control-light @error('age') is-invalid @enderror"
                                            value="{{ $editModeData?->age ?? old('age') }}" placeholder="Age (Year)">
                                        @error('age')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Height --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Height</label>
                                        <input type="text" name="height"
                                            class="form-control form-control-light @error('height') is-invalid @enderror"
                                            value="{{ $editModeData?->height ?? old('height') }}"
                                            placeholder="Enter Height">
                                        @error('height')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Weight --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Weight</label>
                                        <input type="text" name="weight"
                                            class="form-control form-control-light @error('weight') is-invalid @enderror"
                                            value="{{ $editModeData?->weight ?? old('weight') }}"
                                            placeholder="Enter Weight">
                                        @error('weight')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Gender --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Gender</label>
                                        <select name="gender"
                                            class="form-select form-select-light @error('gender') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select Gender">
                                            <option value=""></option>
                                            @foreach ($genderList as $gender)
                                                <option
                                                    @isset($editModeData)
                                            {{ $editModeData?->gender === $gender ? 'selected' : '' }}
                                            @endisset
                                                    {{ old('gender') === $gender ? 'selected' : '' }}
                                                    value="{{ $gender ?? old('gender') }}">{{ $gender }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('gender')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Blood Group --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Blood group</label>
                                        <select name="blood_group"
                                            class="form-select form-select-light @error('blood_group') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select Blood Group">

                                            <option value=""></option>

                                            @foreach ($bloodGroupList as $bloodGroup)
                                                <option
                                                    @isset($editModeData)
                                            {{ $editModeData?->blood_group === $bloodGroup ? 'selected' : '' }}
                                            @endisset
                                                    {{ old('blood_group') === $bloodGroup ? 'selected' : '' }}
                                                    value="{{ $bloodGroup ?? old('blood_group') }}">
                                                    {{ $bloodGroup }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('blood_group')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    {{-- Marital status --}}
                                    <div class="col-md-4 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Marital status</label>
                                        <select name="marital_status" id="kt_marital_status"
                                            class="form-select form-select-light @error('marital_status') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select Marital Status">
                                            <option value=""></option>
                                            @foreach ($maritalStatusList as $maritalStatus)
                                                <option
                                                    @isset($editModeData)
                                            {{ $editModeData?->marital_status === $maritalStatus ? 'selected' : '' }}
                                            @endisset
                                                    {{ old('marital_status') === $maritalStatus ? 'selected' : '' }}
                                                    value="{{ $maritalStatus }}">{{ $maritalStatus }}</option>
                                            @endforeach
                                        </select>
                                        @error('marital_status')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Note</label>
                                        <textarea class="form-control form-control-light note @error('note') is-invalid @enderror" id="kt_note"
                                            placeholder="Write note...." name="note" data-kt-autosize="true">{{ $editModeData?->note ?? old('note') }}</textarea>

                                        @error('note')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5">
                                        <label class="fs-5 fw-bold mb-2">Address</label>
                                        <textarea class="form-control form-control-light address @error('address') is-invalid @enderror" id="kt_address"
                                            placeholder="Write address...." name="address" data-kt-autosize="true">{{ $editModeData?->address ?? old('address') }}</textarea>

                                        @error('address')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

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

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/patient/index.js') }}" {{ Sri::html('assets/custom/js/patient/index.js') }}>
    </script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

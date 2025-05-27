@extends('master')

@section('title', 'Patient Create')
@section('content')
    <!--begin::Toolbar -->
    <x-toolbar-component title="Patient Create" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Patient', 'url' => route('patient.index')],
        ['label' => 'Patient Create', 'active' => true],
    ]" actionUrl="{{ route('patient.index') }}"
        actionIcon="fas fa-list" actionLabel="Patient List" />
    <!--end::Toolbar -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <form action="{{ route('patient.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 row">
                                {{-- Photo Upload --}}
                                <div class="col-md-4 text-center">
                                    <label for="photo">Photo</label>
                                    <div class="border p-3 rounded">
                                        <label class="d-block">
                                            <input type="file" name="photo" class="d-none" id="photo">
                                            <div class="d-flex flex-column align-items-center">
                                                <i class="bi bi-cloud-upload display-4"></i>
                                                <span>Click to upload or select file from File Manager</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="row">
                                    {{-- Name --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ old('name') }}" placeholder="Name">
                                    </div>

                                    {{-- Email --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', 'admin@gmail.com') }}" placeholder="Email">
                                    </div>

                                    {{-- Phone --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Phone</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ old('phone') }}" placeholder="Phone">
                                    </div>

                                    {{-- Password --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Password</label>
                                        <input type="password" name="password" class="form-control" placeholder="Password">
                                    </div>

                                    {{-- Confirm Password --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Confirmation Password</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Confirm Password">
                                    </div>

                                    {{-- Age --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Age (Year)</label>
                                        <input type="number" name="age" class="form-control"
                                            value="{{ old('age') }}" placeholder="Age (Year)">
                                    </div>

                                    {{-- Date of Birth --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Date of birth</label>
                                        <input type="date" name="dob" class="form-control"
                                            value="{{ old('dob') }}">
                                    </div>

                                    {{-- Height --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Height</label>
                                        <input type="text" name="height" class="form-control"
                                            value="{{ old('height') }}" placeholder="Height">
                                    </div>

                                    {{-- Weight --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Weight</label>
                                        <input type="text" name="weight" class="form-control"
                                            value="{{ old('weight') }}" placeholder="Weight">
                                    </div>

                                    {{-- Gender --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control">
                                            <option value="">Select Gender</option>
                                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>
                                                Female
                                            </option>
                                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>
                                                Other
                                            </option>
                                        </select>
                                    </div>

                                    {{-- Sex --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Sex</label>
                                        <input type="text" name="sex" class="form-control"
                                            value="{{ old('sex') }}" placeholder="Sex">
                                    </div>

                                    {{-- Blood Group --}}
                                    <div class="col-md-4 mb-3">
                                        <label>Blood group</label>
                                        <select name="blood_group" class="form-control">
                                            <option value="">Select One</option>
                                            <option value="A+" {{ old('blood_group') == 'A+' ? 'selected' : '' }}>
                                                A+
                                            </option>
                                            <option value="A-" {{ old('blood_group') == 'A-' ? 'selected' : '' }}>
                                                A-
                                            </option>
                                            <option value="B+" {{ old('blood_group') == 'B+' ? 'selected' : '' }}>
                                                B+
                                            </option>
                                            <option value="B-" {{ old('blood_group') == 'B-' ? 'selected' : '' }}>
                                                B-
                                            </option>
                                            <option value="O+" {{ old('blood_group') == 'O+' ? 'selected' : '' }}>
                                                O+
                                            </option>
                                            <option value="O-" {{ old('blood_group') == 'O-' ? 'selected' : '' }}>
                                                O-
                                            </option>
                                            <option value="AB+" {{ old('blood_group') == 'AB+' ? 'selected' : '' }}>AB+
                                            </option>
                                            <option value="AB-" {{ old('blood_group') == 'AB-' ? 'selected' : '' }}>AB-
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
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

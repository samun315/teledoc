@extends('master')

@section('title', 'Doctor List')
@section('content')
    <!--begin::Toolbar -->
    <x-toolbar-component title="Doctor List" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Doctor', 'url' => route('doctor.index')],
        ['label' => 'Doctor List', 'active' => true],
    ]" actionUrl="{{ route('doctor.create') }}"
        actionIcon="fas fa-plus" actionLabel="Create Doctor" />
    <!--end::Toolbar -->
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-3">
                                <!-- START SEARCH ICON-->
                                <x-search />
                                <!-- END SEARCH ICON-->
                            </div>
                            <div class="col-md-3">
                                <select name="department_id" id="department_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select Department" data-allow-clear="true">
                                    <option value=""></option>
                                    @foreach ($departments as $department)
                                        <option {{ old('department_id') ? 'selected' : '' }}
                                            value="{{ $department->department_id ?? old('department_id') }}">
                                            {{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body py-4">

                    @include('message')

                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="kt_doctor_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Photo</th>
                                    <th>Info</th>
                                    <th>Contact Info</th>
                                    <th>Action</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                        </table>
                    </div>
                    <!--end::Table-->
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
    <script src="{{ asset('assets/custom/js/doctor/doctor/index.js') }}"
        {{ Sri::html('assets/custom/js/doctor/doctor/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

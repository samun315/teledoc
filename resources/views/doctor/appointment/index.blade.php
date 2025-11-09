@extends('master')

@section('title', 'Doctor Appointment List')

@section('content')
    <x-toolbar-component title="Doctor Appointment List" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Doctor Appointment', 'url' => route('appointment.index')],
        ['label' => 'Doctor Appointment List', 'active' => true],
    ]" actionUrl="{{ route('appointment.create') }}"
        actionIcon="fas fa-plus-circle" actionLabel="Create" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <x-search />
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table table-row-dashed align-middle gs-0 gy-4" id="kt_appointment_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Appointment Id</th>
                                    <th>Appointment Date</th>
                                    <th>Doctor</th>
                                    <th>Patient</th>
                                    <th>Status</th>
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
    <script src="{{ asset('assets/custom/js/doctor/appointment/index.js') }}"
        {{ Sri::html('assets/custom/js/doctor/appointment/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

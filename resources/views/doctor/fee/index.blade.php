@extends('master')

@section('title', 'Doctor Fee Configuration')
@section('content')
    <!--begin::Toolbar -->
    <x-toolbar-component title="Doctor Fee Configuration" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Doctor', 'url' => route('doctor.index')],
        ['label' => 'Fee Configuration', 'active' => true],
    ]" />
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
                            <div class="col-md-4">
                                <!-- START SEARCH ICON-->
                                <x-search />
                                <!-- END SEARCH ICON-->
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
                            id="kt_doctor_fee_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Doctor Info</th>
                                    <th>Consultation Fee</th>
                                    <th>Platform Commission (%)</th>
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
    <script src="{{ asset('assets/custom/js/doctor/fee/index.js') }}"
        {{ Sri::html('assets/custom/js/doctor/fee/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

@extends('master')

@section('title', 'Prescription')
@section('page_css')
    <!-- Menu item custom css -->
    <link href="{{ asset('assets/custom/css/prescription/style.css') }}"
        {{ Sri::html('assets/custom/css/prescription/style.css') }} rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <x-toolbar-component title="Prescription List" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Prescription', 'url' => route('drug.prescription.index')],
        ['label' => 'Prescription List', 'active' => true],
    ]" modalTarget="openPatientModal"
        actionIcon="fas fa-plus-circle" actionLabel="Create Prescription" />
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
                                {{-- <select name="subscription_type_id" id="subscription_type_id"
                                    class="form-select form-select-solid" data-control="select2"
                                    data-placeholder="Select subscription type" data-allow-clear="true">
                                    <option value=""></option>
                                    @foreach ($subscriptionTypes as $subscriptionType)
                                        <option {{ old('subscription_type_id') ? 'selected' : '' }}
                                            value="{{ $subscriptionType->subscription_type_id ?? old('subscription_type_id') }}">
                                            {{ $subscriptionType->subscription_type }}</option>
                                    @endforeach --}}
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
                            id="kt_prescription_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Prescription Id</th>
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

    {{--start:: NEW PRESCRIPTION ADD MODAL --}}
    @include('drugs.prescription.modal.selectPatientModal')
    {{--end:: NEW PRESCRIPTION ADD MODAL --}}

@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/drugs/prescription/index.js') }}"
        {{ Sri::html('assets/custom/js/drugs/prescription/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

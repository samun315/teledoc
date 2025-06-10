@extends('master')

@section('title', 'Drug Doses List')

@section('content')
    <x-toolbar-component title="Drug Doses List" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Drug Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Drug Doses', 'url' => route('drug.doses.index')],
        ['label' => 'Drug Doses List', 'active' => true],
    ]" modalTarget="openDrugDosesModal"
        actionIcon="fas fa-plus-circle" actionLabel="Add new" />
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
                                <select name="drug_type_id" id="drug_type_id" class="form-select form-select-solid"
                                    data-control="select2" data-placeholder="Select drug type" data-allow-clear="true">
                                    <option value=""></option>
                                    @foreach ($drugTypes as $drugType)
                                        <option {{ old('drug_type_id') ? 'selected' : '' }}
                                            value="{{ $drugType->drug_type_id ?? old('drug_type_id') }}">
                                            {{ $drugType->drug_type }}</option>
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
                            id="kt_drug_doses_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Dose</th>
                                    <th>Drug Type</th>
                                    <th>Status</th>
                                    <th class="col-md-2">Action</th>
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
    @include('drugs.drugDoses.modal.addDrugDosesModal')

@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/drugs/drugDoses/index.js') }}"
        {{ Sri::html('assets/custom/js/drugs/drugDoses/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

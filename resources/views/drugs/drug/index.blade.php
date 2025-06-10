@extends('master')

@section('title', 'Drug List')

@section('content')
    <x-toolbar-component title="Drug List" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Drug Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Drug', 'url' => route('drug.index')],
        ['label' => 'Drug List', 'active' => true],
    ]" modalTarget="openDrugModal" actionIcon="fas fa-plus-circle"
        actionLabel="Add new" />
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
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4" id="kt_drug_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Trade</th>
                                    <th>Generic</th>
                                    <th>Side effect</th>
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
    {{-- start:: Drug add modal --}}
    @include('drugs.drug.modal.addDrugModal')
    {{-- end:: Drug add modal --}}

    {{-- start:: Drug view modal --}}
    @include('drugs.drug.modal.viewDrugModal')
    {{-- end:: Drug view modal --}}

@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/drugs/drug/index.js') }}"
        {{ Sri::html('assets/custom/js/drugs/drug/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

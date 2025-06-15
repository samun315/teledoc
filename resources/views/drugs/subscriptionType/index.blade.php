@extends('master')

@section('title', 'Subscription Type')

@section('content')
    <x-toolbar-component title="Subscription Type List" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Prescription Helper', 'url' => 'javascript:void(0)'],
        ['label' => 'Subscription Type', 'url' => route('drug.subscription.type.index')],
        ['label' => 'Subscription Type List', 'active' => true],
    ]" modalTarget="openSubscriptionTypeModal"
        actionIcon="fas fa-plus-circle" actionLabel="Add new" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Header-->
                {{-- <div class="card-header border-0 pt-5">
                    <x-search />
                </div> --}}
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <x-search />
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('drug.subscription.type.reorder') }}" class="btn btn-sm btn-info">
                            <i class="fas fa-bars"></i> Re-Order
                        </a>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="kt_subscription_type_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Type</th>
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
    @include('drugs.subscriptionType.modal.addSubscriptionTypeModal')

@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/drugs/subscriptionType/index.js') }}"
        {{ Sri::html('assets/custom/js/drugs/subscriptionType/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

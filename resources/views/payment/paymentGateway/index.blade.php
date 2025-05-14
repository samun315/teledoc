@extends('master')
@section('title', 'Manual Gateway')
<style nonce="{{$cspNonce}}">
    #kt_details_id table {
    width: 100%;
    border-collapse: collapse;
}

#kt_details_id th, #kt_details_id td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

#kt_details_id tr:nth-child(even) {
    background-color: #f2f2f2;
}

</style>
@section('content')
    <x-toolbar-component title="Manual Gateway list" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Wallet Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Manual Gateway list', 'active' => true],
    ]" modalTarget="openGatewayModal"
        actionIcon="fas fa-plus-circle" actionLabel="Create" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card header-->
                <div class="card-header border-0 pt-6">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <!--begin::Search-->
                        <div class="d-flex align-items-center position-relative my-1">
                            <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                            <span class="svg-icon svg-icon-1 position-absolute ms-6">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none">
                                    <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2"
                                        rx="1" transform="rotate(45 17.0365 15.1223)" fill="black"></rect>
                                    <path
                                        d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z"
                                        fill="black"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <x-search />
                        </div>
                        <!--end::Search-->
                    </div>
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body py-4">
                    <!--begin::Table-->
                    <div id="kt_table_users_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                        <div class="table-responsive">
                            <table class="table align-middle table-row-dashed fs-6 gy-5 dataTable no-footer"
                                id="kt_table_gateway">
                                <!--begin::Table head-->
                                <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                        <th>#</th>
                                        <th>Gateway</th>
                                        <th>Currency</th>
                                        <th>Rate</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                            </table>
                        </div>
                    </div>
                    <!--end::Table-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
            {{-- begin:: Manual Gateway modal --}}
            @include('payment.paymentGateway.modal.addGatewayModal')
            {{-- end:: Manual Gateway modal --}}

                {{-- begin:: Gateway Details modal --}}
                @include('payment.paymentGateway.modal.detailsModal')
                {{-- end:: Gateway Details modal --}}
        </div>
        <!--end::Container-->
    </div>
@endsection

@section('page_script')

    <script src="{{ asset('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"
        {{ Sri::html('assets/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}></script>
        
    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/payment/paymentGateway/index.js') }}"
        {{ Sri::html('assets/custom/js/payment/paymentGateway/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

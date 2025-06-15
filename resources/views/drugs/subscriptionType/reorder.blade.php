@extends('master')

@section('title', 'Subscription Type')

@section('page_css')
    <!-- Menu item custom css -->
    <link href="{{ asset('assets/custom/css/menu/menuItem/style.css') }}"
        {{ Sri::html('assets/custom/css/menu/menuItem/style.css') }} rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <x-toolbar-component title="Subscription Type Reorder" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Prescription Helper', 'url' => 'javascript:void(0)'],
        ['label' => 'Subscription Type', 'url' => route('drug.subscription.type.index')],
        ['label' => 'Subscription Type Reorder', 'active' => true],
    ]"
        actionUrl="{{ route('drug.subscription.type.index') }}" actionIcon="fas fa-table" actionLabel="Subscription List" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Card body-->
                <div class="card-body row">

                    <div class="cf mt-5">

                        <div class="dd" id="nestable">
                            <ol class="dd-list">
                                @foreach ($subscriptionTypes as $subscriptionType)
                                    <li class="dd-item" data-id="{{ $subscriptionType?->subscription_type_id }}">
                                        <div class="dd-handle">{{ $subscriptionType?->subscription_type }}</div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
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
    <script src="{{ asset('assets/custom/js/drugs/subscriptionType/index.js') }}"
        {{ Sri::html('assets/custom/js/drugs/subscriptionType/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            let updateTimeout;

            var updateOutput = function(e) {
                var list = e.length ? e : $(e.target),
                    output = list.data("output");

                if (window.JSON) {
                    output.val(JSON.stringify(list.nestable("serialize")));
                } else {
                    output.val("JSON browser support required for this demo.");
                }
            };

            // Activate Nestable
            $("#nestable").nestable({
                group: 1,
                maxDepth: 1, // Set max depth
            }).on("change", function() {
                // Debounce AJAX request to avoid frequent updates
                clearTimeout(updateTimeout);
                updateTimeout = setTimeout(saveSubscriptionOrder, 500);
            });

            function saveSubscriptionOrder() {
                let orderData = JSON.stringify($("#nestable").nestable("serialize"));

                $.ajax({
                    url: '{{ route('drug.subscription.type.reorder.update') }}',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        order: orderData,
                        _token: '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        // toastr.info("Updating menu order...", "Processing...");
                    },
                    success: function(response) {
                        if (response?.statusCode === 200) {
                            toastr.success(response?.message, "Success!");
                            window.location.reload();
                        } else {
                            toastr.error("Create child for parent!", "Error!");
                        }
                    },
                    error: function() {
                        toastr.error("Failed to update menu. Please try again.", "Error!");
                    }
                });
            }
        });
    </script>

@endsection

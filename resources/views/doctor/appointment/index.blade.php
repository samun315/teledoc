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
                                    <th>Payment Status</th>
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

    <!--begin::Payment Modal-->
    <div class="modal fade" id="kt_payment_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="fw-bold">Make Payment</h2>
                    <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form id="kt_payment_form">
                    <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                        <input type="hidden" id="payment_order_id" name="order_id">
                        
                        <div class="mb-7">
                            <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                            <select class="form-select form-select-solid" id="payment_method" name="payment_method" required>
                                <option value="">Select Payment Method</option>
                                <option value="BKASH">bKash</option>
                                <option value="NAGAD">Nagad</option>
                                <option value="ROCKET">Rocket</option>
                                <option value="CARD">Card</option>
                                <option value="CASH">Cash</option>
                            </select>
                        </div>

                        <div class="mb-7">
                            <label class="form-label fw-semibold">Amount (BDT)</label>
                            <input type="text" class="form-control form-control-solid" id="payment_amount" name="amount" readonly>
                        </div>

                        <div class="mb-7">
                            <label class="form-label fw-semibold">Discount (BDT)</label>
                            <input type="number" class="form-control form-control-solid" id="payment_discount" name="discount" value="0" min="0" step="0.01">
                        </div>

                        <div class="mb-7">
                            <label class="form-label fw-semibold">Final Amount (BDT)</label>
                            <input type="text" class="form-control form-control-solid fw-bold text-primary" id="payment_final_amount" readonly>
                        </div>

                        <div class="mb-7">
                            <label class="form-label fw-semibold">Transaction ID (Optional)</label>
                            <input type="text" class="form-control form-control-solid" id="payment_transaction_id" name="transaction_id" placeholder="Enter transaction ID">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="kt_payment_submit">
                            <span class="indicator-label">Process Payment</span>
                            <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--end::Payment Modal-->

@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script>
        // Define route URLs for payment - ensure absolute URLs
        const ORDER_DETAILS_BASE_URL = "{{ url('/order/get-order-details') }}";
        const PROCESS_PAYMENT_URL = "{{ url('/order/process-payment') }}";
        console.log('ORDER_DETAILS_BASE_URL:', ORDER_DETAILS_BASE_URL);
    </script>
    <script src="{{ asset('assets/custom/js/doctor/appointment/index.js') }}"
        {{ Sri::html('assets/custom/js/doctor/appointment/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

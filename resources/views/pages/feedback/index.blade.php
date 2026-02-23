@extends('master')

@section('title', 'Feedback Management')

@section('content')
    <x-toolbar-component title="Feedback Management" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Feedback Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Feedback List', 'active' => true],
    ]" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <!-- Search is handled by DataTables built-in search -->
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="kt_feedback_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Message</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                <!-- Data will be loaded via DataTables -->
                            </tbody>
                            <!--end::Table body-->
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
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            // Load data via AJAX
            $.ajax({
                url: '{{ route("feedback.getData") }}',
                type: 'GET',
                success: function(response) {
                    // Initialize DataTable
                    var table = $('#kt_feedback_table').DataTable({
                        data: response.data,
                        columns: [
                            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                            { data: 'name', name: 'name' },
                            { data: 'phone', name: 'phone' },
                            { data: 'message', name: 'message' },
                            { 
                                data: 'status', 
                                name: 'status',
                                render: function(data, type, row) {
                                    var badgeClass = 'badge-light-warning';
                                    if (data === 'Read') {
                                        badgeClass = 'badge-light-info';
                                    } else if (data === 'Replied') {
                                        badgeClass = 'badge-light-success';
                                    }
                                    return '<span class="badge ' + badgeClass + '">' + data + '</span>';
                                }
                            },
                            { data: 'created_at', name: 'created_at' },
                            { data: 'action', name: 'action', orderable: false, searchable: false }
                        ],
                        order: [[5, 'desc']], // Order by date descending
                        pageLength: 10,
                        language: {
                            emptyTable: "No feedback found"
                        }
                    });
                },
                error: function() {
                    alert('Failed to load feedback data');
                }
            });
        });
    </script>
@endsection

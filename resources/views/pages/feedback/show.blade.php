@extends('master')

@section('title', 'Feedback Details')

@section('content')
    <x-toolbar-component title="Feedback Details" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Feedback Management', 'url' => route('feedback.index')],
        ['label' => 'Feedback Details', 'active' => true],
    ]" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <div class="row">
                        <div class="col-md-8">
                            <!--begin::Feedback Information-->
                            <div class="mb-10">
                                <h3 class="mb-5">Feedback Information</h3>
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th class="w-200px">Name:</th>
                                                <td>{{ $feedback->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Phone:</th>
                                                <td>
                                                    <a href="tel:{{ $feedback->phone }}">{{ $feedback->phone }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Status:</th>
                                                <td>
                                                    <span class="badge badge-light-{{ $feedback->status === 'Pending' ? 'warning' : ($feedback->status === 'Read' ? 'info' : 'success') }}">
                                                        {{ $feedback->status }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Submitted Date:</th>
                                                <td>{{ $feedback->created_at->format('d M, Y h:i A') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Message:</th>
                                                <td>
                                                    <div class="p-3 bg-light rounded">
                                                        {{ $feedback->message }}
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!--end::Feedback Information-->

                            <!--begin::Admin Notes-->
                            <div class="mb-10">
                                <h3 class="mb-5">Admin Notes</h3>
                                <form id="updateStatusForm">
                                    @csrf
                                    <div class="mb-5">
                                        <label class="form-label">Status</label>
                                        <select name="status" id="status" class="form-select">
                                            <option value="Pending" {{ $feedback->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="Read" {{ $feedback->status === 'Read' ? 'selected' : '' }}>Read</option>
                                            <option value="Replied" {{ $feedback->status === 'Replied' ? 'selected' : '' }}>Replied</option>
                                        </select>
                                    </div>
                                    <div class="mb-5">
                                        <label class="form-label">Admin Notes</label>
                                        <textarea name="admin_notes" id="admin_notes" class="form-control" rows="4" placeholder="Add internal notes...">{{ $feedback->admin_notes }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Update Status
                                    </button>
                                </form>
                            </div>
                            <!--end::Admin Notes-->
                        </div>
                    </div>

                    <!--begin::Actions-->
                    <div class="d-flex justify-content-end gap-2 mt-10">
                        <a href="{{ route('feedback.index') }}" class="btn btn-light">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                    <!--end::Actions-->
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
            $('#updateStatusForm').on('submit', function(e) {
                e.preventDefault();
                
                const formData = {
                    status: $('#status').val(),
                    admin_notes: $('#admin_notes').val(),
                    _token: $('input[name="_token"]').val()
                };
                
                $.ajax({
                    url: '{{ route("feedback.updateStatus", $feedback->feedback_id) }}',
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            // Show success message with iziToast
                            if (typeof iziToast !== 'undefined') {
                                iziToast.success({
                                    title: 'Success',
                                    message: 'Status updated successfully',
                                    position: 'topRight',
                                    timeout: 3000
                                });
                            } else {
                                alert('Status updated successfully');
                            }
                            // Reload page to show updated status after a short delay
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(xhr) {
                        // Show error message with iziToast
                        if (typeof iziToast !== 'undefined') {
                            iziToast.error({
                                title: 'Error',
                                message: 'Failed to update status. Please try again.',
                                position: 'topRight',
                                timeout: 3000
                            });
                        } else {
                            alert('Failed to update status. Please try again.');
                        }
                    }
                });
            });
        });
    </script>
@endsection

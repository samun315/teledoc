@extends('master')

@section('title', 'FAQs')

@section('content')
    <x-toolbar-component title="FAQs" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'FAQ Management', 'url' => 'javascript:void(0)'],
        ['label' => 'FAQs', 'active' => true],
    ]" actionIcon="fas fa-plus-circle" actionLabel="Add New FAQ" actionUrl="{{ route('faq.create') }}" />

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
                            id="kt_faq_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Question</th>
                                    <th>Answer Preview</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse($faqs as $faq)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fw-bold fs-6">{{ $faq->question }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted fs-7">{{ Str::limit(strip_tags($faq->answer), 100) }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ $faq->order }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-{{ $faq->status === 'Active' ? 'success' : 'danger' }} status-badge"
                                                  data-id="{{ $faq->faq_id }}"
                                                  style="cursor: pointer;">
                                                {{ $faq->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('faq.edit', $faq->faq_id) }}"
                                                   class="btn btn-sm btn-light-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-sm btn-light-danger delete-btn"
                                                        data-id="{{ $faq->faq_id }}"
                                                        data-title="{{ $faq->question }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p>No FAQs found</p>
                                        </td>
                                    </tr>
                                @endforelse
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

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "<span id="faqTitle"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_script')
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            let deleteId = null;

            // Delete button click handler
            $('.delete-btn').on('click', function() {
                deleteId = $(this).data('id');
                var faqTitle = $(this).data('title');
                
                $('#faqTitle').text(faqTitle);
                $('#deleteModal').modal('show');
            });

            // Confirm delete handler
            $('#confirmDelete').on('click', function() {
                if (deleteId) {
                    $.ajax({
                        url: '{{ route('faq.delete', ':id') }}'.replace(':id', deleteId),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#deleteModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Failed to delete FAQ');
                        }
                    });
                }
            });

            // Status toggle handler
            $('.status-badge').on('click', function() {
                var faqId = $(this).data('id');
                var badge = $(this);
                
                $.ajax({
                    url: '{{ route('faq.changeStatus', ':id') }}'.replace(':id', faqId),
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            // Update badge
                            badge.removeClass('badge-light-success badge-light-danger');
                            badge.addClass(response.status === 'Active' ? 'badge-light-success' : 'badge-light-danger');
                            badge.text(response.status);
                        }
                    },
                    error: function(xhr) {
                        alert('Failed to update status');
                    }
                });
            });

            // Initialize DataTable
            $('#kt_faq_table').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": true
            });
        });
    </script>
@endsection


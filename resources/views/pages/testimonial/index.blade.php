@extends('master')

@section('title', 'Testimonials')

@section('content')
    <x-toolbar-component title="Testimonials" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Testimonial Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Testimonials', 'active' => true],
    ]" actionIcon="fas fa-plus-circle" actionLabel="Add New Testimonial" actionUrl="{{ route('testimonial.create') }}" />

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
                            id="kt_testimonial_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Designation</th>
                                    <th>Rating</th>
                                    <th>Order</th>
                                    <th>Featured</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse($testimonials as $testimonial)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($testimonial->patient_image)
                                                <img src="{{ asset('storage/' . $testimonial->patient_image) }}"
                                                     alt="{{ $testimonial->patient_name }}"
                                                     class="rounded-circle"
                                                     style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center"
                                                     style="width: 50px; height: 50px;">
                                                    <i class="fas fa-user text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fw-bold fs-6">{{ $testimonial->patient_name }}</span>
                                                <span class="text-muted fs-7">{{ Str::limit($testimonial->testimonial_text, 50) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($testimonial->patient_designation)
                                                <span class="badge badge-light-info">{{ $testimonial->patient_designation }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($testimonial->rating)
                                                <div class="rating">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                                    @endfor
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ $testimonial->order }}</span>
                                        </td>
                                        <td>
                                            @if($testimonial->is_featured)
                                                <span class="badge badge-light-success">
                                                    <i class="fas fa-star me-1"></i>Featured
                                                </span>
                                            @else
                                                <span class="badge badge-light-secondary">Normal</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge badge-light-{{ $testimonial->status === 'Active' ? 'success' : 'danger' }} status-badge"
                                                  data-id="{{ $testimonial->testimonial_id }}"
                                                  style="cursor: pointer;">
                                                {{ $testimonial->status }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('testimonial.edit', $testimonial->testimonial_id) }}"
                                                   class="btn btn-sm btn-light-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-sm btn-light-danger delete-btn"
                                                        data-id="{{ $testimonial->testimonial_id }}"
                                                        data-title="{{ $testimonial->patient_name }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p>No testimonials found</p>
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
                    Are you sure you want to delete testimonial from "<span id="testimonialTitle"></span>"?
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
                var testimonialTitle = $(this).data('title');

                $('#testimonialTitle').text(testimonialTitle);
                $('#deleteModal').modal('show');
            });

            // Confirm delete handler
            $('#confirmDelete').on('click', function() {
                if (deleteId) {
                    $.ajax({
                        url: '{{ route('testimonial.delete', ':id') }}'.replace(':id', deleteId),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#deleteModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Failed to delete testimonial');
                        }
                    });
                }
            });

            // Status toggle handler
            $('.status-badge').on('click', function() {
                var testimonialId = $(this).data('id');
                var badge = $(this);

                $.ajax({
                    url: '{{ route('testimonial.changeStatus', ':id') }}'.replace(':id', testimonialId),
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
            $('#kt_testimonial_table').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": true
            });
        });
    </script>
@endsection


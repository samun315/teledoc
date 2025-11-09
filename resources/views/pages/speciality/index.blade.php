@extends('master')

@section('title', 'Specialities')

@section('content')
    <x-toolbar-component title="Specialities" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Speciality Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Specialities', 'active' => true],
    ]" actionIcon="fas fa-plus-circle" actionLabel="Add New Speciality" actionUrl="{{ route('speciality.create') }}" />

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
                            id="kt_speciality_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Icon</th>
                                    <th>Title</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse($specialities as $speciality)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($speciality->icon)
                                                <i class="{{ $speciality->icon }} fs-2x text-primary"></i>
                                            @else
                                                <i class="fas fa-check-circle fs-2x text-muted"></i>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fw-bold fs-6">{{ $speciality->title }}</span>
                                                <span class="text-muted fs-7">{{ Str::limit($speciality->description, 50) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ $speciality->order }}</span>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-{{ $speciality->status === 'Active' ? 'success' : 'danger' }} status-badge"
                                                  data-id="{{ $speciality->speciality_id }}"
                                                  style="cursor: pointer;">
                                                {{ $speciality->status }}
                                            </span>
                                        </td>
                                        <td>{{ $speciality->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('speciality.edit', $speciality->speciality_id) }}"
                                                   class="btn btn-sm btn-light-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-sm btn-light-danger delete-btn"
                                                        data-id="{{ $speciality->speciality_id }}"
                                                        data-title="{{ $speciality->title }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p>No specialities found</p>
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
                    Are you sure you want to delete "<span id="specialityTitle"></span>"?
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
                var specialityTitle = $(this).data('title');
                
                $('#specialityTitle').text(specialityTitle);
                $('#deleteModal').modal('show');
            });

            // Confirm delete handler
            $('#confirmDelete').on('click', function() {
                if (deleteId) {
                    $.ajax({
                        url: '{{ route('speciality.delete', ':id') }}'.replace(':id', deleteId),
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            $('#deleteModal').modal('hide');
                            location.reload();
                        },
                        error: function(xhr) {
                            alert('Failed to delete speciality');
                        }
                    });
                }
            });

            // Status toggle handler
            $('.status-badge').on('click', function() {
                var specialityId = $(this).data('id');
                var badge = $(this);
                
                $.ajax({
                    url: '{{ route('speciality.changeStatus', ':id') }}'.replace(':id', specialityId),
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
            $('#kt_speciality_table').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": true
            });
        });
    </script>
@endsection


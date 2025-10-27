@extends('master')

@section('title', 'Sliders')

@section('content')
    <x-toolbar-component title="Home Sliders" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Slider Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Sliders', 'active' => true],
    ]" actionIcon="fas fa-plus-circle" actionLabel="Add New Slider" actionUrl="{{ route('slider.slider.create') }}" />

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
                            id="kt_slider_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Background</th>
                                    <th>Shape</th>
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
                                @forelse($sliders as $slider)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if($slider->image)
                                                <img src="{{ asset('storage/' . $slider->image) }}"
                                                     alt="{{ $slider->title }}"
                                                     class="w-80px h-40px rounded object-fit-cover">
                                            @else
                                                <div class="w-80px h-40px bg-light rounded d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-image text-muted fs-8"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($slider->shape_image)
                                                <img src="{{ asset('storage/' . $slider->shape_image) }}"
                                                     alt="Shape"
                                                     class="w-80px h-40px rounded object-fit-cover">
                                            @else
                                                <div class="w-80px h-40px bg-light rounded d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-shapes text-muted fs-8"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fw-bold fs-6">{{ $slider->title }}</span>
                                                @if($slider->subtitle)
                                                    <span class="text-muted fs-7">{{ Str::limit($slider->subtitle, 50) }}</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-light-info">{{ $slider->order }}</span>
                                        </td>
                                        <td>
                                            @if($slider->status === 'Active')
                                                <span class="badge badge-light-success">Active</span>
                                            @else
                                                <span class="badge badge-light-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td>{{ $slider->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('slider.slider.edit', $slider->slider_id) }}"
                                                   class="btn btn-sm btn-light-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-sm btn-light-danger delete-btn"
                                                        data-id="{{ $slider->slider_id }}"
                                                        data-title="{{ $slider->title }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p>No sliders found</p>
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
                    Are you sure you want to delete "<span id="sliderTitle"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_script')
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            // Delete button click handler
            $('.delete-btn').on('click', function() {
                var sliderId = $(this).data('id');
                var sliderTitle = $(this).data('title');

                $('#sliderTitle').text(sliderTitle);
                $('#deleteForm').attr('action', '{{ route('slider.slider.delete', ':id') }}'.replace(':id', sliderId));
                $('#deleteModal').modal('show');
            });

            // Initialize DataTable if needed
            $('#kt_slider_table').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": true
            });
        });
    </script>
@endsection


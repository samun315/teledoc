@extends('master')

@section('title', 'Edit Speciality')

@section('content')
    <x-toolbar-component title="Edit Speciality" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Speciality Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Specialities', 'url' => route('speciality.index')],
        ['label' => 'Edit Speciality', 'active' => true],
    ]" actionIcon="fas fa-arrow-left" actionLabel="Back to List" actionUrl="{{ route('speciality.index') }}" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <form id="specialityForm" action="{{ route('speciality.update', $speciality->speciality_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Title -->
                                <div class="mb-5">
                                    <label for="title" class="form-label required">Speciality Title</label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title', $speciality->title) }}"
                                           placeholder="Enter speciality title (e.g., Child Care, 24 Hour Doctor)"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-5">
                                    <label for="description" class="form-label required">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror"
                                              id="description"
                                              name="description"
                                              rows="5"
                                              placeholder="Enter a brief description about this speciality"
                                              required>{{ old('description', $speciality->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">This will be displayed on the about page</div>
                                </div>

                                <!-- Icon Class -->
                                <div class="mb-5">
                                    <label for="icon" class="form-label">Icon Class</label>
                                    <input type="text"
                                           class="form-control @error('icon') is-invalid @enderror"
                                           id="icon"
                                           name="icon"
                                           value="{{ old('icon', $speciality->icon) }}"
                                           placeholder="e.g., icofont-check-circled">
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Enter icon class name (e.g., icofont-check-circled, icofont-doctor)</div>
                                    <div id="iconPreview" class="mt-2">
                                        <i id="previewIcon" class="{{ $speciality->icon ?? 'icofont-check-circled' }} fs-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-4">
                                <!-- Order -->
                                <div class="mb-5">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number"
                                           class="form-control @error('order') is-invalid @enderror"
                                           id="order"
                                           name="order"
                                           value="{{ old('order', $speciality->order) }}"
                                           min="0"
                                           placeholder="0">
                                    @error('order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Lower numbers appear first</div>
                                </div>

                                <!-- Status -->
                                <div class="mb-5">
                                    <label for="status" class="form-label required">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status"
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="Active" {{ old('status', $speciality->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status', $speciality->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('speciality.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Speciality
                            </button>
                        </div>
                    </form>
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
            // Icon preview
            $('#icon').on('input', function() {
                var iconClass = $(this).val();
                if (iconClass) {
                    $('#previewIcon').attr('class', iconClass + ' fs-2x text-primary');
                    $('#iconPreview').show();
                } else {
                    $('#iconPreview').hide();
                }
            });

            // Trigger initial icon preview
            $('#icon').trigger('input');
        });
    </script>
@endsection


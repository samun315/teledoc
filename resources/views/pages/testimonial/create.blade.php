@extends('master')

@section('title', 'Create Testimonial')

@section('content')
    <x-toolbar-component title="Create Testimonial" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Testimonial Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Testimonials', 'url' => route('testimonial.index')],
        ['label' => 'Create Testimonial', 'active' => true],
    ]" actionIcon="fas fa-arrow-left" actionLabel="Back to List" actionUrl="{{ route('testimonial.index') }}" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <form id="testimonialForm" action="{{ route('testimonial.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Patient Name -->
                                <div class="mb-5">
                                    <label for="patient_name" class="form-label required">Patient Name</label>
                                    <input type="text"
                                           class="form-control @error('patient_name') is-invalid @enderror"
                                           id="patient_name"
                                           name="patient_name"
                                           value="{{ old('patient_name') }}"
                                           placeholder="Enter patient name"
                                           required>
                                    @error('patient_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Patient Designation -->
                                <div class="mb-5">
                                    <label for="patient_designation" class="form-label">Patient Designation</label>
                                    <input type="text"
                                           class="form-control @error('patient_designation') is-invalid @enderror"
                                           id="patient_designation"
                                           name="patient_designation"
                                           value="{{ old('patient_designation') }}"
                                           placeholder="e.g., Patient, Family Member, Doctor">
                                    @error('patient_designation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional role or relation of the person</div>
                                </div>

                                <!-- Testimonial Text -->
                                <div class="mb-5">
                                    <label for="testimonial_text" class="form-label required">Testimonial Text</label>
                                    <textarea class="form-control @error('testimonial_text') is-invalid @enderror"
                                              id="testimonial_text"
                                              name="testimonial_text"
                                              rows="6"
                                              placeholder="Enter testimonial message here..."
                                              required>{{ old('testimonial_text') }}</textarea>
                                    @error('testimonial_text')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">The patient's feedback or testimonial</div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-4">
                                <!-- Patient Image -->
                                <div class="mb-5">
                                    <label for="patient_image" class="form-label">Patient Image</label>
                                    <div class="image-input-wrapper">
                                        <input type="file"
                                               class="form-control @error('patient_image') is-invalid @enderror"
                                               id="patient_image"
                                               name="patient_image"
                                               accept="image/*">
                                        <div class="form-text">Max size: 2MB. Patient photo</div>
                                        @error('patient_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" class="img-fluid rounded-circle" style="width: 100px; height: 100px; object-fit: cover;">
                                    </div>
                                </div>

                                <!-- Rating -->
                                <div class="mb-5">
                                    <label for="rating" class="form-label">Rating</label>
                                    <select class="form-select @error('rating') is-invalid @enderror"
                                            id="rating"
                                            name="rating">
                                        <option value="">Select Rating</option>
                                        <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5 Stars)</option>
                                        <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4 Stars)</option>
                                        <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3 Stars)</option>
                                        <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2 Stars)</option>
                                        <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>⭐ (1 Star)</option>
                                    </select>
                                    @error('rating')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional rating from 1 to 5 stars</div>
                                </div>

                                <!-- Order -->
                                <div class="mb-5">
                                    <label for="order" class="form-label">Display Order</label>
                                    <input type="number"
                                           class="form-control @error('order') is-invalid @enderror"
                                           id="order"
                                           name="order"
                                           value="{{ old('order', 0) }}"
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
                                        <option value="Active" {{ old('status') == 'Active' ? 'selected' : 'selected' }}>Active</option>
                                        <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Is Featured -->
                                <div class="mb-5">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               id="is_featured"
                                               name="is_featured"
                                               value="1"
                                               {{ old('is_featured') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_featured">
                                            Featured Testimonial
                                        </label>
                                    </div>
                                    <div class="form-text">Highlight this testimonial</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('testimonial.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Testimonial
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
            // Image preview
            $('#patient_image').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#previewImg').attr('src', e.target.result);
                        $('#imagePreview').show();
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection


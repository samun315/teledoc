@extends('master')

@section('title', 'Create Slider')

@section('content')
    <x-toolbar-component title="Create Slider" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Slider Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Sliders', 'url' => route('slider.slider.index')],
        ['label' => 'Create Slider', 'active' => true],
    ]" actionIcon="fas fa-arrow-left" actionLabel="Back to List" actionUrl="{{ route('slider.slider.index') }}" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <form id="sliderForm" action="{{ route('slider.slider.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Title -->
                                <div class="mb-5">
                                    <label for="title" class="form-label required">Title</label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           placeholder="Enter slider title"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Subtitle -->
                                <div class="mb-5">
                                    <label for="subtitle" class="form-label">Subtitle / Description</label>
                                    <textarea class="form-control @error('subtitle') is-invalid @enderror"
                                              id="subtitle"
                                              name="subtitle"
                                              rows="3"
                                              placeholder="Enter slider subtitle or description">{{ old('subtitle') }}</textarea>
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Button 1 -->
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label for="button_text_1" class="form-label">Button 1 Text</label>
                                        <input type="text"
                                               class="form-control @error('button_text_1') is-invalid @enderror"
                                               id="button_text_1"
                                               name="button_text_1"
                                               value="{{ old('button_text_1') }}"
                                               placeholder="e.g., Get Appointment">
                                        @error('button_text_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="button_url_1" class="form-label">Button 1 URL</label>
                                        <input type="text"
                                               class="form-control @error('button_url_1') is-invalid @enderror"
                                               id="button_url_1"
                                               name="button_url_1"
                                               value="{{ old('button_url_1') }}"
                                               placeholder="e.g., /appointment">
                                        @error('button_url_1')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Button 2 -->
                                <div class="row">
                                    <div class="col-md-6 mb-5">
                                        <label for="button_text_2" class="form-label">Button 2 Text</label>
                                        <input type="text"
                                               class="form-control @error('button_text_2') is-invalid @enderror"
                                               id="button_text_2"
                                               name="button_text_2"
                                               value="{{ old('button_text_2') }}"
                                               placeholder="e.g., Learn More">
                                        @error('button_text_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 mb-5">
                                        <label for="button_url_2" class="form-label">Button 2 URL</label>
                                        <input type="text"
                                               class="form-control @error('button_url_2') is-invalid @enderror"
                                               id="button_url_2"
                                               name="button_url_2"
                                               value="{{ old('button_url_2') }}"
                                               placeholder="e.g., /about">
                                        @error('button_url_2')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-4">
                                <!-- Background Image -->
                                <div class="mb-5">
                                    <label for="image" class="form-label">Background Image</label>
                                    <div class="image-input-wrapper">
                                        <input type="file"
                                               class="form-control @error('image') is-invalid @enderror"
                                               id="image"
                                               name="image"
                                               accept="image/*">
                                        <div class="form-text">Max size: 2MB. Full slider background</div>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                </div>

                                <!-- Shape Image -->
                                <div class="mb-5">
                                    <label for="shape_image" class="form-label">Shape Image (Overlay)</label>
                                    <div class="image-input-wrapper">
                                        <input type="file"
                                               class="form-control @error('shape_image') is-invalid @enderror"
                                               id="shape_image"
                                               name="shape_image"
                                               accept="image/*">
                                        <div class="form-text">Max size: 2MB. Decorative shape/illustration</div>
                                        @error('shape_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="shapeImagePreview" class="mt-2" style="display: none;">
                                        <img id="shapePreviewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
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
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('slider.slider.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Slider
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
            // Background image preview
            $('#image').on('change', function(e) {
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

            // Shape image preview
            $('#shape_image').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#shapePreviewImg').attr('src', e.target.result);
                        $('#shapeImagePreview').show();
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
@endsection


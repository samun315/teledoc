@extends('master')

@section('title', 'Create Service')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
    <x-toolbar-component title="Create Service" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Service Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Services', 'url' => route('service.service.index')],
        ['label' => 'Create Service', 'active' => true],
    ]" actionIcon="fas fa-arrow-left" actionLabel="Back to List" actionUrl="{{ route('service.service.index') }}" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <form id="serviceForm" action="{{ route('service.service.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Title -->
                                <div class="mb-5">
                                    <label for="title" class="form-label required">Service Title</label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           placeholder="Enter service title"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Short Description -->
                                <div class="mb-5">
                                    <label for="short_description" class="form-label required">Short Description</label>
                                    <textarea class="form-control @error('short_description') is-invalid @enderror"
                                              id="short_description"
                                              name="short_description"
                                              rows="3"
                                              placeholder="Brief description for service card"
                                              required>{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">This will appear on the service card</div>
                                </div>

                                <!-- Content -->
                                <div class="mb-5">
                                    <label for="content" class="form-label required">Detailed Content</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                              id="content"
                                              name="content"
                                              rows="15"
                                              placeholder="Write detailed service content here..."
                                              required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Icon Class -->
                                <div class="mb-5">
                                    <label for="icon" class="form-label">Icon Class</label>
                                    <input type="text"
                                           class="form-control @error('icon') is-invalid @enderror"
                                           id="icon"
                                           name="icon"
                                           value="{{ old('icon') }}"
                                           placeholder="e.g., icofont-doctor">
                                    @error('icon')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Enter icon class name (e.g., icofont-doctor, icofont-tooth)</div>
                                    <div id="iconPreview" class="mt-2" style="display: none;">
                                        <i id="previewIcon" class="fs-2x text-primary"></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-4">
                                <!-- Banner Image -->
                                <div class="mb-5">
                                    <label for="banner_image" class="form-label">Banner Image</label>
                                    <div class="image-input-wrapper">
                                        <input type="file"
                                               class="form-control @error('banner_image') is-invalid @enderror"
                                               id="banner_image"
                                               name="banner_image"
                                               accept="image/*">
                                        <div class="form-text">Max size: 2MB. Top hero image</div>
                                        @error('banner_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="bannerPreview" class="mt-2" style="display: none;">
                                        <img id="bannerImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
                                    </div>
                                </div>

                                <!-- Detail Image -->
                                <div class="mb-5">
                                    <label for="detail_image" class="form-label">Detail Image</label>
                                    <div class="image-input-wrapper">
                                        <input type="file"
                                               class="form-control @error('detail_image') is-invalid @enderror"
                                               id="detail_image"
                                               name="detail_image"
                                               accept="image/*">
                                        <div class="form-text">Max size: 2MB. Secondary image</div>
                                        @error('detail_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="detailPreview" class="mt-2" style="display: none;">
                                        <img id="detailImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
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

                                <!-- Meta Description -->
                                <div class="mb-5">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                              id="meta_description"
                                              name="meta_description"
                                              rows="3"
                                              placeholder="SEO meta description">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maximum 160 characters</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('service.service.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Service
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
    <script src="{{ asset('assets/plugins/custom/summernote/summernote-bs4.js') }}"
    {{ Sri::html('assets/plugins/custom/summernote/summernote-bs4.js') }}></script>

    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            // Initialize Summernote
            $('#content').summernote({
                height: 300,
                callbacks: {
                    onImageUpload: function(files) {
                        sendFile(files[0], $(this));
                    }
                }
            });

            // Banner image preview
            $('#banner_image').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#bannerImg').attr('src', e.target.result);
                        $('#bannerPreview').show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Detail image preview
            $('#detail_image').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#detailImg').attr('src', e.target.result);
                        $('#detailPreview').show();
                    };
                    reader.readAsDataURL(file);
                }
            });

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
        });

        // Override the sendFile function with proper route URL
        function sendFile(file, editor, welEditable) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            data = new FormData();
            data.append("file", file);
            $.ajax({
                data: data,
                type: "POST",
                url: "{{ route('admin.summernote.uploadImage') . '?_token=' . csrf_token() }}",
                cache: false,
                contentType: false,
                processData: false,
                success: function (data) {
                    $('#content').summernote('editor.insertImage', data.url);
                }
            });
        }
    </script>
@endsection


@extends('master')

@section('title', 'About Section Settings')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <!-- Page Header -->
        <div class="card mb-5">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h1 class="mb-0">About Section Settings</h1>
                </div>
            </div>
        </div>

        <!-- Settings Card -->
        <div class="card">
            <div class="card-body">
                <form id="aboutSectionForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <!-- Title -->
                            <div class="mb-5">
                                <label for="title" class="form-label required">Title</label>
                                <input type="text"
                                       class="form-control"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $about->title ?? '') }}"
                                       placeholder="Enter about section title"
                                       required>
                            </div>

                            <!-- Description with Summernote -->
                            <div class="mb-5">
                                <label for="description" class="form-label required">Description</label>
                                <textarea class="form-control"
                                          id="description"
                                          name="description"
                                          rows="10"
                                          placeholder="Enter about section description"
                                          required>{{ old('description', $about->description ?? '') }}</textarea>
                            </div>

                            <!-- Features -->
                            <div class="mb-5">
                                <label class="form-label">Features</label>
                                <div class="mb-3">
                                    <input type="text"
                                           class="form-control"
                                           id="feature_1"
                                           name="feature_1"
                                           value="{{ old('feature_1', $about->feature_1 ?? '') }}"
                                           placeholder="Feature 1 (e.g., Browse Our Website)">
                                </div>
                                <div class="mb-3">
                                    <input type="text"
                                           class="form-control"
                                           id="feature_2"
                                           name="feature_2"
                                           value="{{ old('feature_2', $about->feature_2 ?? '') }}"
                                           placeholder="Feature 2 (e.g., Choose Service)">
                                </div>
                                <div class="mb-3">
                                    <input type="text"
                                           class="form-control"
                                           id="feature_3"
                                           name="feature_3"
                                           value="{{ old('feature_3', $about->feature_3 ?? '') }}"
                                           placeholder="Feature 3 (e.g., Send Message)">
                                </div>
                            </div>

                            <!-- Button -->
                            <div class="row">
                                <div class="col-md-6 mb-5">
                                    <label for="button_text" class="form-label">Button Text</label>
                                    <input type="text"
                                           class="form-control"
                                           id="button_text"
                                           name="button_text"
                                           value="{{ old('button_text', $about->button_text ?? 'Know More') }}"
                                           placeholder="e.g., Know More">
                                </div>
                                <div class="col-md-6 mb-5">
                                    <label for="button_link" class="form-label">Button Link</label>
                                    <input type="text"
                                           class="form-control"
                                           id="button_link"
                                           name="button_link"
                                           value="{{ old('button_link', $about->button_link ?? route('about')) }}"
                                           placeholder="e.g., /about or route name">
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <!-- Left Image -->
                            <div class="mb-5">
                                <label for="left_image" class="form-label">Left Image</label>
                                <div class="image-input-wrapper">
                                    <input type="file"
                                           class="form-control"
                                           id="left_image"
                                           name="left_image"
                                           accept="image/*">
                                    <div class="form-text">Max size: 2MB</div>
                                </div>
                                
                                <!-- Current Left Image -->
                                @if(isset($about->left_image) && $about->left_image)
                                    <div class="mt-2">
                                        <label class="form-label">Current Left Image:</label>
                                        <img src="{{ asset('storage/' . $about->left_image) }}"
                                             alt="Left Image"
                                             class="img-fluid rounded"
                                             style="max-height: 150px;">
                                    </div>
                                @endif

                                <!-- New Left Preview -->
                                <div id="leftPreview" class="mt-2" style="display: none;">
                                    <label class="form-label">New Left Preview:</label>
                                    <img id="leftImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>

                            <!-- Right Image -->
                            <div class="mb-5">
                                <label for="right_image" class="form-label">Right Image</label>
                                <div class="image-input-wrapper">
                                    <input type="file"
                                           class="form-control"
                                           id="right_image"
                                           name="right_image"
                                           accept="image/*">
                                    <div class="form-text">Max size: 2MB</div>
                                </div>
                                
                                <!-- Current Right Image -->
                                @if(isset($about->right_image) && $about->right_image)
                                    <div class="mt-2">
                                        <label class="form-label">Current Right Image:</label>
                                        <img src="{{ asset('storage/' . $about->right_image) }}"
                                             alt="Right Image"
                                             class="img-fluid rounded"
                                             style="max-height: 150px;">
                                    </div>
                                @endif

                                <!-- New Right Preview -->
                                <div id="rightPreview" class="mt-2" style="display: none;">
                                    <label class="form-label">New Right Preview:</label>
                                    <img id="rightImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 150px;">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mb-5">
                                <label for="status" class="form-label required">Status</label>
                                <select class="form-select"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="Active" {{ (isset($about->status) && $about->status == 'Active') ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ (isset($about->status) && $about->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <button type="submit" class="btn btn-primary">
                            <i class="icofont-save"></i> Save About Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page_script')
    <script src="{{ asset('assets/plugins/custom/summernote/summernote-bs4.js') }}"></script>

    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            // Initialize Summernote
            $('#description').summernote({
                height: 300,
                callbacks: {
                    onImageUpload: function(files) {
                        sendFile(files[0], $(this));
                    }
                }
            });

            // Left image preview
            $('#left_image').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#leftImg').attr('src', e.target.result);
                        $('#leftPreview').show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Right image preview
            $('#right_image').on('change', function(e) {
                var file = e.target.files[0];
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#rightImg').attr('src', e.target.result);
                        $('#rightPreview').show();
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Form submission
            $('#aboutSectionForm').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);
                
                $.ajax({
                    url: '{{ route('admin.settings.about.update') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        var errorMessage = 'An error occurred';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage
                        });
                    }
                });
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
                    $('#description').summernote('editor.insertImage', data.url);
                }
            });
        }
    </script>
@endsection

@extends('master')

@section('title', 'Expertise Section Settings')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <!-- Page Header -->
        <div class="card mb-5">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h1 class="mb-0">Expertise Section Settings</h1>
                </div>
            </div>
        </div>

        <!-- Settings Card -->
        <div class="card">
            <div class="card-body">
                <form id="expertiseSectionForm" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <!-- Left Column -->
                        <div class="col-lg-8">
                            <!-- Section Title -->
                            <div class="mb-5">
                                <label for="title" class="form-label required">Section Title</label>
                                <input type="text"
                                       class="form-control"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $expertise->title ?? 'Our Expertise') }}"
                                       placeholder="Enter section title"
                                       required>
                            </div>

                            <!-- Expertise Items -->
                            <div class="mb-5">
                                <h4 class="mb-4">Expertise Items</h4>
                                
                                <!-- Item 1 -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Item 1</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="item_1_icon" class="form-label">Icon Class</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_1_icon"
                                                       name="item_1_icon"
                                                       value="{{ old('item_1_icon', $expertise->item_1_icon ?? '') }}"
                                                       placeholder="e.g., icofont-doctor-alt">
                                                <div class="form-text">Enter icon class name</div>
                                                <div id="icon1Preview" class="mt-2" style="display: none;">
                                                    <i id="previewIcon1" class="fs-2x text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="item_1_title" class="form-label">Title</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_1_title"
                                                       name="item_1_title"
                                                       value="{{ old('item_1_title', $expertise->item_1_title ?? '') }}"
                                                       placeholder="e.g., Certified Doctors">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="item_1_description" class="form-label">Description</label>
                                                <textarea class="form-control"
                                                          id="item_1_description"
                                                          name="item_1_description"
                                                          rows="2"
                                                          placeholder="Enter description">{{ old('item_1_description', $expertise->item_1_description ?? '') }}</textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="item_1_link" class="form-label">Link</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_1_link"
                                                       name="item_1_link"
                                                       value="{{ old('item_1_link', $expertise->item_1_link ?? '') }}"
                                                       placeholder="e.g., /doctors or route name">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 2 -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Item 2</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="item_2_icon" class="form-label">Icon Class</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_2_icon"
                                                       name="item_2_icon"
                                                       value="{{ old('item_2_icon', $expertise->item_2_icon ?? '') }}"
                                                       placeholder="e.g., icofont-stretcher">
                                                <div class="form-text">Enter icon class name</div>
                                                <div id="icon2Preview" class="mt-2" style="display: none;">
                                                    <i id="previewIcon2" class="fs-2x text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="item_2_title" class="form-label">Title</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_2_title"
                                                       name="item_2_title"
                                                       value="{{ old('item_2_title', $expertise->item_2_title ?? '') }}"
                                                       placeholder="e.g., Emergency">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="item_2_description" class="form-label">Description</label>
                                                <textarea class="form-control"
                                                          id="item_2_description"
                                                          name="item_2_description"
                                                          rows="2"
                                                          placeholder="Enter description">{{ old('item_2_description', $expertise->item_2_description ?? '') }}</textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="item_2_link" class="form-label">Link</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_2_link"
                                                       name="item_2_link"
                                                       value="{{ old('item_2_link', $expertise->item_2_link ?? '') }}"
                                                       placeholder="e.g., /emergency or route name">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 3 -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Item 3</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="item_3_icon" class="form-label">Icon Class</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_3_icon"
                                                       name="item_3_icon"
                                                       value="{{ old('item_3_icon', $expertise->item_3_icon ?? '') }}"
                                                       placeholder="e.g., icofont-network">
                                                <div class="form-text">Enter icon class name</div>
                                                <div id="icon3Preview" class="mt-2" style="display: none;">
                                                    <i id="previewIcon3" class="fs-2x text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="item_3_title" class="form-label">Title</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_3_title"
                                                       name="item_3_title"
                                                       value="{{ old('item_3_title', $expertise->item_3_title ?? '') }}"
                                                       placeholder="e.g., Technology">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="item_3_description" class="form-label">Description</label>
                                                <textarea class="form-control"
                                                          id="item_3_description"
                                                          name="item_3_description"
                                                          rows="2"
                                                          placeholder="Enter description">{{ old('item_3_description', $expertise->item_3_description ?? '') }}</textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="item_3_link" class="form-label">Link</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_3_link"
                                                       name="item_3_link"
                                                       value="{{ old('item_3_link', $expertise->item_3_link ?? '') }}"
                                                       placeholder="e.g., /technology or route name">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Item 4 -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Item 4</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="item_4_icon" class="form-label">Icon Class</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_4_icon"
                                                       name="item_4_icon"
                                                       value="{{ old('item_4_icon', $expertise->item_4_icon ?? '') }}"
                                                       placeholder="e.g., icofont-ambulance-cross">
                                                <div class="form-text">Enter icon class name</div>
                                                <div id="icon4Preview" class="mt-2" style="display: none;">
                                                    <i id="previewIcon4" class="fs-2x text-primary"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="item_4_title" class="form-label">Title</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_4_title"
                                                       name="item_4_title"
                                                       value="{{ old('item_4_title', $expertise->item_4_title ?? '') }}"
                                                       placeholder="e.g., Ambulance">
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="item_4_description" class="form-label">Description</label>
                                                <textarea class="form-control"
                                                          id="item_4_description"
                                                          name="item_4_description"
                                                          rows="2"
                                                          placeholder="Enter description">{{ old('item_4_description', $expertise->item_4_description ?? '') }}</textarea>
                                            </div>
                                            <div class="col-md-12 mb-3">
                                                <label for="item_4_link" class="form-label">Link</label>
                                                <input type="text"
                                                       class="form-control"
                                                       id="item_4_link"
                                                       name="item_4_link"
                                                       value="{{ old('item_4_link', $expertise->item_4_link ?? '') }}"
                                                       placeholder="e.g., /ambulance or route name">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="col-lg-4">
                            <!-- Image -->
                            <div class="mb-5">
                                <label for="image" class="form-label">Right Side Image</label>
                                <div class="image-input-wrapper">
                                    <input type="file"
                                           class="form-control"
                                           id="image"
                                           name="image"
                                           accept="image/*">
                                    <div class="form-text">Max size: 2MB</div>
                                </div>
                                
                                <!-- Current Image -->
                                @if(isset($expertise->image) && $expertise->image)
                                    <div class="mt-2">
                                        <label class="form-label">Current Image:</label>
                                        <img src="{{ asset('storage/' . $expertise->image) }}"
                                             alt="Expertise Image"
                                             class="img-fluid rounded"
                                             style="max-height: 200px;">
                                    </div>
                                @endif

                                <!-- New Preview -->
                                <div id="imagePreview" class="mt-2" style="display: none;">
                                    <label class="form-label">New Preview:</label>
                                    <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                </div>
                            </div>

                            <!-- Status -->
                            <div class="mb-5">
                                <label for="status" class="form-label required">Status</label>
                                <select class="form-select"
                                        id="status"
                                        name="status"
                                        required>
                                    <option value="Active" {{ (isset($expertise->status) && $expertise->status == 'Active') ? 'selected' : '' }}>Active</option>
                                    <option value="Inactive" {{ (isset($expertise->status) && $expertise->status == 'Inactive') ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <button type="submit" class="btn btn-primary">
                            <i class="icofont-save"></i> Save Expertise Section
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('page_script')
    <script nonce="{{ $cspNonce }}">
        $(document).ready(function() {
            // Image preview
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

            // Icon previews for all 4 items
            for (let i = 1; i <= 4; i++) {
                $('#item_' + i + '_icon').on('input', function() {
                    var iconClass = $(this).val();
                    if (iconClass) {
                        $('#previewIcon' + i).attr('class', iconClass + ' fs-2x text-primary');
                        $('#icon' + i + 'Preview').show();
                    } else {
                        $('#icon' + i + 'Preview').hide();
                    }
                });
            }

            // Form submission
            $('#expertiseSectionForm').on('submit', function(e) {
                e.preventDefault();
                
                var formData = new FormData(this);
                
                $.ajax({
                    url: '{{ route('admin.settings.expertise.update') }}',
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
    </script>
@endsection


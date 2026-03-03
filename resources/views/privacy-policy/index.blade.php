@extends('master')

@section('title', 'Privacy Policy Settings')

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
                    <h1 class="mb-0">Privacy Policy Settings</h1>
                </div>
            </div>
        </div>

        <!-- Settings Card -->
        <div class="card">
            <div class="card-body">
                <form id="privacyPolicyForm">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Privacy Policy Content with Summernote -->
                            <div class="mb-5">
                                <label for="privacy_policy" class="form-label required">Privacy Policy</label>
                                <textarea class="form-control"
                                          id="privacy_policy"
                                          name="privacy_policy"
                                          rows="15"
                                          placeholder="Write your privacy policy content here..."
                                          required>{{ old('privacy_policy', $privacyPolicy->privacy_policy ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-5">
                        <button type="submit" class="btn btn-primary">
                            <i class="icofont-save"></i> Save Privacy Policy
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
            $('#privacy_policy').summernote({
                height: 400,
                placeholder: 'Write here...',
                tabsize: 2,
                callbacks: {
                    onImageUpload: function(files) {
                        sendFile(files[0], $(this));
                    }
                }
            });

            // Form submission
            $('#privacyPolicyForm').on('submit', function(e) {
                e.preventDefault();

                var formData = new FormData(this);

                // Get summernote content
                var summernoteContent = $('#privacy_policy').summernote('code');
                formData.set('privacy_policy', summernoteContent);

                $.ajax({
                    url: '{{ route('admin.settings.privacy-policy.update') }}',
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
                    $('#privacy_policy').summernote('editor.insertImage', data.url);
                }
            });
        }
    </script>
@endsection

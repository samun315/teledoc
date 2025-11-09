@extends('master')

@section('title', 'Edit FAQ')

@section('content')
    <x-toolbar-component title="Edit FAQ" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'FAQ Management', 'url' => 'javascript:void(0)'],
        ['label' => 'FAQs', 'url' => route('faq.index')],
        ['label' => 'Edit FAQ', 'active' => true],
    ]" actionIcon="fas fa-arrow-left" actionLabel="Back to List" actionUrl="{{ route('faq.index') }}" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <form id="faqForm" action="{{ route('faq.update', $faq->faq_id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Question -->
                                <div class="mb-5">
                                    <label for="question" class="form-label required">Question</label>
                                    <input type="text"
                                           class="form-control @error('question') is-invalid @enderror"
                                           id="question"
                                           name="question"
                                           value="{{ old('question', $faq->question) }}"
                                           placeholder="Enter FAQ question"
                                           maxlength="500"
                                           required>
                                    @error('question')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maximum 500 characters</div>
                                </div>

                                <!-- Answer -->
                                <div class="mb-5">
                                    <label for="answer" class="form-label required">Answer</label>
                                    <textarea class="form-control @error('answer') is-invalid @enderror"
                                              id="answer"
                                              name="answer"
                                              rows="10"
                                              placeholder="Enter detailed answer to the question..."
                                              required>{{ old('answer', $faq->answer) }}</textarea>
                                    @error('answer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Provide a comprehensive answer to help users</div>
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
                                           value="{{ old('order', $faq->order) }}"
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
                                        <option value="Active" {{ old('status', $faq->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Inactive" {{ old('status', $faq->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('faq.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update FAQ
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
            // Character counter for question (optional)
            $('#question').on('input', function() {
                var length = $(this).val().length;
                var maxLength = 500;
                var remaining = maxLength - length;
                
                if (remaining < 50) {
                    $(this).next('.form-text').text(remaining + ' characters remaining');
                } else {
                    $(this).next('.form-text').text('Maximum 500 characters');
                }
            });
        });
    </script>
@endsection


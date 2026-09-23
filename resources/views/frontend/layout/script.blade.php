<!-- Essential JS -->
<script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.meanmenu.js') }}"></script>
<script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
@stack('extra_scripts')
<script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
@yield('page_script')

<!-- Feedback Form Script -->
<script nonce="{{ $cspNonce ?? '' }}">
    $(document).ready(function() {
        $('#feedbackForm').on('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();

            $('.error').text('');
            $('#feedbackMessage').html('').removeClass('alert alert-success alert-danger');

            const submitBtn = $('#feedbackSubmitBtn');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('Submitting...');

            const formData = {
                name: $('#feedback_name').val().trim(),
                phone: $('#feedback_phone').val().trim(),
                message: $('#feedback_message').val().trim(),
                _token: $('input[name="_token"]').val()
            };

            if (!formData.name || !formData.phone || !formData.message) {
                $('#feedbackMessage').html('<div class="alert alert-danger">Please fill in all fields.</div>');
                submitBtn.prop('disabled', false).html(originalText);
                return false;
            }

            $.ajax({
                url: '{{ route("feedback.store") }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#feedbackMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                        $('#feedbackForm')[0].reset();
                        setTimeout(function() {
                            $('html, body').animate({
                                scrollTop: $('#feedbackMessage').offset().top - 100
                            }, 500);
                        }, 100);
                    } else {
                        $('#feedbackMessage').html('<div class="alert alert-danger">' + (response.message || 'Something went wrong.') + '</div>');
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Something went wrong. Please try again.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            $('#error_' + key).text(value[0]);
                        });
                        errorMessage = 'Please correct the errors above.';
                    } else if (xhr.status === 0) {
                        errorMessage = 'Network error. Please check your connection.';
                    }

                    $('#feedbackMessage').html('<div class="alert alert-danger">' + errorMessage + '</div>');
                },
                complete: function() {
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });

            return false;
        });
    });
</script>

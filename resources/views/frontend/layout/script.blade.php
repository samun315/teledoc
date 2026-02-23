<!-- Essential JS -->
<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
<script src="{{ asset('frontend/assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/bootstrap.bundle.min.js') }}"></script>
<!-- Owl Carousel JS -->
<script src="{{ asset('frontend/assets/js/owl.carousel.min.js') }}"></script>
<!-- Meanmenu JS -->
<script src="{{ asset('frontend/assets/js/jquery.meanmenu.js') }}"></script>
<!-- Slider Slider JS -->
<script src="{{ asset('frontend/assets/js/slick.min.js') }}"></script>
<!-- Magnific Popup -->
<script src="{{ asset('frontend/assets/js/jquery.magnific-popup.min.js') }}"></script>
<!-- Wow JS -->
<script src="{{ asset('frontend/assets/js/wow.min.js') }}"></script>
<!-- Form Ajaxchimp JS -->
<script src="{{ asset('frontend/assets/js/jquery.ajaxchimp.min.js') }}"></script>
<!-- Form Validator JS -->
<script src="{{ asset('frontend/assets/js/form-validator.min.js') }}"></script>
<!-- Contact JS -->
<script src="{{ asset('frontend/assets/js/contact-form-script.js') }}"></script>
<!-- Odometer JS -->
<script src="{{ asset('frontend/assets/js/odometer.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/jquery.appear.min.js') }}"></script>
<!-- Custom JS -->
<script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
@yield('page_script')

<!-- Feedback Form Script -->
<script nonce="{{ $cspNonce ?? '' }}">
    $(document).ready(function() {
        $('#feedbackForm').on('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Clear previous errors and messages
            $('.error').text('');
            $('#feedbackMessage').html('').removeClass('alert alert-success alert-danger');
            
            // Disable submit button
            const submitBtn = $('#feedbackSubmitBtn');
            const originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('Submitting...');
            
            // Get form data
            const formData = {
                name: $('#feedback_name').val().trim(),
                phone: $('#feedback_phone').val().trim(),
                message: $('#feedback_message').val().trim(),
                _token: $('input[name="_token"]').val()
            };
            
            // Basic validation
            if (!formData.name || !formData.phone || !formData.message) {
                $('#feedbackMessage').html('<div class="alert alert-danger">Please fill in all fields.</div>');
                submitBtn.prop('disabled', false).html(originalText);
                return false;
            }
            
            // Submit via AJAX
            $.ajax({
                url: '{{ route("feedback.store") }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        // Show success message
                        $('#feedbackMessage').html('<div class="alert alert-success">' + response.message + '</div>');
                        
                        // Reset form
                        $('#feedbackForm')[0].reset();
                        
                        // Scroll to message
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
                        // Display validation errors
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
                    // Re-enable submit button
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
            
            return false;
        });
    });
</script>

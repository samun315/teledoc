@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-five">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Contact Us</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Contact us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Location -->
    <div class="location-area">
        <div class="container">
            <div class="row location-wrap">
                <div class="col-sm-6 col-lg-3">
                    <div class="location-item">
                        <i class="icofont-location-pin"></i>
                        <h3>Location</h3>
                        <p>
                            @if(!empty($settings['contact_address_1']))
                                {{ $settings['contact_address_1'] }}
                                @if(!empty($settings['contact_address_2']))
                                    <br>{{ $settings['contact_address_2'] }}
                                @endif
                                @if(!empty($settings['contact_city']))
                                    <br>{{ $settings['contact_city'] }}
                                    @if(!empty($settings['contact_state']))
                                        , {{ $settings['contact_state'] }}
                                    @endif
                                @endif
                                @if(!empty($settings['contact_postal_code']))
                                    <br>{{ $settings['contact_postal_code'] }}
                                @endif
                                @if(!empty($settings['contact_country']))
                                    <br>{{ $settings['contact_country'] }}
                                @endif
                            @else
                                210-27 Quadra, Market Street<br>Victoria, Canada
                            @endif
                        </p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="location-item">
                        <i class="icofont-ui-message"></i>
                        <h3>Email</h3>
                        <ul>
                            @if(!empty($settings['contact_email_1']))
                                <li>
                                    <a href="mailto:{{ $settings['contact_email_1'] }}">{{ $settings['contact_email_1'] }}</a>
                                </li>
                            @endif
                            @if(!empty($settings['contact_email_2']))
                                <li>
                                    <a href="mailto:{{ $settings['contact_email_2'] }}">{{ $settings['contact_email_2'] }}</a>
                                </li>
                            @endif
                            @if(empty($settings['contact_email_1']) && empty($settings['contact_email_2']))
                                <li>
                                    <a href="mailto:hello@example.com">hello@example.com</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="location-item">
                        <i class="icofont-ui-call"></i>
                        <h3>Phone</h3>
                        <ul>
                            @if(!empty($settings['contact_phone_1']))
                                <li>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['contact_phone_1']) }}">{{ $settings['contact_phone_1'] }}</a>
                                </li>
                            @endif
                            @if(!empty($settings['contact_phone_2']))
                                <li>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['contact_phone_2']) }}">{{ $settings['contact_phone_2'] }}</a>
                                </li>
                            @endif
                            @if(empty($settings['contact_phone_1']) && empty($settings['contact_phone_2']))
                                <li>
                                    <a href="tel:+0755543332322">+07 5554 3332 322</a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-3">
                    <div class="location-item">
                        <i class="icofont-whatsapp"></i>
                        <h3>WhatsApp</h3>
                        <ul>
                            @if(!empty($settings['contact_whatsapp']))
                                <li>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $settings['contact_whatsapp']) }}" target="_blank">{{ $settings['contact_whatsapp'] }}</a>
                                </li>
                            @else
                                <li>
                                    <span style="color: #999;">Not available</span>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Location -->

    <!-- Drop -->
    <section class="drop-area pt-100">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-7 p-0">
                    <div class="drop-item drop-img">
                        <div class="drop-left">
                            <h2>Drop your message for any info or question.</h2>
                            <form id="contactForm" method="POST" action="{{ route('feedback.store') }}">
                                @csrf
                                <div class="row justify-content-center">
                                    <div class="col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" class="form-control" required="" data-error="Please enter your name" placeholder="Name">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6">
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" class="form-control" data-error="Please enter a valid email" placeholder="Email">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="phone_number" id="phone_number" required="" data-error="Please enter your number" class="form-control" placeholder="Phone">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form-control" id="message" cols="30" rows="5" required="" data-error="Write your message" placeholder="Your Message"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <div class="form-check agree-label">
                                                <input name="gridCheck" value="I agree to the terms and privacy policy." class="form-check-input" type="checkbox" id="gridCheck" required="">

                                                <label class="form-check-label" for="gridCheck">
                                                    Accept <a href="terms-condition.html">Terms & Conditions</a> And <a href="privacy-policy.html">Privacy Policy.</a>
                                                </label>
                                                <div class="help-block with-errors gridCheck-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12">
                                        <button type="submit" class="drop-btn">
                                            Send
                                        </button>
                                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 p-0">
                    <div class="speciality-item speciality-right speciality-right-two speciality-right-three">
                        <img src="assets/img/home-two/4.jpg" alt="Contact">
                        <div class="speciality-emergency">
                            <div class="speciality-icon">
                                <i class="icofont-ui-call"></i>
                            </div>
                            <h3>Emergency Call</h3>
                            <p>
                                @if(!empty($settings['contact_phone_1']))
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', $settings['contact_phone_1']) }}" style="color: #ffffff; text-decoration: none;">
                                        {{ $settings['contact_phone_1'] }}
                                    </a>
                                @else
                                    <a href="tel:+07554332322" style="color: #ffffff; text-decoration: none;">+07 554 332 322</a>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Drop -->

    <!-- Map -->
    <iframe id="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59843174.53779285!2d62.17507173408571!3d23.728204508550363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3663f18a24cbe857%3A0xa9416bfcd3a0f459!2sAsia!5e0!3m2!1sen!2sbd!4v1609366033158!5m2!1sen!2sbd" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    <!-- End Map -->
@endsection

@section('page_script')
<script nonce="{{ $cspNonce ?? '' }}">
    $(document).ready(function() {
        // Wait a bit to ensure contact-form-script.js has loaded, then override it
        setTimeout(function() {
            // Remove all existing submit handlers from contact form
            $("#contactForm").off('submit.validator');
            $("#contactForm").off('submit');

            // Bind our custom handler
            $("#contactForm").on("submit", function (event) {
                event.preventDefault();
                event.stopPropagation();

                // Manual validation
                var isValid = true;
                var errors = [];
                var name = $("#name").val().trim();
                var email = $("#email").val().trim();
                var phone = $("#phone_number").val().trim();
                var message = $("#message").val().trim();
                var gridCheck = $("#gridCheck").is(':checked');

                // Clear previous errors
                $(".help-block.with-errors").text('');
                $(".gridCheck-error").text('');

                // Validate name
                if (!name) {
                    errors.push('Please enter your name');
                    isValid = false;
                }

                // Validate email (optional, but if provided must be valid)
                if (email) {
                    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                    if (!emailRegex.test(email)) {
                        errors.push('Please enter a valid email address');
                        isValid = false;
                    }
                }

                // Validate phone
                if (!phone) {
                    errors.push('Please enter your phone number');
                    isValid = false;
                }

                // Validate message
                if (!message) {
                    errors.push('Please write your message');
                    isValid = false;
                }

                // Validate checkbox
                if (!gridCheck) {
                    errors.push('You must accept the terms and conditions');
                    isValid = false;
                }

                if (!isValid) {
                    formError();
                    // Show all validation errors in SweetAlert
                    var errorMessage = errors.length > 0 ? errors.join('<br>') : 'Please fill in all required fields correctly.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        html: errorMessage,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33',
                        buttonsStyling: true
                    });
                    return false;
                }

                // If validation passes, submit the form
                submitContactForm();
                return false;
            });
        }, 500);

        function submitContactForm(){
            // Get form data
            var formData = {
                name: $("#name").val().trim(),
                email: $("#email").val().trim(),
                phone: $("#phone_number").val().trim(), // Map phone_number to phone
                message: $("#message").val().trim(),
                _token: $('input[name="_token"]').val()
            };

            // Disable submit button
            var submitBtn = $("#contactForm button[type='submit']");
            var originalText = submitBtn.html();
            submitBtn.prop('disabled', true).html('Sending...');

            // Clear previous messages
            $("#msgSubmit").removeClass().addClass('hidden').html('');

            $.ajax({
                type: "POST",
                url: '{{ route("feedback.store") }}',
                data: formData,
                dataType: 'json',
                success: function(response){
                    if (response.success){
                        $("#contactForm")[0].reset();

                        // Show success message in SweetAlert
                        Swal.fire({
                            icon: 'success',
                            title: 'Thank You!',
                            text: response.message || "Thank you for your feedback! We will get back to you soon.",
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#3085d6',
                            buttonsStyling: true
                        });
                    }
                    else {
                        formError();
                        // Show error in SweetAlert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message || "Something went wrong. Please try again.",
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#d33'
                        });
                    }
                },
                error: function(xhr){
                    formError();
                    var errorMessage = "Something went wrong. Please try again.";

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                        // Display validation errors
                        var errors = xhr.responseJSON.errors;
                        var errorMessages = [];
                        $.each(errors, function(key, value) {
                            if (Array.isArray(value)) {
                                errorMessages.push(value[0]);
                            } else {
                                errorMessages.push(value);
                            }
                        });
                        errorMessage = errorMessages.join('<br>');
                    } else if (xhr.status === 422) {
                        errorMessage = "Validation failed. Please check your inputs.";
                    } else if (xhr.status === 500) {
                        errorMessage = "Server error. Please try again later.";
                    }

                    // Show error in SweetAlert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        html: errorMessage,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#d33'
                    });
                },
                complete: function(){
                    // Re-enable submit button
                    submitBtn.prop('disabled', false).html(originalText);
                }
            });
        }

        function formError(){
            $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
                $(this).removeClass();
            });
        }

        function submitMSG(valid, msg){
            if(valid){
                var msgClasses = "h4 tada animated text-success";
            }
            else {
                var msgClasses = "h4 text-danger";
            }
            $("#msgSubmit").removeClass().addClass(msgClasses).html(msg).removeClass('hidden');
        }
    });
</script>
@endsection

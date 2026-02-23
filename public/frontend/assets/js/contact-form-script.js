/*==============================================================*/
// Contact Form JS
/*==============================================================*/
(function ($) {
    "use strict"; // Start of use strict
    $("#contactForm").validator().on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            formError();
            submitMSG(false, "Did you fill in the form properly?");
        }
        else {
            event.preventDefault();
            submitForm();
        }
    });

    function submitForm(){
        // Get form data
        var formData = {
            name: $("#name").val(),
            email: $("#email").val(),
            phone: $("#phone_number").val(), // Map phone_number to phone
            message: $("#message").val(),
            _token: $('input[name="_token"]').val()
        };

        // Disable submit button
        var submitBtn = $("#contactForm button[type='submit']");
        var originalText = submitBtn.html();
        submitBtn.prop('disabled', true).html('Sending...');

        $.ajax({
            type: "POST",
            url: $("#contactForm").attr('action'),
            data: formData,
            dataType: 'json',
            success: function(response){
                if (response.success){
                    formSuccess();
                    submitMSG(true, response.message || "Message Submitted!");
                }
                else {
                    formError();
                    submitMSG(false, response.message || "Something went wrong. Please try again.");
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
                        errorMessages.push(value[0]);
                    });
                    errorMessage = errorMessages.join('<br>');
                }

                submitMSG(false, errorMessage);
            },
            complete: function(){
                // Re-enable submit button
                submitBtn.prop('disabled', false).html(originalText);
            }
        });
    }

    function formSuccess(){
        $("#contactForm")[0].reset();
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

}(jQuery)); // End of use strict

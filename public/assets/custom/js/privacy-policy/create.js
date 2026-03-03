// Form elements
let privacyPolicyForm = $("#privacyPolicyForm");
let privacyPolicyInput = $("#privacy_policy");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/privacy-policy";

// Form validation
let validate = privacyPolicyForm.validate({
    rules: {
        privacy_policy: "required",
    },
    messages: {
        privacy_policy: "Please enter privacy policy content",
    },
    onsubmit: true,
});

$(document).ready(function() {
    $('#privacy_policy').summernote({
        placeholder: 'Write here...',
        tabsize: 2,
        height: 400,
        callbacks: {
            onImageUpload: function (image) {
                sendFile(image[0]);
            },
            onMediaDelete: function (target) {
                removeFile(target[0].src)
            },
        }
    });

    function removeFile(file, editor, welEditable) {
        // Handle file removal if needed
    }
});

// Form submission
privacyPolicyForm.submit(function (e) {
    e.preventDefault();

    if (!validate.valid()) return;

    loader(privacyPolicyForm, true);

    // Setup CSRF token
    setCSRFToken();

    $(".error").remove();

    const formData = new FormData(this);

    // Get summernote content
    const summernoteContent = $('#privacy_policy').summernote('code');
    formData.set('privacy_policy', summernoteContent);

    // Determine if it's create or update
    const isUpdate = privacyPolicyForm.attr('action').includes('/update/');
    const url = isUpdate ? privacyPolicyForm.attr('action') : `${BASE_URL}/store`;
    const method = isUpdate ? 'PUT' : 'POST';

    $.ajax({
        type: method,
        url: url,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            loader(privacyPolicyForm, false);
            if (response.success) {
                toastr.success(isUpdate ? 'Privacy policy updated successfully' : 'Privacy policy created successfully');
                window.location.href = BASE_URL;
            } else {
                toastr.error(response.message || 'Failed to save privacy policy');
            }
        },
        error: function(xhr) {
            loader(privacyPolicyForm, false);
            if (xhr.status === 422) {
                displayValidationErrors(xhr.responseJSON?.errors);
            } else {
                toastr.error(xhr.responseJSON?.message || 'An unexpected error occurred');
            }
        }
    });
});

// Form reset functionality
$(".formReset").on("click", function () {
    formReset();
});

function formReset() {
    privacyPolicyForm.trigger("reset");
    $('#privacy_policy').summernote('code', '');
}

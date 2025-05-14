function loader(target, type = true) {
    if (type) {
        target.waitMe({
            effect: 'bounce',
            text: 'Please waiting...',
            bg: 'rgba(52,52,52,0.7)',
            color: '#000'
        });
    } else {
        target.waitMe("hide");
    }
}

function formReset(formId) {
    $('#submitForm').trigger("reset");
}

// Function to get CSRF token from meta tag
function setCSRFToken() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
}

function handleSuccessWithModal(response) {
    loader(selectedForm, false);

    if (response?.statusCode === 201 || response?.statusCode === 200) {
        toastr.success(response?.message);
        table.ajax.reload();
        $('#showModal').modal('hide');
        formReset();
    } else {
        toastr.success(response?.message);
    }
}

function handleError(response) {
    if (response?.status === 422) {
        displayValidationErrors(response?.responseJSON?.errors);
    } else {
        toastr.error(response?.responseJSON?.message);
    }

    loader(selectedForm, false);
}

function displayValidationErrors(errors) {
    $.each(errors, function (field_name, error) {
        $(document).find(`[name=${field_name}]`).after(`<span class="text-danger error">${error}</span>`);
    });
}

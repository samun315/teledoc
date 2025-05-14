// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

// Get the current URL of the window
const BASE_URL = window.location.href;

let search = $("#search");

let validate = selectedForm.validate({
    rules: {
        name: "required",
    },
    onsubmit: true,
});

// fetch the data
let table = $("#data-table").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL,
        data: function (d) {
            d.search = search.val();
        },
    },
    columns: [
        {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            orderable: false,
            searchable: false,
        },
        {
            data: "module_item.item_name",
            name: "module_item.item_name",
        },
        {
            data: "name",
            name: "name",
        },
        {
            data: "slug",
            name: "slug",
        },
        {
            data: "action",
            name: "action",
        },
    ],
});

search.keyup(function () {
    table.draw();
});

$("#openModal").on("click",function(){
    openModal();
});

// Example usage for menu_permission modal
function openModal() {
    formReset();

    $("#menu_permission_id").val(null);
    $('#item_id').val(null).trigger('change');
    loader(selectedForm, false);

    $("#modalTitle").html("Add Menu Permission");
    $("#showModal").modal("show");
}

selectedForm.submit(function (e) {
    e.preventDefault();

    if (!validate.valid()) return;

    loader(selectedForm, true);

    // Setup CSRF token
    setCSRFToken();

    $(".error").remove();

    const formData = new FormData(this);

    const permissionId = $("#menu_permission_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (permissionId) {
        URL = `${BASE_URL}/update/${permissionId}`;
        formData.append("_method", "PUT");
    }

    $.ajax({
        type: "POST", // Always use POST for FormData, append _method for PUT
        url: URL,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: handleSuccessWithModal,
        error: handleError,
    });
});

$(document).on("click", ".editPermissionButton", function () {
    var id = $(this).attr("data-id");
    editPermission(id);
});

//Edit data
function editPermission(id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${id}`,
        dataType: "json",
        success: (response) => {
            console.log(response)
            loader(selectedForm, false);

            if (response?.success && response?.statusCode === 200) {
                const { permission } = response;

                $("#menu_permission_id").val(permission?.menu_permission_id);
                $("#item_id").val(permission?.item_id).trigger("change");
                $("#name").val(permission?.name);
                $("#slug").val(permission?.slug);
                $("#active").val(permission?.active).trigger("change");

                $("#modalTitle").html("Edit Menu Permission");
                $("#showModal").modal("show");
            } else {
                toastr.error(
                    response?.message || "An unexpected error occurred."
                );
            }
        },
        error: (jqXHR) => {
            loader(selectedForm, false);

            if (jqXHR.status === 422) {
                displayValidationErrors(jqXHR.responseJSON?.errors);
            } else {
                toastr.error(
                    jqXHR.responseJSON?.message ||
                        "An unexpected error occurred."
                );
            }
        },
    });
}



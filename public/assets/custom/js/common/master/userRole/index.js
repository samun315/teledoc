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
            data: "role_name",
            name: "role_name",
        },
        {
            data: "active",
            name: "active",
            render: function (data, type, full, meta) {
                const checked = data === "YES" ? "checked" : "";
                const toggleStatus = data === "YES" ? "NO" : "YES";
                const checkbox =
                    '<input class="form-check-input activeStatus" data-id=' +
                    full.role_id +
                    ' name="status" type="checkbox" value="' +
                    data +
                    '" ' +
                    checked +
                    "/>" +
                    '<input type="hidden" id="toggleData_' +
                    full.role_id +
                    '" value="' +
                    toggleStatus +
                    '"';
                const label =
                    '<span class="form-check-label fw-bold text-muted">' +
                    data +
                    "</span>";
                return (
                    '<label class="form-check form-switch form-check-custom form-check-solid">' +
                    checkbox +
                    label +
                    "</label>"
                );
            },
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

$("#openModal").on("click", function () {
    openModal();
});


// Example usage for role modal
function openModal() {
    formReset();

    $("#role_id").val(null);
    $('#active').val('YES').trigger('change');
    loader(selectedForm, false);

    $("#modalTitle").html("Add User Role");
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

    const userRoleId = $("#role_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (userRoleId) {
        URL = `${BASE_URL}/update/${userRoleId}`;
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

$(document).on("click", ".editUserRoleButton", function () {
    var id = $(this).attr("data-id");
    editUserRole(id);
});

//Edit data
function editUserRole(id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${id}`,
        dataType: "json",
        success: (response) => {
            loader(selectedForm, false);

            if (response?.success && response?.statusCode === 200) {
                const { userRole } = response;

                $("#role_name").val(userRole?.role_name);
                $("#role_id").val(userRole?.role_id);
                $("#active").val(userRole?.active).trigger("change");

                $("#modalTitle").html("Edit User Role");
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

$(document).on("change", ".activeStatus", function () {
    var roleId = $(this).attr("data-id");
    var active = $("#toggleData_" + roleId).val();
    updateActiveStatus(active, roleId);
});

function updateActiveStatus(active, role_id) {
    console.log(role_id);
    $.ajax({
        type: "PUT",
        url: BASE_URL + "/update-status",
        data: {
            role_id: role_id,
            active: active,
            _token: setCSRFToken(),
        },
        dataType: "json",
        success: function (response) {
            if (response?.statusCode === 200) {
                toastr.success(response?.message, "Success!");
                table.ajax.reload();
            } else {
                toastr.error(
                    response?.message || "An unexpected error occurred."
                );
            }
        },
    });
}

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
            data: "user_role.role_name",
            name: "user_role.role_name",
        },
        {
            data: "permission.name",
            name: "permission.name",
        },
        // {
        //     data: "active",
        //     name: "active",
        //     render: function (data, type, full, meta) {
        //         const checked = data === "YES" ? "checked" : "";
        //         const toggleStatus = data === "YES" ? "NO" : "YES";
        //         const checkbox =
        //             '<input class="form-check-input" onchange="updateActiveStatus(\'' +
        //             toggleStatus +
        //             "', " +
        //             full.menu_permission_id +
        //             ')" name="status" type="checkbox" value="' +
        //             data +
        //             '" ' +
        //             checked +
        //             "/>";
        //         const label =
        //             '<span class="form-check-label fw-bold text-muted">' +
        //             data +
        //             "</span>";
        //         return (
        //             '<label class="form-check form-switch form-check-custom form-check-solid">' +
        //             checkbox +
        //             label +
        //             "</label>"
        //         );
        //     },
        // },
        {
            data: "action",
            name: "action",
        },
    ],
});

search.keyup(function () {
    table.draw();
});

// Example usage for menu_permission modal
function openModal() {
    formReset();

    $("#menu_role_permission_id").val(null);
    loader(selectedForm, false);

    $("#modalTitle").html("Add Menu Role Permission");
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

    const rolePermissionId = $("#menu_role_permission_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (rolePermissionId) {
        URL = `${BASE_URL}/update/${rolePermissionId}`;
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

//Edit data
function editRolePermission(id) {
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
                const { rolePermission } = response;

                $("#menu_role_permission_id").val(rolePermission?.menu_role_permission_id);
                $("#role_id").val(rolePermission?.role_id).trigger("change");
                $("#menu_permission_id").val(rolePermission?.menu_permission_id).trigger("change");;
                $("#active").val(rolePermission?.active).trigger("change");

                $("#modalTitle").html("Edit Menu Role Permission");
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

// function updateActiveStatus(active, menu_permission_id) {
//     console.log(menu_permission_id);
//     $.ajax({
//         type: "PUT",
//         url: BASE_URL + "/update-status",
//         data: {
//             menu_permission_id: menu_permission_id,
//             active: active,
//             _token: setCSRFToken(),
//         },
//         dataType: "json",
//         success: function (response) {
//             if (response?.statusCode === 200) {
//                 toastr.success(response?.message, "Success!");
//                 table.ajax.reload();
//             } else {
//                 toastr.error(
//                     response?.message || "An unexpected error occurred."
//                 );
//             }
//         },
//     });
// }

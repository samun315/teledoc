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
            data: 'module.module_name',
            name: 'module.module_name',
            orderable: false,
        },
        {
            data: "item_name",
            name: "item_name",
        },
        {
            data: "active",
            name: "active",
            render: function (data, type, full, meta) {
                const checked = data === "YES" ? "checked" : "";
                const toggleStatus = data === "YES" ? "NO" : "YES";
                const checkbox =
                   '<input class="form-check-input activeStatus" data-id=' +
                    full.item_id +
                    ' name="status" type="checkbox" value="' +
                    data +
                    '" ' +
                    checked +
                    "/>" +
                    '<input type="hidden" id="toggleData_' +
                    full.item_id +
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

// Example usage for item modal
function openModal() {
    formReset();

    $("#item_id").val(null);
    $('#module_id').val(null).trigger('change');
    $('#active').val('YES').trigger('change');
    loader(selectedForm, false);

    $("#modalTitle").html("Add Module Item");
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

    const moduleItemId = $("#item_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (moduleItemId) {
        URL = `${BASE_URL}/update/${moduleItemId}`;
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

$(document).on("click", ".editModuleItemButton", function () {
    var id = $(this).attr("data-id");
    editModuleItem(id);
});

//Edit data
function editModuleItem(id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${id}`,
        dataType: "json",
        success: (response) => {
            loader(selectedForm, false);

            if (response?.success && response?.statusCode === 200) {
                const { moduleItem } = response;

                $("#item_name").val(moduleItem?.item_name);
                $("#item_id").val(moduleItem?.item_id);
                $("#module_id").val(moduleItem?.module_id).trigger("change");
                $("#active").val(moduleItem?.active).trigger("change");

                $("#modalTitle").html("Edit Module Item");
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
    var itemId = $(this).attr("data-id");
    var active = $("#toggleData_" + itemId).val();
    updateActiveStatus(active, itemId);
});

function updateActiveStatus(active, item_id) {
    console.log(item_id);
    $.ajax({
        type: "PUT",
        url: BASE_URL + "/update-status",
        data: {
            item_id: item_id,
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

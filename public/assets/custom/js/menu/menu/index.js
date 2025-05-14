// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

let search = $("#search");

// Get the current URL of the window
const BASE_URL = window.location.href;

let validate = selectedForm.validate({
    rules: {
        name: "required",
    },
    onsubmit: true,
});

$(".formReset").on("click", function () {
    formReset();
});

function formReset() {
    $("#submitForm").trigger("reset");
    $("select[name='active']").val("YES").change();
}

$("#openMenuModal").on("click", function () {
    openMenuModal();
});

function openMenuModal() {
    formReset();

    $("#kt_menu_id").val(null);
    loader(selectedForm, false);

    $("#modalTitle").html("Add Menu");
    $(".btnSubmit").html("Save");
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

    const menuId = $("#kt_menu_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (menuId) {
        URL = `${BASE_URL}/update/${menuId}`;
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

// fetch the data
let table = $("#kt_menu_table").DataTable({
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
            data: "menu_name",
            name: "menu_name",
        },
        {
            data: "description",
            name: "description",
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

//  GET EDIT EDUCATION INFO DATA
$(document).on("click", ".editMenuBtn", function () {
    var menu_id = $(this).attr("data-id");
    getEditMenuInfo(menu_id);
});

function getEditMenuInfo(menu_id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${menu_id}`,
        dataType: "json",
        success: (response) => {
            loader(selectedForm, false);
            
            if (response?.success && response?.statusCode === 200) {
                const { menuInfo } = response;
                
                $("#kt_menu_id").val(menuInfo?.menu_id);
                $("#kt_name").val(menuInfo?.menu_name);
                $("#kt_description").val(menuInfo?.description);
                $("#active").val(menuInfo?.active).trigger("change");

                $("#modalTitle").html("Edit Menu");
                $(".btnSubmit").html("Update");
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

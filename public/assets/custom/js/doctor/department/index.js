// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

let search = $("#search");
let department_id = $("#department_id");
// Get the current URL of the window
const BASE_URL = window.location.origin + "/doctor/department";

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
    $("#kt_status").val("Active").trigger("change");
}

$("#openDepartmentModal").on("click", function () {
    openDepartmentModal();
});

function openDepartmentModal() {
    formReset();

    $("#kt_department_id").val(null);
    loader(selectedForm, false);

    $("#modalTitle").html("Add Department");
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

    const departmentId = $("#kt_department_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (departmentId) {
        URL = `${BASE_URL}/update/${departmentId}`;
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
let table = $("#kt_department_table").DataTable({
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
            data: "department_name",
            name: "department_name",
        },
        {
            data: "description",
            name: "description",
        },
        {
            data: "status",
            render: function (data) {
                if (!data) return "";

                let status = "";

                if (data == "Active") {
                    status = "badge badge-success";
                } else {
                    status = "badge badge-danger";
                }

                return `<p class="${status}">${data}</p>`;
            },
        },
        {
            data: "action",
            name: "action",
        },
    ],
    columnDefs: [
        {
            targets: "_all",
            defaultContent: "",
        },
    ],
});

search.keyup(function () {
    table.draw();
});

//  GET EDIT EDUCATION INFO DATA
$(document).on("click", ".editDepartmentBtn", function () {
    let department_id = $(this).attr("data-id");
    getDepartmentInfo(department_id);
});

function getDepartmentInfo(department_id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${department_id}`,
        dataType: "json",
        success: (response) => {
            loader(selectedForm, false);

            if (response?.success && response?.statusCode === 200) {
                const { departmentInfo } = response;

                $("#kt_department_id").val(departmentInfo?.department_id);
                $("#kt_department_name").val(departmentInfo?.department_name);
                $("#kt_description").val(departmentInfo?.description);

                $("#kt_status").val(departmentInfo?.status).trigger("change");

                $("#modalTitle").html("Edit Department");
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

// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

let search = $("#search");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/drug";

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
    $(".status").val("Active").trigger("change");
}

$("#openDrugModal").on("click", function () {
    openDrugModal();
});

function openDrugModal() {
    formReset();

    $("#kt_drug_id").val(null);
    loader(selectedForm, false);

    $("#modalTitle").html("Add Drug");
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

    const drugId = $("#kt_drug_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (drugId) {
        URL = `${BASE_URL}/update/${drugId}`;
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
let table = $("#kt_drug_table").DataTable({
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
            data: "trade_name",
            name: "trade_name",
        },
        {
            data: "generic_name",
            name: "generic_name",
        },
        {
            data: "side_effect",
            name: "side_effect",
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
$(document).on("click", ".editDrugBtn,.viewDrugBtn", function () {
    let drug_id = $(this).attr("data-id");
    getDrugInfo(drug_id);
});

function getDrugInfo(drug_id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${drug_id}`,
        dataType: "json",
        success: (response) => {
            loader(selectedForm, false);

            if (response?.success && response?.statusCode === 200) {
                const { drugInfo } = response;

                $("#kt_drug_id").val(drugInfo?.drug_id);
                $(".trade_name").val(drugInfo?.trade_name);
                $(".generic_name").val(drugInfo?.generic_name);
                $(".note").val(drugInfo?.note);
                $(".warning").val(drugInfo?.warning);
                $(".side_effect").val(drugInfo?.side_effect);
                $(".additional_advice").val(drugInfo?.additional_advice);
                $(".status").val(drugInfo?.status).trigger("change");

                $("#modalTitle").html("Edit Drug");
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

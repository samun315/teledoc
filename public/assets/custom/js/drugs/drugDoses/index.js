// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

let search = $("#search");
let drug_type = $("#drug_type_id");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/drug/drug-doses";

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
    $("#kt_drug_type_id").val("").trigger("change");
}

$("#openDrugDosesModal").on("click", function () {
    openDrugDosesModal();
});

function openDrugDosesModal() {
    formReset();

    $("#kt_drug_dose_id").val(null);
    loader(selectedForm, false);

    $("#modalTitle").html("Add Drug Frequency");
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

    const drugDoseId = $("#kt_drug_dose_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (drugDoseId) {
        URL = `${BASE_URL}/update/${drugDoseId}`;
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
let table = $("#kt_drug_doses_table").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL,
        data: function (d) {
            d.search = search.val();
            d.drug_type = drug_type.val();
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
            data: "drug_dose",
            name: "drug_dose",
        },
        {
            data: "drug_type",
            name: "drug_type",
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

drug_type.change(function () {
    table.draw();
});

//  GET EDIT EDUCATION INFO DATA
$(document).on("click", ".editDrugDoseBtn", function () {
    let drug_dose_id = $(this).attr("data-id");
    getDrugDoseInfo(drug_dose_id);
});

function getDrugDoseInfo(drug_dose_id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${drug_dose_id}`,
        dataType: "json",
        success: (response) => {
            loader(selectedForm, false);

            if (response?.success && response?.statusCode === 200) {
                const { drugDoseInfo } = response;

                $("#kt_drug_dose_id").val(drugDoseInfo?.drug_dose_id);
                $("#kt_drug_dose").val(drugDoseInfo?.drug_dose);
                $("#kt_status").val(drugDoseInfo?.status).trigger("change");
                $("#kt_drug_type_id")
                    .val(drugDoseInfo?.drug_type_id)
                    .trigger("change");

                $("#modalTitle").html("Edit Drug Dose");
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

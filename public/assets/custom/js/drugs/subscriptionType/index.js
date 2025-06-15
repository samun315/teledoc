// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

let search = $("#search");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/drug/subscription-type";

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

$("#openSubscriptionTypeModal").on("click", function () {
    openSubscriptionTypeModal();
});

function openSubscriptionTypeModal() {
    formReset();

    $("#kt_subscription_type_id").val(null);
    loader(selectedForm, false);

    $("#modalTitle").html("Add Subscription Type");
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

    const subscriptionTypeId = $("#kt_subscription_type_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (subscriptionTypeId) {
        URL = `${BASE_URL}/update/${subscriptionTypeId}`;
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
let table = $("#kt_subscription_type_table").DataTable({
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
            data: "subscription_type",
            name: "subscription_type",
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
$(document).on("click", ".editSubscriptionTypeBtn", function () {
    let subscription_type_id = $(this).attr("data-id");
    getSubscriptionTypeInfo(subscription_type_id);
});

function getSubscriptionTypeInfo(subscription_type_id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${subscription_type_id}`,
        dataType: "json",
        success: (response) => {
            loader(selectedForm, false);

            if (response?.success && response?.statusCode === 200) {
                const { subscriptionTypeInfo } = response;

                $("#kt_subscription_type_id").val(
                    subscriptionTypeInfo?.subscription_type_id
                );
                $("#kt_subscription_type").val(
                    subscriptionTypeInfo?.subscription_type
                );
                $("#kt_status")
                    .val(subscriptionTypeInfo?.status)
                    .trigger("change");

                $("#modalTitle").html("Edit Subscription Type");
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

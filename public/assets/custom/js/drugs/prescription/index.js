// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

let search = $("#search");
let subscription_type = $("#subscription_type_id");
// Get the current URL of the window
const BASE_URL = window.location.origin + "/drug/prescription";

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
    $("#kt_subscription_type_id").val("").trigger("change");
    $("#kt_status").val("Active").trigger("change");
}

selectedForm.submit(function (e) {
    e.preventDefault();

    if (!validate.valid()) return;

    loader(selectedForm, true);

    // Setup CSRF token
    setCSRFToken();

    $(".error").remove();

    const formData = new FormData(this);

    const subscriptionId = $("#kt_subscription_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (subscriptionId) {
        URL = `${BASE_URL}/update/${subscriptionId}`;
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

const formatDate = (data) => {
    if (!data) return "";

    const date = new Date(data);
    // Month and day as textual representations
    let monthNames = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];

    let month = monthNames[date.getMonth()];
    let day = date.getDate().toString().padStart(2, "0");
    let hour = date.getHours().toString().padStart(2, "0");

    let amPm = hour >= 12 ? "PM" : "AM";
    hour = hour % 12 || 12; // Convert 0 to 12 for 12 AM

    let minute = date.getMinutes().toString().padStart(2, "0");
    let second = date.getSeconds().toString().padStart(2, "0");

    return `${day} ${month}, ${date.getFullYear()} ,${hour}:${minute} ${amPm}`;
};

// fetch the data
let table = $("#kt_prescription_table").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL,
        data: function (d) {
            d.search = search.val();
            d.subscription_type = subscription_type.val();
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
            data: "created_at",
            render: formatDate,
        },
        {
            data: "prescription_number",
            name: "prescription_number",
        },
        {
            data: "patient_name",
            name: "patient_name",
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

subscription_type.change(function () {
    table.draw();
});

//  GET EDIT EDUCATION INFO DATA
$(document).on("click", ".editSubscriptionBtn", function () {
    let subscription_id = $(this).attr("data-id");
    getSubscriptionInfo(subscription_id);
});

function getSubscriptionInfo(subscription_id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${subscription_id}`,
        dataType: "json",
        success: (response) => {
            loader(selectedForm, false);

            if (response?.success && response?.statusCode === 200) {
                const { subscriptionInfo } = response;

                $("#kt_subscription_id").val(subscriptionInfo?.subscription_id);
                $("#kt_subscription_name").val(
                    subscriptionInfo?.subscription_name
                );

                $("#kt_subscription_type_id")
                    .val(subscriptionInfo?.subscription_type_id)
                    .trigger("change");

                $("#kt_status").val(subscriptionInfo?.status).trigger("change");

                $("#modalTitle").html("Edit Subscription");
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

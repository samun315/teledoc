let selectedForm = $("#submitForm");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/marchant";

let search = $("#search");

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
    $("#kt_transfer_to_user").val("").trigger("change");
}

$("#openTransferBalanceModal").on("click", function () {
    openModal();
});

function openModal() {
    formReset();
    loader(selectedForm, false);
    $("#kt_transfer_balance_id").val(null);
    $("#showModal").modal("show");
}

selectedForm.submit(function (event) {
    event.preventDefault();

    if (!validate.valid()) return;

    loader(selectedForm, true);

    let formData = new FormData($("form#submitForm")[0]);

    // Setup CSRF token
    setCSRFToken();

    $(".error").remove();

    let transferId = $("#kt_transfer_balance_id").val();
    let url = "";
    if (transferId) {
        url = BASE_URL + "/transfer/balance/update/" + transferId;
        formData.append("_method", "PUT");
    } else {
        url = BASE_URL + "/transfer/balance/store";
    }

    $.ajax({
        url: url,
        data: formData,
        type: "POST", // Always use POST for FormData, append _method for PUT
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

let table = $("#kt_table_transfer_balance").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL + "/transfer/balance",
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
            data: "from_user",
            name: "from_user",
        },
        {
            data: "to_user",
            name: "to_user",
        },
        {
            data: "amount",
            name: "amount",
        },
        {
            data: "status",
            render: function (data) {
                if (!data) return "";

                let status = "";

                if (data == "Pending") {
                    status = "badge badge-warning";
                } else if (data == "Transferred") {
                    status = "badge badge-success";
                } else {
                    status = "badge badge-danger";
                }

                return `<p class="${status} ">${data}</p>`;
            },
        },
        {
            data: "created_at",
            render: formatDate,
        },
    ],
    columnDefs: [
        {
            targets: "_all",
            defaultContent: "",
        },
    ],
    paging: true, // Enables pagination
    pageLength: 10, // Show 5 records per page
    lengthMenu: [10, 25, 50, 75, 100, 200], // Dropdown for selecting number of rows
    dom:
        '<"row"<"col-sm-2"l><"col-sm-10 d-flex justify-content-end"B>>' + // Length menu & buttons
        '<"row"<"col-sm-12"tr>>' + // Table rows
        '<"row mt-2"<"col-sm-6"i><"col-sm-6 d-flex justify-content-end"p>>', // Pagination & info
    buttons: [
        {
            extend: "excelHtml5",
            text: "Excel",
            className: "btn btn-success btn-sm",
            attr: {
                style: "margin-top: 25px;padding: 0 10px; font-size: 12px; line-height: 1; height: 30px;",
            },
            exportOptions: {
                columns: ":not(:first-child)", // Exclude the first column (DT_RowIndex)
            },
        },
        {
            extend: "pdfHtml5",
            text: "PDF",
            className: "btn btn-danger btn-sm",
            attr: {
                style: "margin-top: 25px;padding: 0 10px; font-size: 12px; line-height: 1; height: 30px;",
            },
            exportOptions: {
                columns: ":not(:first-child)", // Exclude the first column (DT_RowIndex)
            },
        },
    ],
});

search.keyup(function () {
    table.draw();
});

// APPROVE BALANCE REQUEST START

let serchId = $("#search");

let approveTable = $("#kt_table_approve_transfer_balance").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL + "/all/transfer/balance",
        data: function (d) {
            d.search = serchId.val();
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
            data: "from_user",
            name: "from_user",
        },
        {
            data: "to_user",
            name: "to_user",
        },
        {
            data: "amount",
            name: "amount",
        },
        {
            data: "status",
            render: function (data) {
                if (!data) return "";

                let status = "";

                if (data == "Pending") {
                    status = "badge badge-warning";
                } else if (data == "Transferred") {
                    status = "badge badge-success";
                } else {
                    status = "badge badge-danger";
                }

                return `<p class="${status} ">${data}</p>`;
            },
        },
        {
            data: "created_at",
            render: formatDate,
        },
    ],
    columnDefs: [
        {
            targets: "_all",
            defaultContent: "",
        },
    ],
    paging: true, // Enables pagination
    pageLength: 10, // Show 5 records per page
    lengthMenu: [10, 25, 50, 75, 100, 200], // Dropdown for selecting number of rows
    dom:
        '<"row"<"col-sm-2"l><"col-sm-10 d-flex justify-content-end"B>>' + // Length menu & buttons
        '<"row"<"col-sm-12"tr>>' + // Table rows
        '<"row mt-2"<"col-sm-6"i><"col-sm-6 d-flex justify-content-end"p>>', // Pagination & info
    buttons: [
        {
            extend: "excelHtml5",
            text: "Excel",
            className: "btn btn-success btn-sm",
            attr: {
                style: "margin-top: 25px;padding: 0 10px; font-size: 12px; line-height: 1; height: 30px;",
            },
            exportOptions: {
                columns: ":not(:first-child):not(:last-child)", // Exclude the first column (DT_RowIndex)
            },
        },
        {
            extend: "pdfHtml5",
            text: "PDF",
            className: "btn btn-danger btn-sm",
            attr: {
                style: "margin-top: 25px;padding: 0 10px; font-size: 12px; line-height: 1; height: 30px;",
            },
            exportOptions: {
                columns: ":not(:first-child):not(:last-child)", // Exclude the first column (DT_RowIndex)
            },
        },
    ],
});

serchId.keyup(function () {
    approveTable.draw();
});

$(document).on("click", ".transferredBtn,.cancelledBtn", function () {
    let id = $(this).attr("data-id");
    let status = $(this).attr("data-status");
    updateTransferBalanceStatus(status, id);
});

function updateTransferBalanceStatus(status, id) {
    Swal.fire({
        html: `Are you want to ${status} this?`,
        icon: "info",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Yes, do it!",
        cancelButtonText: "Nope, cancel it",
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-danger",
        },
    }).then(
        function (e) {
            if (e.value === true) {
                setCSRFToken();
                $.ajax({
                    type: "PUT",
                    url: BASE_URL + "/all/transfer/balance/update-status/" + id,
                    data: {status},
                    dataType: "JSON",
                    success: function (response) {
                        if (response?.statusCode === 200) {
                            toastr.success(response?.message, "Success!");
                            approveTable.draw();
                        } 
                    },
                    error: function (data) {
                        toastr.error(
                            data?.message || "An unexpected error occurred."
                        );
                    },
                });
            } else {
                e.dismiss;
            }
        },
        function (dismiss) {
            return false;
        }
    );
}

$("#kt_amount").on("keyup",function(){
    let currentBalance = parseFloat($("#kt_current_balance").val()) || 0;

    let enteredAmount = parseFloat($(this).val()) || 0;

     if (enteredAmount > currentBalance) {
        toastr.error('You have insufficient balance to your account', "Error!");
     }
});

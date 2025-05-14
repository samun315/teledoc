let selectedForm = $("#submitForm");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/payment/adjust/balance";

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
    $("#kt_type").val("").trigger("change");
    $("#kt_user_id").val("").trigger("change");
}

$("#openAdjustBalanceModal").on("click", function () {
    openModal();
});

function openModal() {
    loader(selectedForm, false);
    $("#kt_gateway_id").val(null);
    $(".modal-title").text("Balance Adjust");
    $(".btnSubmit").text("SEND");
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

    $.ajax({
        url: BASE_URL+'/store',
        data: formData,
        type: "POST", // Always use POST for FormData, append _method for PUT
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            console.log(response);
            
            if (response?.statusCode == 200 || response?.statusCode == 201) {
                $("#showModal").modal("hide");
                formReset();
                toastr.success(response?.message);
                table.draw();
            }
        },
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

let table = $("#kt_table_balance_adjust").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL + "/",
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
            data: "user",
            name: "user",
        },
        {
            data: "balance",
            name: "balance",
        },
        {
            data: "type",
            render: function (data, type, row) {
                if (!data) return "";
                let types = '';
                let status = '';
                if (data == 'debit') {
                    types ='MINUS';
                    status ='text-danger';
                } else {
                     types ='ADD';
                    status ='text-success';
                }
                return `<p class="${status}">${types}</p>`;
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

$("#kt_user_id").on("change",function () {
    let user_id = $(this).val();
    $.ajax({
        url: BASE_URL + "/get-account-data/" + user_id,
        type: "GET",
        success: function (response) {
            loader(selectedForm, false);
            let accountData = response.account;

            if (
                response?.success &&
                response?.statusCode === 200 &&
                accountData
            ) {
                $("#kt_current_balance").val(accountData.current_balance);
            }
        },
    });
});

$("#kt_balance").on("keyup",function(){
    let currentBalance = parseFloat($("#kt_current_balance").val()) || 0;

    let enteredAmount = parseFloat($(this).val()) || 0;

    if ($("#kt_type").val() == 'minus' && enteredAmount > currentBalance) {
        toastr.error('This user has insufficient balance to his account', "Error!");
    }
});
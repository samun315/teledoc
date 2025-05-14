// Get the current URL of the window
const BASE_URL = window.location.origin + "/payment/currency";

let search = $("#search");

let table = $("#currecny-table").DataTable({
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
            data: "currency_name",
            name: "currency_name",
        },
        {
            data: "currency_code",
            name: "currency_code",
        },
        {
            data: "active",
            render: function (data, type, full, meta) {
                const checked = data === "YES" ? "checked" : "";
                const toggleStatus = data === "YES" ? "NO" : "YES";
                const checkbox =
                    '<input class="form-check-input activeStatus" data-id=' +
                    full.id +
                    ' name="active" type="checkbox" value="' +
                    data +
                    '" ' +
                    checked +
                    "/>" +
                    '<input type="hidden" id="toggleData_' +
                    full.id +
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
            className: "btn btn-info btn-sm",
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

$(document).on("change", ".activeStatus", function () {
    let id = $(this).attr("data-id");
    let active = $("#toggleData_" + id).val();
    updateActiveStatus(active, id);
});

function updateActiveStatus(active, id) {
    
    $.ajax({
        type: "PUT",
        url: BASE_URL + "/update-status",
        data: {
            id: id,
            active: active,
            _token: setCSRFToken(),
        },
        dataType: "json",
        success: function (response) {
            if (response?.statusCode === 200) {
                toastr.success(response?.message, "Success!");
                table.draw();
            } else {
                toastr.error(
                    response?.message || "An unexpected error occurred."
                );
            }
        },
    });
}

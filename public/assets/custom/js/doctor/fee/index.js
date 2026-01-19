// Get the current URL of the window
const BASE_URL = window.location.origin + "/doctor/fee";

let search = $("#search");

let table = $("#kt_doctor_fee_table").DataTable({
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
            data: "doctor_info",
            name: "doctor_info",
        },
        {
            data: "consultation_fee",
            name: "consultation_fee",
        },
        {
            data: "platform_commission",
            name: "platform_commission",
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false,
        },
    ],
    columnDefs: [
        {
            targets: "_all",
            defaultContent: "",
        },
    ],
    paging: true, // Enables pagination
    pageLength: 10, // Show 10 records per page
    lengthMenu: [10, 25, 50, 75, 100, 200], // Dropdown for selecting number of rows
});

search.keyup(function () {
    table.draw();
});

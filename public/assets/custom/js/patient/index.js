let selectedForm = $("#submitForm");

$("#kt_date_of_birth").flatpickr({
    dateFormat: "d-m-Y",
    allowInput: true,
    maxDate: "today",
});

// Get the current URL of the window
const BASE_URL = window.location.origin + "/patient";

let search = $("#search");

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

let table = $("#kt_patient_table").DataTable({
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
            data: "photo",
            name: "photo",
        },
        {
            data: "info",
            name: "info",
        },
        {
            data: "contact_info",
            name: "contact_info",
        },
        {
            data: "medical_info",
            name: "medical_info",
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
    paging: true, // Enables pagination
    pageLength: 10, // Show 5 records per page
    lengthMenu: [10, 25, 50, 75, 100, 200], // Dropdown for selecting number of rows
    // dom:
    //     '<"row"<"col-sm-2"l><"col-sm-10 d-flex justify-content-end"B>>' + // Length menu & buttons
    //     '<"row"<"col-sm-12"tr>>' + // Table rows
    //     '<"row mt-2"<"col-sm-6"i><"col-sm-6 d-flex justify-content-end"p>>', // Pagination & info
    // buttons: [
    //     {
    //         extend: "excelHtml5",
    //         text: "Excel",
    //         className: "btn btn-success btn-sm",
    //         attr: {
    //             style: "margin-top: 25px;padding: 0 10px; font-size: 12px; line-height: 1; height: 30px;",
    //         },
    //         exportOptions: {
    //             columns: ":not(:first-child)", // Exclude the first column (DT_RowIndex)
    //         },
    //     },
    //     {
    //         extend: "pdfHtml5",
    //         text: "PDF",
    //         className: "btn btn-danger btn-sm",
    //         attr: {
    //             style: "margin-top: 25px;padding: 0 10px; font-size: 12px; line-height: 1; height: 30px;",
    //         },
    //         exportOptions: {
    //             columns: ":not(:first-child)", // Exclude the first column (DT_RowIndex)
    //         },
    //     },
    // ],
});

search.keyup(function () {
    table.draw();
});

// PHOTO PREVIEW WHEN UPLOAD FROM DEVICE

const photoInput = document.getElementById("photoInput");
const photoPreview = document.getElementById("photoPreview");
const uploadPlaceholder = document.getElementById("uploadPlaceholder");
const removeBtn = document.getElementById("removeBtn");

function showPreview(src) {
    photoPreview.src = src;
    photoPreview.classList.remove("d-none");
    photoPreview.classList.add("d-block");

    uploadPlaceholder.classList.add("d-none");
    uploadPlaceholder.classList.remove("d-flex");

    removeBtn.classList.remove("d-none");
    removeBtn.classList.add("d-block");
}

function resetPreview() {
    photoInput.value = "";
    photoPreview.src = "";
    photoPreview.classList.add("d-none");
    photoPreview.classList.remove("d-block");

    uploadPlaceholder.classList.remove("d-none");
    uploadPlaceholder.classList.add("d-flex");

    removeBtn.classList.add("d-none");
    removeBtn.classList.remove("d-block");
}

photoInput.addEventListener("change", function () {
    const file = this.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            showPreview(e.target.result);
        };
        reader.readAsDataURL(file);
    }
});

removeBtn.addEventListener("click", function () {
    resetPreview();
});

// AGE CALCULATE DEPEND ON DATE OF BIRTH

const dobInput = document.getElementById("kt_date_of_birth");
const ageInput = document.getElementById("kt_age");

dobInput.addEventListener("change", function () {
    const dobStr = this.value; // e.g. "25-06-1990"
    if (!dobStr) {
        ageInput.value = "";
        return;
    }

    // Parse the "d-m-Y" format manually
    const parts = dobStr.split("-");
    if (parts.length !== 3) {
        ageInput.value = "";
        return;
    }

    const day = parseInt(parts[0], 10);
    const month = parseInt(parts[1], 10) - 1; // months are 0-based
    const year = parseInt(parts[2], 10);

    const dob = new Date(year, month, day);
    if (isNaN(dob)) {
        ageInput.value = "";
        return;
    }

    const today = new Date();

    let years = today.getFullYear() - dob.getFullYear();
    let months = today.getMonth() - dob.getMonth();
    let days = today.getDate() - dob.getDate();

    if (days < 0) {
        months--;
        // Get days in previous month to adjust days difference
        const prevMonth = new Date(today.getFullYear(), today.getMonth(), 0);
        days += prevMonth.getDate();
    }

    if (months < 0) {
        years--;
        months += 12;
    }

    // Calculate fractional age: years + (months/12) + (days/365)
    const fractionalAge = years + months / 12 + days / 365;

    ageInput.value = fractionalAge >= 0 ? fractionalAge.toFixed(1) : "";
});

// const dobInput = document.getElementById("kt_date_of_birth");
// const ageInput = document.getElementById("kt_age");

// dobInput.addEventListener("change", function () {
//     const dobStr = this.value; // e.g. "25-06-1990"
//     if (!dobStr) {
//         ageInput.value = "";
//         return;
//     }

//     // Parse the "d-m-Y" format manually
//     const parts = dobStr.split("-");
//     if (parts.length !== 3) {
//         ageInput.value = "";
//         return;
//     }

//     const day = parseInt(parts[0], 10);
//     const month = parseInt(parts[1], 10) - 1; // months are 0-based
//     const year = parseInt(parts[2], 10);

//     const dob = new Date(year, month, day);

//     if (isNaN(dob)) {
//         ageInput.value = "";
//         return;
//     }

//     const today = new Date();
//     let age = today.getFullYear() - dob.getFullYear();
//     const m = today.getMonth() - dob.getMonth();
//     if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
//         age--;
//     }

//     ageInput.value = age >= 0 ? age : "";
// });

let selectedForm = $("#submitForm");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/doctor";

let search = $("#search");
let department_id = $("#department_id");

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

let table = $("#kt_doctor_table").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL + "/",
        data: function (d) {
            d.search = search.val();
            d.department_id = department_id.val();
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
});

search.keyup(function () {
    table.draw();
});

department_id.change(function () {
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

// let incrementId = 1;

// Add more rows Start
$("#addMoreBtn").on("click", function () {
    const lastRow = $(".degree_row_element").last().length
        ? $(".degree_row_element").last()
        : $(".static_row"); // fallback to static first row

    let degree_title = lastRow.find(".degree_title").val();
    let degree_description = lastRow.find(".degree_description").val();

    // 🔎 Validate inputs
    if (!degree_title || !degree_description) {
        toastr.info(
            "Please fill degree title and description before adding a new row."
        );
        return;
    }

    incrementId++;
    const newRow = `
        <div class="row degree_row_element" data-increment-id="${incrementId}">
            <div class="row">
                 <div class="col-md-5 fv-row mb-5">
                    <label class="required fs-5 fw-bold mb-2">Title</label>
                        <input type="text" class="form-control form-control-light degree_title"
                                                name="degree_title[]" id="degree_title_${incrementId}" required />
                </div>
                <div class="col-md-6 fv-row mb-5">
                    <label class="fs-5 fw-bold mb-2">Description</label>
                    <input type="text" class="form-control form-control-light degree_description"
                                                name="degree_description[]" id="degree_description_${incrementId}" />
                </div>
                <div class="col-md-1 fv-row mb-5">
                    <div class="d-flex align-items-end">
                         <button type="button" class="btn btn-sm btn-icon btn-danger mt-10 ms-2 deleteDegree">
                             <i class="fas fa-trash-alt ms-1"></i>
                         </button>
                    </div>
                </div>
            </div>
        </div>`;

    $(".degree_append_div").append(newRow);
});

// Remove transfer row
$(document).on("click", ".deleteDegree", function () {
    $(this).parents(".degree_row_element").remove();
});

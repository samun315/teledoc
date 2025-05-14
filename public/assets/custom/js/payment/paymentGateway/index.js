let selectedForm = $("#submitForm");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/payment/manual/gateway";

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
    $("#kt_currency_code").val("").trigger("change");
    
    if (editorInstance) {
        editorInstance.setData(""); // Set CKEditor content dynamically
    }
}

$("#openGatewayModal").on("click", function () {
    openModal();
});

function openModal() {
    loader(selectedForm, false);
    $("#kt_gateway_id").val(null);
    $(".modal-title").text("Add New Gateway");
    $(".btnSubmit").text("Submit");
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

    let gatewayId = $("#kt_gateway_id").val();
    let url = "";
    if (gatewayId) {
        url = BASE_URL + "/update/" + gatewayId;
        formData.append("_method", "PUT");
    } else {
        url = BASE_URL + "/store";
    }

    $.ajax({
        url: url,
        data: formData,
        type: "POST", // Always use POST for FormData, append _method for PUT
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response?.statusCode === 200 || response?.statusCode === 201) {
                $("#showModal").modal("hide");
                formReset();
                toastr.success(response?.message);
                table.draw();
            }
        },
        error: handleError,
    });
});

// success: function (response) {
//     if (response?.statusCode === 200 || response?.statusCode === 201) {
//         $("#showModal").modal("hide");
//         formReset();
//         toastr.success(response?.message);
//         table.draw();
//     }
// },

let table = $("#kt_table_gateway").DataTable({
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
            data: "gateway_name",
            name: "gateway_name",
        },
        {
            data: "currency_code",
            name: "currency_code",
        },
        {
            data: "rate",
            name: "rate",
        },
        {
            data: "active",
            render: function (data) {
                if (!data) return "";

                let statusValue = "";

                if (data == "NO") {
                    statusValue = "Inactive";
                } else if (data == "YES") {
                    statusValue = "Active";
                }

                return `${statusValue}`;
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

search.keyup(function () {
    table.draw();
});

$(document).on("click", ".editGatewayBtn", function () {
    var gatewayId = $(this).attr("data-id");
    editGatewayInfo(gatewayId);
});

function editGatewayInfo(gatewayId) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        url: BASE_URL + "/edit/" + gatewayId,
        type: "GET",
        success: function (response) {
            loader(selectedForm, false);
            let gatewayInfo = response.gatewayInfo;

            if (
                response?.success &&
                response?.statusCode === 200 &&
                gatewayInfo
            ) {
                $("#kt_gateway_id").val(gatewayInfo.id);
                $("#kt_gateway_name").val(gatewayInfo.gateway_name);
                // $("#kt_details").val(gatewayInfo.details);
                $("#kt_currency_code").val(gatewayInfo.currency_code).change();
                $("#kt_rate").val(gatewayInfo.rate);

                if (editorInstance) {
                    editorInstance.setData(gatewayInfo.details); // Set CKEditor content dynamically
                }
                $(".modal-title").text("Edit Gateway");
                $(".btnSubmit").text("Update");
            }
        },
    });
}

let editorInstance;
// Initialize CKEditor
document.addEventListener("DOMContentLoaded", () => {
    const termsElements = document.querySelectorAll(".details");

    if (termsElements.length > 0) {
        termsElements.forEach((element, index) => {
            ClassicEditor.create(element, {
                styleNonce: "{{ $cspNonce }}",
            })
                .then((editor) => {
                    editorInstance = editor;
                })
                .catch((error) => {
                    console.error(
                        `Error initializing editor for element ${index + 1}:`,
                        error
                    );
                });

                $(".btnSubmit").on("click", function (e) {
                    if (editorInstance) {
                        $("textarea.details").val(editorInstance.getData()); // Manually update textarea
                        let terms = $("textarea.details").val().trim();
                
                        if (terms === "" || terms === "<p><br></p>") {
                            $(".terms_error")
                                .text("Details field is required.")
                                .css("color", "red");
                            e.preventDefault();
                        } else {
                            $(".terms_error").text(""); // Clear error if valid
                        }
                    } else {
                        console.error("CKEditor instance not initialized.");
                        e.preventDefault();
                    }
                });
                
        });
    } else {
        console.warn("No elements with the class '.details' found.");
    }
});

$(document).on("click", ".detailsGatewayBtn", function () {
    let id = $(this).attr("data-id");
    getPaymentGatewayDetails(id);
});

function getPaymentGatewayDetails(id) {
    loader(selectedForm, true);

    fetch(`${BASE_URL}/get-gateway-details/${id}`)
        .then((response) => response.json())
        .then((response) => {
            loader(selectedForm, false);
            let data = response.gatewayInfo;
            const detailsElement = document.getElementById("kt_details_id");

            if (
                response?.success &&
                response?.statusCode === 200 &&
                data &&
                detailsElement
            ) {
                detailsElement.innerHTML = data.details; // Insert HTML content
                styleTables(detailsElement); // Apply table styles dynamically
            } else {
                console.warn("No valid details found.");
            }
        })
        .catch((error) => {
            loader(selectedForm, false);
            console.error("Error fetching payment gateway details:", error);
        });
}

// Function to apply Bootstrap or custom styling to tables inside the content
function styleTables(container) {
    const tables = container.querySelectorAll("table");
    tables.forEach((table) => {
        table.classList.add(
            "table",
            "table-bordered",
            "table-striped",
            "align-middle",
            "table-responsive",
            "table-row-dashed",
            "fs-7",
            "gx-5",
            "gy-5",
            "no-footer"
        ); // Apply Bootstrap styles
    });
}


$(document).on("click", ".deleteGatewayBtn", function () {
    let deleteId = $(this).attr("data-id");
    deleteData(deleteId);
});

function deleteData(deleteId) {
    Swal.fire({
        html: `Are you want to delete this?`,
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
                    type: "DELETE",
                    url: BASE_URL + "/destroy/" + deleteId,
                    dataType: "JSON",
                    success: function (response) {
                        if (response?.statusCode === 200) {
                            toastr.success(response?.message, "Success!");
                            table.draw();
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

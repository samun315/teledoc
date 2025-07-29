// Get the current URL of the window
const BASE_URL = window.location.origin + "/drug/prescription";
const filePath = window.location.origin;

$(document).ready(function () {

    // Open patient modal
    $('#openPatientModal').on('click', function () {
        $('#patientModal').modal('show');

        getPatientList();
    });

    // Search filter
    // $(document).on('keyup', '#searchPatient', function () {
    //   const term = $(this).val().toLowerCase();
    //   $('#patientList .select-patient').each(function () {
    //     const text = $(this).text().toLowerCase();
    //     $(this).toggle(text.includes(term));
    //   });
    // });

    // Prevent form submission on Enter key inside search input
    $('#searchPatient').on('keypress', function (e) {
        if (e.which === 13) {
            e.preventDefault();
        }
    });

    // Live filter as user types
$('#searchPatient').on('keyup', function () {
    const term = $(this).val().toLowerCase().trim();

    if (term === '') {
        $('#patientList .select-patient').show();
        return;
    }

    $('#patientList .select-patient').each(function () {
        const name = $(this).find('.patient-name').text().toLowerCase();

        if (name.includes(term)) {
            $(this).show();
        } else {
            $(this).hide();
        }
    });
});





    // Patient selection
    $(document).on('click', '.select-patient', function () {
        $('.select-patient').removeClass('active');
        $('.check-icon').addClass('d-none');
        $(this).addClass('active');
        $(this).find('.check-icon').removeClass('d-none');
    });

    // Reset selection when modal is closed
    $('#patientModal').on('hidden.bs.modal', function () {
        $('.select-patient.active').removeClass('active');
        $('.check-icon').addClass('d-none');
        $('#searchPatient').val('');
    });

    // Placeholder for create prescription button handler
    $('#createPrescription').on('click', function () {
        // Add prescription creation logic here if needed
    });
});


function getPatientList() {
    $.ajax({
        type: "GET",
        url: `${BASE_URL}/get-patient`,
        dataType: "json",
        success: (response) => {
            if (response?.success && response?.statusCode === 200) {
                const { patientInfo } = response;

                const $patientList = $('#patientList');
                $patientList.empty(); // Clear existing list

                if (Array.isArray(patientInfo) && patientInfo.length > 0) {
                    patientInfo.forEach(patient => {
                        const imagePath = patient.photo ? `${filePath}/uploads/patient/${patient.photo}` : `${filePath}/assets/media/avatars/blank.png`;

                        // Build the patient item div dynamically
                        // Assuming patient has id, name, phone properties - adjust as needed
                        const patientItem = `
                <div class="select-patient d-flex align-items-center justify-content-between border rounded p-2 mb-2 cursor-pointer" data-id="${patient.patient_id}">
                  <div class="d-flex align-items-center patient-info">
                    <img src="${imagePath}" class="rounded-circle me-2"  width="40" height="40" alt="Patient Avatar">
                    <div>
                      <strong class="patient-name">${patient.name}</strong><br>
                      <small>${patient.phone}</small>
                    </div>
                  </div>
                  <div class="check-icon d-none text-primary">
                    <i class="bi bi-check-circle-fill"></i>
                  </div>
                </div>
              `;
                        $patientList.append(patientItem);
                    });
                } else {
                    $patientList.html('<p class="text-muted">No patients found.</p>');
                }
            } else {
                toastr.error(response?.message || "An unexpected error occurred.");
            }
        },
        error: (jqXHR) => {
            // Optional loader function you may have
            // loader(selectedForm, false);

            if (jqXHR.status === 422) {
                displayValidationErrors(jqXHR.responseJSON?.errors);
            } else {
                toastr.error(jqXHR.responseJSON?.message || "An unexpected error occurred.");
            }
        },
    });
}


let search = $("#search");
let subscription_type = $("#subscription_type_id");

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

// Get the current URL of the window
const BASE_URL = window.location.origin + "/drug/prescription";
const ORIGIN_URL = window.location.origin;

$(document).ready(function () {

    // Open patient modal
    $('#openPatientModal').on('click', function () {
        $('#patientModal').modal('show');
        getPatientList();
    });

    // Prevent form submission on Enter inside search box
    $('#searchPatient').on('keypress', function (e) {
        if (e.which === 13) e.preventDefault();
    });

    // Live search: filter by name or phone
    $('#searchPatient').on('keyup', function () {
        const term = $(this).val().toLowerCase().trim();

        $('#patientList .select-patient').each(function () {
            const name = $(this).find('.patient-name').text().toLowerCase();
            const phone = $(this).find('small').text().toLowerCase();

            if (term === '' || name.includes(term) || phone.includes(term)) {
                $(this).removeClass('d-none').addClass('d-flex');
            } else {
                $(this).removeClass('d-flex').addClass('d-none');
            }
        });

        // Check if any patient is visible after filtering
        if ($('#patientList .select-patient.d-flex').length === 0) {
            // If none visible, show "No patients found"
            if ($('#patientList .no-patient-message').length === 0) {
                $('#patientList').append('<p class="no-patient-message text-muted">No patients found.</p>');
            }
        } else {
            // Remove the message if patients are visible
            $('#patientList .no-patient-message').remove();
        }
    });


    // Patient selection behavior
    $(document).on('click', '.select-patient', function () {
        $('.select-patient').removeClass('active');
        $('.check-icon').addClass('d-none');
        $(this).addClass('active');
        $(this).find('.check-icon').removeClass('d-none');

        const patientId = $(this).data('patient-id'); // Corrected variable

        // const baseUrl = $('#createPrescription').data('route'); // Get the base URL from data attribute
        const prescriptionRoute = ORIGIN_URL + `/drug/prescription/create/${patientId}`;

        // Set the href dynamically
        $('#createPrescription').attr('href', prescriptionRoute);
    });


    // Reset everything on modal close
    $('#patientModal').on('hidden.bs.modal', function () {
        $('#searchPatient').val('');
        $('.select-patient').removeClass('active d-none').addClass('d-flex');
        $('.check-icon').addClass('d-none');

        // Remove the href from Create Prescription button
        $('#createPrescription').removeAttr('href');
    });

    // Placeholder: create prescription action
    $('#createPrescription').on('click', function () {
        const selectedPatient = $('.select-patient.active');
        if (selectedPatient.length === 0) {
            toastr.error('Please select a patient first!');
            return;
        }
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
                $patientList.empty();

                if (Array.isArray(patientInfo) && patientInfo.length > 0) {
                    patientInfo.forEach(patient => {
                        const imagePath = patient.photo
                            ? `${ORIGIN_URL}/uploads/patient/${patient.photo}`
                            : `${ORIGIN_URL}/assets/media/avatars/blank.png`;

                        const patientItem = `
                            <div class="select-patient d-flex align-items-center justify-content-between border rounded p-2 mb-2 cursor-pointer" data-patient-id="${patient.patient_id}">
                                <div class="d-flex align-items-center patient-info">
                                    <img src="${imagePath}" class="rounded-circle me-2" width="40" height="40" alt="Patient Avatar">
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

                    // Reapply search if user already typed something
                    $('#searchPatient').trigger('keyup');
                } else {
                    $patientList.html('<p class="text-muted">No patients found.</p>');
                }
            } else {
                toastr.error(response?.message || "An unexpected error occurred.");
            }
        },
        error: (jqXHR) => {
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

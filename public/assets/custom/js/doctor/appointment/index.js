// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

let search = $("#search");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/appointment";
const ORIGIN_URL = window.location.origin;

let validate = selectedForm.validate({
    rules: {
        name: "required",
    },
    onsubmit: true,
});

// fetch the data
let table = $("#kt_appointment_table").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL,
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
            data: "appointment_code",
            name: "appointment_code",
        },
        {
            data: "created_at",
            name: "created_at",
        },
        {
            data: "patient_info",
            name: "patient_info",
        },
        {
            data: "status",
            name: "status",
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

$(document).ready(function () {
    // Default message show when no doctor selected
    $(".doctorInfo").hide();
    $(".noDoctorDiv").show();
    $(".patientInfo").hide();
    $(".noPatientDiv").show();


    // Doctor select change event
    $("#kt_doctor_id").on("change", function () {
        let doctorId = $(this).val();

        if (!doctorId) {
            $(".doctorInfo").hide(); // select khali thakle hide
            return;
        }

        $.ajax({
            url: BASE_URL + "/get-doctor-info/" + doctorId, // apnar route hobe
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response && response.success && response.data) {
                    let doctor = response.data;

                    const imagePath = doctor.photo
                        ? `${ORIGIN_URL}/uploads/doctor/${doctor.photo}`
                        : `${ORIGIN_URL}/assets/media/avatars/blank.png`;

                    let fullName = (doctor.title ? doctor.title + " " : "") + doctor.name;

                    $("#kt_doctor_image").attr("src", imagePath);
                    $("#kt_doctor_name").text(fullName);
                    $("#kt_doctor_department").html("<strong>Department:</strong> " + (doctor.department.department_name ?? "N/A"));
                    $("#kt_doctor_phone").html("<strong>Phone:</strong> " + (doctor.phone ?? "N/A"));
                    $("#kt_doctor_email").html("<strong>Email:</strong> " + (doctor.email ?? "N/A"));
                    $("#kt_doctor_address").html("<strong>Address:</strong> " + (doctor.address ?? "N/A"));

                    $(".doctorInfo").show();
                    $(".noDoctorDiv").hide();
                } else {
                    $(".noDoctorDiv").show();
                    $(".doctorInfo").hide();
                }
            },
            error: function () {
                $(".noDoctorDiv").show();
            }
        });
    });

    // Patient select change event
    $('#kt_patient_id').on('change', function () {
        let patientId = $(this).val();

        if (!patientId) {
            $(".patientInfo").hide(); // select khali thakle hide
            return;
        }

        $.ajax({
            url: BASE_URL + "/get-patient-info/" + patientId, // apnar route hobe
            type: "GET",
            dataType: "json",
            success: function (response) {
                if (response && response.success && response.data) {
                    let patient = response.data;

                    const imagePath = patient.photo
                        ? `${ORIGIN_URL}/uploads/patient/${patient.photo}`
                        : `${ORIGIN_URL}/assets/media/avatars/blank.png`;

                    $("#kt_patient_image").attr("src", imagePath);
                    $("#kt_patient_name").text(patient.name);
                    $("#kt_patient_age").text(patient.age);
                    $("#kt_patient_gender").text(patient.gender);
                    $("#kt_patient_phone").html("<strong>Phone:</strong> " + (patient.phone ?? "N/A"));
                    $("#kt_patient_email").html("<strong>Email:</strong> " + (patient.email ?? "N/A"));
                    $("#kt_patient_address").html("<strong>Address:</strong> " + (patient.address ?? "N/A"));

                    $(".patientInfo").show();
                    $(".noPatientDiv").hide();
                } else {
                    $(".noPatientDiv").show();
                    $(".patientInfo").hide();
                }
            },
            error: function () {
                $(".nopatientDiv").show();
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('appointmentCalendar');
    var selectedDateEl = null;

    var today = new Date().toISOString().split('T')[0]; // today's date in YYYY-MM-DD

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev',
            center: 'title',
            right: 'next'
        },
        buttonText: { prev: '<', next: '>' },

        // Disable past dates
        validRange: {
            start: today
        },

        dateClick: function (info) {
            // Only allow clicks on valid dates
            if (info.dateStr < today) return;

            // Remove previous selection
            if (selectedDateEl) {
                selectedDateEl.classList.remove('fc-day-selected');
            }

            // Highlight only the date number
            var dayNumber = info.dayEl.querySelector('.fc-daygrid-day-number');
            dayNumber.classList.add('fc-day-selected');
            selectedDateEl = dayNumber;

            console.log("Selected date: " + info.dateStr);
        }
    });

    calendar.render();
});

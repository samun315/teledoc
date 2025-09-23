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

    return `${day} ${month}, ${date.getFullYear()}`;
};

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
            data: "date_of_appointment",
            name: "date_of_appointment",
        },
        {
            data: "doctor_info",
            name: "doctor_info",
        },
        {
            data: "patient_info",
            name: "patient_info",
        },
        {
            data: "appointment_status",
            render: function (data) {
                if (!data) return "";

                let status = "";

                if (data == "Pending") {
                    status = "badge-warning";
                } else if (data == "Approved") {
                    status = "badge-success";
                } else {
                    status = "badge-danger";
                }

                return `<p class="badge ${status}">${data}</p>`;
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

$(document).ready(function () {

    // ---------- Default Messages ----------
    $(".doctorInfo").hide();
    $(".noDoctorDiv").show();
    $(".patientInfo").hide();
    $(".noPatientDiv").show();
    $(".scheduleSlots").hide();

    let calendar; // global calendar instance
    let selectedDateEl = null;

    // ---------- Initialize Calendar ----------
    initCalendar($("#kt_doctor_id").val());

    function initCalendar(doctorId = null) {
        var calendarEl = document.getElementById('appointmentCalendar');
        var today = new Date().toISOString().split('T')[0];

        calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: { left: 'prev', center: 'title', right: 'next' },
            buttonText: { prev: '<', next: '>' },
            validRange: { start: today },
            dateClick: function (info) {
                if (!doctorId) {
                    toastr.warning("Please select a doctor first!");
                    return;
                }

                // Remove previous date highlight
                if (selectedDateEl) selectedDateEl.classList.remove('fc-day-selected');

                // Highlight selected date
                var dayNumber = info.dayEl.querySelector('.fc-daygrid-day-number');
                dayNumber.classList.add('fc-day-selected');
                selectedDateEl = dayNumber;

                // Set hidden input
                $('#selectedAppointmentDate').val(info.dateStr);

                // Refresh schedule slots
                $('#scheduleSlots').html('<p class="text-muted">Loading slots...</p>');
                loadScheduleSlots(doctorId, info.dateStr);
            }
        });

        calendar.render();
    }

    // ---------- Load Schedule Slots ----------
    function loadScheduleSlots(doctorId, date) {
        $.ajax({
            url: BASE_URL + '/generate-daily-slots/' + doctorId + '/' + date,
            method: 'GET',
            success: function (response) {
                if (response.success && response.slots.length > 0) {
                    let html = '<div class="d-flex flex-wrap gap-2">';
                    response.slots.forEach(function (slot) {
                        let time = new Date("1970-01-01T" + slot.start + ":00");
                        let formatted = time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

                        html += `
                        <label class="slot-box border rounded p-2 text-center bg-light">
                            <input type="radio" name="selected_slot" value="${slot.slot_id}" data-time="${slot.start}" class="d-none">
                            <span>${formatted}</span>
                        </label>`;
                    });
                    html += '</div>';
                    html += `<input type="hidden" id="selectedSlotId" name="slot_id" value="">`;
                    html += `<input type="hidden" id="selectedSlotTime" name="slot_time" value="">`;

                    $('#scheduleSlots').html(html);

                    // Slot select
                    $(document).off('change', 'input[name="selected_slot"]').on('change', 'input[name="selected_slot"]', function () {
                        $('.slot-box').removeClass('bg-info text-white border-info');
                        $(this).closest('.slot-box').addClass('bg-info text-white border-info');

                        $('#selectedSlotId').val($(this).val());
                        $('#selectedSlotTime').val($(this).data('time'));
                    });
                } else {
                    $('#scheduleSlots').html('<p class="text-danger">No available slots for this date.</p>');
                }
            },
            error: function () {
                $('#scheduleSlots').html('<p class="text-danger">Failed to load schedule slots.</p>');
            }
        });
    }

    // ---------- Doctor Change ----------
    $("#kt_doctor_id").on("change", function () {
        let doctorId = $(this).val();

        // Clear schedule slots

        $(".scheduleSlots").show();
        $('#scheduleSlots').html('<p class="text-muted">Please select a date to load slots</p>');
        $('#selectedAppointmentDate').val('');
        $('#selectedSlotId').val('');
        $('#selectedSlotTime').val('');
        selectedDateEl = null;

        // Reset calendar
        if (typeof calendar !== "undefined") {
            calendar.destroy();
            initCalendar(doctorId);
        }

        if (!doctorId) {
            $(".doctorInfo").hide();
            $(".noDoctorDiv").show();
            return;
        }

        // Load doctor info
        $.ajax({
            url: BASE_URL + "/get-doctor-info/" + doctorId,
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

    // ---------- Patient Change ----------
    $('#kt_patient_id').on('change', function () {
        let patientId = $(this).val();

        if (!patientId) {
            $(".patientInfo").hide();
            $(".noPatientDiv").show();
            return;
        }

        $.ajax({
            url: BASE_URL + "/get-patient-info/" + patientId,
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
                $(".noPatientDiv").show();
            }
        });
    });

    // ---------- Form Submit Validation ----------
    $('#appointmentForm').on('submit', function (e) {
        let doctorId = $('#kt_doctor_id').val();
        let patientId = $('#kt_patient_id').val();
        let appointmentDate = $('#selectedAppointmentDate').val();
        let slotId = $('#selectedSlotId').val();

        if (!doctorId) { e.preventDefault(); toastr.error("Please select a doctor."); return; }
        if (!patientId) { e.preventDefault(); toastr.error("Please select a patient."); return; }
        if (!appointmentDate) { e.preventDefault(); toastr.error("Please select an appointment date."); return; }
        if (!slotId) { e.preventDefault(); toastr.error("Please select a slot."); return; }
    });

});

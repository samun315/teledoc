// Base URLs
const BASE_URL = window.location.origin + "/appointment";
const ORIGIN_URL = window.location.origin;

let calendar; // global calendar instance
let selectedDateEl = null;
const appointmentId = $("#kt_appointment_id").val();

$(document).ready(function () {

    // ---------- Default visibility ----------
    $(".doctorInfo").hide();
    $(".noDoctorDiv").show();
    $(".patientInfo").hide();
    $(".noPatientDiv").show();
    $(".scheduleSlots").hide();

    // ---------- Initialize Calendar ----------
    initCalendar($("#kt_doctor_id").val());

    // ---------- Edit Mode ----------
    if (typeof editData !== "undefined" && editData) {
        const doctorId = editData.doctor_id;
        const patientId = editData.patient_id;
        const appointmentDate = editData.appointment_date;
        const selectedSlotId = editData.slot_id ?? null;


        // Load doctor & patient info
        if (doctorId) getDoctorInfoById(doctorId);
        if (patientId) getPatientInfoById(patientId);

        // Wait a bit for calendar to render
        setTimeout(() => {
            if (appointmentDate) {
                // Highlight the existing date
                const dateCell = document.querySelector(
                    `.fc-daygrid-day[data-date="${appointmentDate}"] .fc-daygrid-day-number`
                );
                if (dateCell) {
                    dateCell.classList.add('fc-day-selected');
                    selectedDateEl = dateCell;
                }

                // Set hidden input
                $('#selectedAppointmentDate').val(appointmentDate);

                // Show slots container
                $(".scheduleSlots").show();

                // Load slots for that date
                if (doctorId) {
                    loadScheduleSlots(doctorId, appointmentDate);

                    // Select previously booked slot after slots are loaded
                    if (selectedSlotId) {
                        const checkSlot = setInterval(() => {
                            const slotInput = $(`input[name="selected_slot"][value="${selectedSlotId}"]`);
                            if (slotInput.length) {
                                slotInput.prop('checked', true).trigger('change');
                                clearInterval(checkSlot);
                            }
                        }, 200);
                    }
                }
            }
        }, 300);
    }

    // ---------- Doctor change ----------
    $("#kt_doctor_id").on("change", function () {
        const doctorId = $(this).val();
        getDoctorInfoById(doctorId);
    });

    // ---------- Patient change ----------
    $('#kt_patient_id').on('change', function () {
        const patientId = $(this).val();
        getPatientInfoById(patientId);
    });

    // ---------- Form validation ----------
    $('#appointmentForm').on('submit', function (e) {
        e.preventDefault(); // prevent default submit

        const doctorId = $('#kt_doctor_id').val();
        const patientId = $('#kt_patient_id').val();
        const appointmentDate = $('#selectedAppointmentDate').val();
        const slotId = $('#selectedSlotId').val();

        if (!doctorId) { toastr.error("Please select a doctor."); return; }
        if (!patientId) { toastr.error("Please select a patient."); return; }
        if (!appointmentDate) { toastr.error("Please select an appointment date."); return; }
        if (!slotId) { toastr.error("Please select a slot."); return; }

        // SweetAlert2 confirmation
        Swal.fire({
            html: "Are you sure you want to update this appointment?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, update it!",
            cancelButtonText: "No, cancel",
            customClass: {
                confirmButton: "btn btn-primary",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        }).then((result) => {
            if (result.isConfirmed) {
                // ✅ user confirmed → submit the form
                e.target.submit();
            }
            // else: do nothing, form will not submit
        });
    });

});

// ---------- Initialize Calendar ----------
function initCalendar(doctorId = null) {
    const calendarEl = document.getElementById('appointmentCalendar');
    const today = new Date().toISOString().split('T')[0];

    calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: { left: 'prev', center: 'title', right: 'next' },
        buttonText: { prev: '<', next: '>' },
        validRange: { start: today },
        dateClick: function (info) {
            if (!doctorId) { toastr.warning("Please select a doctor first!"); return; }

            if (selectedDateEl) selectedDateEl.classList.remove('fc-day-selected');

            const dayNumber = info.dayEl.querySelector('.fc-daygrid-day-number');
            dayNumber.classList.add('fc-day-selected');
            selectedDateEl = dayNumber;

            $('#selectedAppointmentDate').val(info.dateStr);
            $(".scheduleSlots").show();
            $('#scheduleSlots').html('<p class="text-muted">Loading slots...</p>');
            loadScheduleSlots(doctorId, info.dateStr);
        }
    });

    calendar.render();
}


// ---------- Load Schedule Slots ----------
function loadScheduleSlots(doctorId, date) {
    $.ajax({
        url: BASE_URL + '/get-previous-slot/' + doctorId + '/' + date + '/' + $("#kt_appointment_id").val(),
        method: 'GET',
        data: {
            patient_id: $("#kt_patient_id").val() // ✅ patient id পাঠানো হলো
        },
        success: function (response) {
            if (response.success && response.slots.length > 0) {
                let html = '<div class="d-flex flex-wrap gap-2">';
                response.slots.forEach(function (slot) {
                    let time = new Date("1970-01-01T" + slot.start + ":00");
                    let formatted = time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

                    // শুধু selected date + patient এর slot checked হবে
                    let checked = slot.slot_id == response.selected_slot_id ? 'checked' : '';

                    html += `
                    <label class="slot-box border rounded p-2 text-center bg-light ${checked ? 'bg-info text-white border-info' : ''}">
                        <input type="radio" name="selected_slot" value="${slot.slot_id}" data-time="${slot.start}" class="d-none" ${checked}>
                        <span>${formatted}</span>
                    </label>`;
                });
                html += '</div>';
                html += `<input type="hidden" id="selectedSlotId" name="slot_id" value="${response.selected_slot_id ?? ''}">`;
                html += `<input type="hidden" id="selectedSlotTime" name="slot_time" value="${response.selected_slot_time ?? ''}">`;

                $('#scheduleSlots').html(html);

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


// ---------- Load Doctor Info ----------
function getDoctorInfoById(doctorId) {
    $(".scheduleSlots").show();
    $('#scheduleSlots').html('<p class="text-muted">Please select a date to load slots</p>');
    $('#selectedAppointmentDate').val('');
    $('#selectedSlotId').val('');
    $('#selectedSlotTime').val('');
    selectedDateEl = null;

    if (!doctorId) {
        $(".doctorInfo").hide();
        $(".noDoctorDiv").show();
        return;
    }

    $.ajax({
        url: BASE_URL + "/get-doctor-info/" + doctorId,
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.success && response.data) {
                let doctor = response.data;
                const imagePath = doctor.photo ? `${ORIGIN_URL}/uploads/doctor/${doctor.photo}` : `${ORIGIN_URL}/assets/media/avatars/blank.png`;
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
}

// ---------- Load Patient Info ----------
function getPatientInfoById(patientId) {
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
            if (response.success && response.data) {
                let patient = response.data;
                const imagePath = patient.photo ? `${ORIGIN_URL}/uploads/patient/${patient.photo}` : `${ORIGIN_URL}/assets/media/avatars/blank.png`;

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
}

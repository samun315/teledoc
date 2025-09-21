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

$(".scheduleSlots").hide();
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

            // Check doctor_id
            let doctorId = document.getElementById('kt_doctor_id')?.value; // ধরা যাক doctor select box এর id হচ্ছে doctor_id

            if (!doctorId) {
                toastr.warning("Please select a doctor first!");
                return;
            }

            // Remove previous selection
            if (selectedDateEl) {
                selectedDateEl.classList.remove('fc-day-selected');
            }

            // Highlight only the date number
            var dayNumber = info.dayEl.querySelector('.fc-daygrid-day-number');
            dayNumber.classList.add('fc-day-selected');
            selectedDateEl = dayNumber;

            console.log("Selected date: " + info.dateStr + " | Doctor ID: " + doctorId);

            // Load schedule slots via AJAX
            $.ajax({
                url: BASE_URL + '/generate-daily-slots/' + doctorId + '/' + info.dateStr,
                method: 'GET',
                beforeSend: function () {
                    $(".scheduleSlots").show();
                    $('#scheduleSlots').html('<p class="text-muted">Loading slots...</p>');
                },
                success: function (response) {
                    if (response.success && response.slots.length > 0) {
                        let html = '<div class="d-flex flex-wrap gap-2">';

                        response.slots.forEach(function (slot, index) {
                            // Convert 24h -> 12h with AM/PM
                            let time = new Date("1970-01-01T" + slot.start + ":00");
                            let formatted = time.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit', hour12: true });

                            html += `
                            <label class="slot-box border rounded p-2 text-center bg-light">
                                <input type="radio" name="selected_slot" value="${slot.slot_id}" data-time="${slot.start}" class="d-none">
                                <span>${formatted}</span>
                            </label>
                          `;
                        });

                        html += '</div>';
                        // Hidden input যেখানে select হওয়া slot id রাখা হবে
                        html += `<input type="hidden" id="selectedSlotId" name="slot_id" value="">`;
                        html += `<input type="hidden" id="selectedSlotTime" name="slot_time" value="">`;

                        $('#scheduleSlots').html(html);

                        // Add highlight effect + hidden input set
                        $(document).on('change', 'input[name="selected_slot"]', function () {
                            // আগের সব থেকে info highlight class সরানো
                            $('.slot-box').removeClass('bg-info text-white border-info');

                            // যেটা select হলো সেখানে info color লাগানো
                            $(this).closest('.slot-box').addClass('bg-info text-white border-info');

                            // Hidden input update
                            $('#selectedSlotId').val($(this).val());           // slot_id
                            $('#selectedSlotTime').val($(this).data('time'));  // start time
                        });

                    } else {
                        $('#scheduleSlots').html('<p class="text-danger">No available slots for this date.</p>');
                    }
                },
                error: function () {
                    $(".scheduleSlots").show();
                    $('#scheduleSlots').html('<p class="text-danger">Failed to load schedule slots.</p>');
                }
            });

        }
    });

    calendar.render();
});


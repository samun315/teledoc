let search = $("#search");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/appointment";
const ORIGIN_URL = window.location.origin;

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
            data: "payment_status",
            name: "payment_status",
        },
        {
            data: "appointment_status",
            render: function (data) {
                if (!data) return "";

                let status = "";

                if (data == "Pending") {
                    status = "badge-warning";
                } else if (data == "Approved" || data == "Completed") {
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

// Payment button click handler (event delegation for dynamically loaded content)
$(document).on('click', '.make-payment-btn', function() {
    const orderId = $(this).data('order-id');
    console.log('Payment button clicked, Order ID:', orderId);
    
    if (!orderId || orderId === '0' || orderId === 0) {
        toastr.error('Order ID is missing or invalid.');
        console.error('Invalid order ID:', orderId);
        return;
    }
    
    openPaymentModal(orderId);
});

// Payment Modal Functions
function openPaymentModal(orderId) {
    // Validate order ID
    orderId = parseInt(orderId);
    if (!orderId || orderId <= 0) {
        toastr.error('Invalid Order ID.');
        console.error('Invalid order ID:', orderId);
        return;
    }
    
    console.log('Opening payment modal for Order ID:', orderId);
    
    // Build URL - ensure it starts with /
    let url;
    if (typeof ORDER_DETAILS_BASE_URL !== 'undefined') {
        url = ORDER_DETAILS_BASE_URL;
        // Ensure URL ends with / if it doesn't already
        if (!url.endsWith('/')) {
            url += '/';
        }
        url += orderId;
    } else {
        url = ORIGIN_URL + '/order/get-order-details/' + orderId;
    }
    
    // Ensure URL is absolute
    if (!url.startsWith('http://') && !url.startsWith('https://') && !url.startsWith('/')) {
        url = '/' + url;
    }
    
    console.log('Fetching order details from:', url);
    console.log('Order ID:', orderId);
    console.log('ORDER_DETAILS_BASE_URL:', typeof ORDER_DETAILS_BASE_URL !== 'undefined' ? ORDER_DETAILS_BASE_URL : 'undefined');
    
    // Fetch order details
    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            console.log('Order details response:', response);
            
            if (response.success && response.data) {
                const order = response.data;
                $('#payment_order_id').val(order.order_id);
                // Use subtotal as base amount (before discount)
                $('#payment_amount').val(order.subtotal);
                $('#payment_discount').val(order.discount || 0);
                calculateFinalAmount();
                $('#payment_transaction_id').val('');
                $('#payment_method').val('');
                
                // Show modal - try Bootstrap 5 first, then fallback to jQuery
                const modalElement = document.getElementById('kt_payment_modal');
                if (modalElement) {
                    // Try Bootstrap 5
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        const modal = new bootstrap.Modal(modalElement);
                        modal.show();
                    } else {
                        // Fallback to jQuery/Bootstrap 4
                        $('#kt_payment_modal').modal('show');
                    }
                } else {
                    console.error('Modal element not found: #kt_payment_modal');
                    toastr.error('Payment modal not found. Please refresh the page.');
                }
            } else {
                const errorMsg = response.message || 'Failed to load order details.';
                toastr.error(errorMsg);
                console.error('Order details failed:', response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Payment Modal Error:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText,
                error: error,
                orderId: orderId
            });
            
            let errorMessage = 'Error loading order details.';
            
            if (xhr.status === 404) {
                errorMessage = xhr.responseJSON?.message || 'Order not found. This appointment may not have an associated order. Please create a new appointment.';
            } else if (xhr.status === 403) {
                errorMessage = 'You do not have permission to access this order.';
            } else if (xhr.status === 500) {
                errorMessage = 'Server error. Please try again.';
            } else if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            toastr.error(errorMessage);
            
            // Log to console for debugging
            if (xhr.responseJSON) {
                console.error('Server response:', xhr.responseJSON);
            }
        }
    });
}

function calculateFinalAmount() {
    const amount = parseFloat($('#payment_amount').val()) || 0;
    const discount = parseFloat($('#payment_discount').val()) || 0;
    const finalAmount = Math.max(0, amount - discount);
    $('#payment_final_amount').val(finalAmount.toFixed(2));
}

// Bind discount change event
$(document).on('input change', '#payment_discount', function() {
    calculateFinalAmount();
});

// Payment Form Submit
$('#kt_payment_form').on('submit', function(e) {
    e.preventDefault();
    
    const submitButton = $('#kt_payment_submit');
    const indicator = submitButton.find('.indicator-label');
    const progress = submitButton.find('.indicator-progress');
    
    // Disable button and show progress
    submitButton.prop('disabled', true);
    indicator.addClass('d-none');
    progress.removeClass('d-none');
    
    const formData = {
        order_id: $('#payment_order_id').val(),
        payment_method: $('#payment_method').val(),
        amount: $('#payment_amount').val(),
        discount: $('#payment_discount').val(),
        final_amount: $('#payment_final_amount').val(),
        transaction_id: $('#payment_transaction_id').val()
    };
    
    // Build payment URL
    let paymentUrl;
    if (typeof PROCESS_PAYMENT_URL !== 'undefined') {
        paymentUrl = PROCESS_PAYMENT_URL;
    } else {
        paymentUrl = ORIGIN_URL + '/order/process-payment';
    }
    
    $.ajax({
        url: paymentUrl,
        method: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            if (response.success) {
                toastr.success(response.message || 'Payment processed successfully!');
                $('#kt_payment_modal').modal('hide');
                table.draw(); // Refresh table
            } else {
                toastr.error(response.message || 'Payment processing failed.');
            }
        },
        error: function(xhr) {
            let errorMessage = 'Payment processing failed.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            toastr.error(errorMessage);
        },
        complete: function() {
            // Re-enable button
            submitButton.prop('disabled', false);
            indicator.removeClass('d-none');
            progress.addClass('d-none');
        }
    });
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

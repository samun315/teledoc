// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

let search = $("#search");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/schedule";
const ORIGIN_URL = window.location.origin;

let validate = selectedForm.validate({
    rules: {
        name: "required",
    },
    onsubmit: true,
});

$(".doctorDiv").hide();
$(".noDoctorDiv").hide();

$("#kt_doctor_id").on("change", function () {
    let doctorId = $(this).val();

    if (!doctorId) {
        $(".doctorDiv").hide(); // select khali thakle hide
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

                $(".doctorDiv").show();
            } else {
                $(".noDoctorDiv").show();
            }
        },
        error: function () {
            $(".noDoctorDiv").show();
        }
    });
});

// fetch the data
let table = $("#kt_schedule_table").DataTable({
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
            data: "contact_info",
            name: "contact_info",
        },
        {
            data: "days",
            name: "days",
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


$(document).on("click", '.showDetailsBtn', function () {
    let doctor = $(this).data('doctor');
    let schedules = $(this).data('schedules').split(';;');
    let html = `<div class="row g-3">`; // ekbar row start
    let count = 1;

    schedules.forEach(s => {
        if (s.trim() === "") return;
        let [day, start, end, minutes] = s.split('||');
        let startTime = moment(start, "HH:mm:ss").format("h:mm A");
        let endTime = moment(end, "HH:mm:ss").format("h:mm A");
        let slotText = minutes < 60 ? `${minutes} minutes` :
            `${Math.floor(minutes / 60)} hr ${minutes % 60 > 0 ? minutes % 60 + ' min' : ''}`;

        html += `
        <div class="col-md-4 position-relative">
            <div class="card shadow-sm">
                <div class="position-absolute top-0 end-0 p-2 badge bg-success">Schedule: ${count}</div>
                <div class="card-body p-3">
                    <p class="mb-1"><strong>Day:</strong> ${day}</p>
                    <p class="mb-1"><strong>Start:</strong> <span class="text-primary">${startTime}</span></p>
                    <p class="mb-1"><strong>End:</strong> <span class="text-danger">${endTime}</span></p>
                    <p class="mb-0"><strong>Slot:</strong> <span class="text-success">${slotText}</span></p>
                </div>
            </div>
        </div>`;

        count++;
    });

    html += `</div>`; // row close

    $('#showScheduleDetailsModal .modal-title').text("Schedules for " + doctor);
    $("#showScheduleDetailsModal .modal-body").html(html);
    $("#showScheduleDetailsModal").modal("show");
});


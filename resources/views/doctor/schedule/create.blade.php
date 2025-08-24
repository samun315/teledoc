@extends('master')

@section('title', 'Schedule Create')
@section('content')
    <x-toolbar-component title="Schedule Create" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Schedule', 'url' => route('schedule.create')],
        ['label' => 'Schedule Create', 'active' => true],
    ]" actionUrl="{{ route('schedule.index') }}"
        actionIcon="fas fa-plus-circle" actionLabel="Schedule List" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                @include('message')

                @if (session('general'))
                    <div class="alert alert-danger d-flex justify-content-between align-items-center col-md-12">
                        <span>{{ session('general') }}</span>
                        <button type="button" class="btn btn-sm btn-icon btn-danger ms-2" data-bs-dismiss="alert"
                            aria-label="Close">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <form method="POST" action="{{ route('schedule.store') }}" id="scheduleForm">
                    @csrf

                    <div class="row p-3 mb-5">
                        <div class="col-md-6">
                            <label class="fs-5 fw-bold mb-2">Doctor</label>
                            <select id="kt_doctor_id" name="doctor_id"
                                class="form-select form-select-light @error('doctor_id') is-invalid @enderror"
                                data-control="select2" data-placeholder="Select Doctor" required>
                                <option value=""></option>
                                @foreach ($doctorInfos as $doctorInfo)
                                    <option {{ old('doctor_id') ? 'selected' : '' }}
                                        value="{{ $doctorInfo->doctor_id ?? old('doctor_id') }}">
                                        {{ $doctorInfo->title }} {{ $doctorInfo->name }}</option>
                                @endforeach
                            </select>
                            @error('doctor_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 doctorDiv">
                            <div class="card shadow-sm text-center p-3">
                                <img id="kt_doctor_image" class="rounded-circle mb-2 mx-auto d-block" width="100"
                                    height="100" alt="Doctor Avatar">

                                <h5 class="fw-bold mb-1" id="kt_doctor_name"></h5>
                                <p class="mb-1" id="kt_doctor_department"><strong>Department:</strong></p>
                                <p class="mb-1" id="kt_doctor_phone"><strong>Phone:</strong></p>
                                <p class="mb-1" id="kt_doctor_email"><strong>Email:</strong></p>
                                <p class="mb-0" id="kt_doctor_address"><strong>Address:</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6 card text-center p-10 noDoctorDiv">
                            <p class="mb-1 text-danger"><strong>No Data Found For this Doctor</strong></p>
                        </div>
                    </div>

                    <div class="row p-3">
                        <!-- Days Table -->
                        <h5 class="fw-bold p-3">Days</h5>
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle gy-4">
                                <thead class="bg-info">
                                    <tr class="text-white text-uppercase fw-bolder fs-7">
                                        <th class="ps-2 rounded-start">Day</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Slot Duration (Minute)</th>
                                        <th class="rounded-end"></th>
                                    </tr>
                                </thead>
                                <tbody id="daysTable">
                                    <tr>
                                        <td>
                                            <select name="day_of_week[]" class="form-select form-select-light dayOfWeek"
                                                data-control="select2" data-placeholder="Select Day">
                                                <option value=""></option>
                                                @foreach ($days as $day)
                                                    <option value="{{ $day }}"
                                                        {{ old('day_of_week') == $day ? 'selected' : '' }}>
                                                        {{ $day }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="start_time[]"
                                                    class="form-control form-control-light timepicker start_time"
                                                    placeholder="--:-- --">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="end_time[]"
                                                    class="form-control form-control-light timepicker end_time"
                                                    placeholder="--:-- --">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" name="slot_duration_minutes[]" min="1"
                                                class="form-control form-control-light slotTime"
                                                placeholder="Slot Duration (Minute)">
                                        </td>
                                        <td></td>
                                    </tr>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success" id="addMore"><i class="fas fa-plus"></i>
                                Add
                                More</button>
                        </div>
                    </div>
                    <!--end::Card body-->

                    <div class="p-5 text-end">
                        <button type="submit" class="btn btn-success btn-sm" id="btnScheduleSubmit">Submit</button>
                    </div>
                </form>
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>
@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/doctor/schedule/index.js') }}"
        {{ Sri::html('assets/custom/js/doctor/schedule/index.js') }}></script>
    <!--end::Page Custom Stylesheets(used by this page)-->


    <script nonce="{{ $cspNonce }}">
        function initTimePickers() {
            $(".timepicker").flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "h:i K"
            });
        }
        $(document).ready(function() {
            initTimePickers();

            $("#addMore").click(function() {

                let isValid = true;

                // Loop through all existing rows
                $("#daysTable tr").each(function() {
                    $(this).find(
                            "select.dayOfWeek, input.start_time, input.end_time, input.slotTime")
                        .each(function() {
                            if (!$(this).val()) {
                                isValid = false;
                                $(this).addClass("is-invalid"); // Bootstrap red border
                            } else {
                                $(this).removeClass("is-invalid");
                            }
                        });
                });

                if (!isValid) {
                    toastr.warning("Please fill all fields before adding more.");
                    return; // Stop if validation fails
                }

                let row = `
                <tr>
                    <td>
                        <select name="day_of_week[]" class="form-select form-select-light dayOfWeek"
                            data-control="select2" data-placeholder="Select Day">
                            <option value=""></option>
                            @foreach ($days as $day)
                                <option value="{{ $day }}"
                                    {{ old('day_of_week') == $day ? 'selected' : '' }}>
                                    {{ $day }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                       <div class="input-group">
                            <input type="text" name="start_time[]"
                                class="form-control form-control-light timepicker start_time"
                                placeholder="--:-- --">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" name="end_time[]"
                                class="form-control form-control-light timepicker end_time"
                                placeholder="--:-- --">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        </div>
                    </td>
                    <td>
                       <input type="number" name="slot_duration_minutes[]"
                        class="form-control form-control-light slotTime"
                        placeholder="Slot Duration (Minute)" min="1">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm removeScheduleRow"><i class="fas fa-times"></i></button>
                    </td>
                </tr>
            `;
                $("#daysTable").append(row);

                $(".dayOfWeek").select2();
                initTimePickers();
            });

            $(document).on("click", ".removeScheduleRow", function() {
                $(this).closest("tr").remove();
            });

            // Start time input change

            $(document).on("change", "input.start_time", function() {
                let row = $(this).closest("tr");
                let day = row.find("select.dayOfWeek").val();
                let start = $(this).val();
                let end = row.find("input.end_time").val();

                if (!day || !start) return;

                let newStart = convertToMinutes(start);
                let conflict = false;

                $("#scheduleForm tbody tr").not(row).each(function() {
                    let otherDay = $(this).find("select.dayOfWeek").val();
                    let otherStart = $(this).find("input.start_time").val();
                    let otherEnd = $(this).find("input.end_time").val();

                    if (day === otherDay && otherStart && otherEnd) {
                        let otherStartMin = convertToMinutes(otherStart);
                        let otherEndMin = convertToMinutes(otherEnd);

                        // নতুন start_time অবশ্যই আগের end_time থেকে >1 মিনিট পর হতে হবে
                        if (newStart <= otherEndMin) {
                            conflict = true;
                            toastr.error(
                                `Same day: Start time must be after previous end time (${formatTime(otherEndMin + 1)})`
                            );
                            $(row).find("input.start_time").addClass("is-invalid");
                            return false; // break loop
                        }
                    }
                });

                if (!conflict) {
                    $(row).find("input.start_time").removeClass("is-invalid");
                }
            });

            // End time input change
            $(document).on("change", "input.end_time", function() {
                let row = $(this).closest("tr");
                let day = row.find("select.dayOfWeek").val();
                let start = row.find("input.start_time").val();
                let end = $(this).val();

                if (!day || !start || !end) return;

                let newStart = convertToMinutes(start);
                let newEnd = convertToMinutes(end);
                let conflict = false;

                $("#scheduleForm tbody tr").not(row).each(function() {
                    let otherDay = $(this).find("select.dayOfWeek").val();
                    let otherStart = $(this).find("input.start_time").val();
                    let otherEnd = $(this).find("input.end_time").val();

                    if (day === otherDay && otherStart && otherEnd) {
                        let otherStartMin = convertToMinutes(otherStart);
                        let otherEndMin = convertToMinutes(otherEnd);

                        // নতুন end_time অবশ্যই আগের start–end range এর বাইরে হতে হবে
                        if (newEnd <= otherEndMin && newEnd > otherStartMin) {
                            conflict = true;
                            toastr.error(`Same day: End time overlaps previous slot!`);
                            $(row).find("input.end_time").addClass("is-invalid");
                            return false; // break loop
                        }
                    }
                });

                if (!conflict) {
                    $(row).find("input.end_time").removeClass("is-invalid");
                }
            });

            // Helper: convert "h:i K" to minutes
            function convertToMinutes(timeStr) {
                if (!timeStr) return 0;
                let parts = timeStr.match(/(\d+):(\d+)\s*(AM|PM)/i);
                if (!parts) return 0;

                let hours = parseInt(parts[1], 10);
                let minutes = parseInt(parts[2], 10);
                let period = parts[3].toUpperCase();

                if (period === "PM" && hours !== 12) hours += 12;
                if (period === "AM" && hours === 12) hours = 0;

                return hours * 60 + minutes;
            }

            // Helper: convert minutes back to "h:i AM/PM" format for message
            function formatTime(minutes) {
                let h = Math.floor(minutes / 60);
                let m = minutes % 60;
                let period = h >= 12 ? "PM" : "AM";
                if (h > 12) h -= 12;
                if (h === 0) h = 12;
                return `${h}:${m.toString().padStart(2,"0")} ${period}`;
            }
        });


        $("#scheduleForm").on("submit", function(e) {
            let validRowFound = false;

            $("#scheduleForm tbody tr").each(function() {
                let day = $(this).find("select[name='day_of_week[]']").val().trim();
                let start = $(this).find("input[name='start_time[]']").val().trim();
                let end = $(this).find("input[name='end_time[]']").val().trim();
                let duration = $(this).find("input[name='slot_duration_minutes[]']").val().trim();

                if (day && start && end && duration) {
                    validRowFound = true;
                    return false; // break loop (কমপক্ষে একটা row পেলেই আর খোঁজা লাগবে না)
                }
            });

            if (!validRowFound) {
                e.preventDefault();
                toastr.error("At least one row must be fully filled before submitting!");
                return false;
            }
        });

           $(document).on("input", 'input[type="number"]', function () {
        let value = parseFloat($(this).val());
        if (value < 0) {
            $(this).val(Math.abs(value));
        }
    });

    // Optional: Prevent typing minus key
    $(document).on("keypress", 'input[type="number"]', function (e) {
        if (e.key === "-" || e.keyCode === 45) {
            e.preventDefault();
        }
    });
    </script>

@endsection

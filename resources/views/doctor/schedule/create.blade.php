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

                <form method="POST" action="{{ route('schedule.store') }}" id="scheduleForm">
                    @csrf

                    <div class="row p-3 mb-5">
                        <div class="col-md-6">
                            <label class="fs-5 fw-bold mb-2">Doctor</label>
                            <select id="kt_doctor_id" name="doctor_id"
                                class="form-select form-select-light @error('doctor_id') is-invalid @enderror"
                                data-control="select2" data-placeholder="Select Doctor">
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
                                <p class="mb-1" id="kt_doctor_phone"><strong>Phone:</strong></p>
                                <p class="mb-1" id="kt_doctor_email"><strong>Email:</strong></p>
                                <p class="mb-0" id="kt_doctor_address"><strong>Address:</strong></p>
                            </div>
                        </div>
                    </div>

                    <div class="row p-3">
                        <!-- Days Table -->
                        <h5 class="fw-bold p-3">Days</h5>
                        <div class="table-responsive">
                            <table class="table table-row-dashed align-middle gs-0 gy-4">
                                <thead>
                                    <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                        <th>Day</th>
                                        <th>Start Time</th>
                                        <th>End Time</th>
                                        <th>Slot Duration (Minute)</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="daysTable">
                                    <tr>
                                        <td>
                                            <select name="day_of_week" class="form-select form-select-light dayOfWeek"
                                                data-control="select2" data-placeholder="Select Doctor">
                                                <option value=""></option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="start_time"
                                                    class="form-control form-control-light timepicker start_time"
                                                    placeholder="--:-- --">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="end_time"
                                                    class="form-control form-control-light timepicker end_time"
                                                    placeholder="--:-- --">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" name="slot_duration_minutes"
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
                        <select name="day_of_week" class="form-select form-select-light dayOfWeek"
                            data-control="select2" data-placeholder="Select Doctor">
                            <option value=""></option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                    </td>
                    <td>
                       <div class="input-group">
                            <input type="text" name="start_time"
                                class="form-control form-control-light timepicker start_time"
                                placeholder="--:-- --">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <input type="text" name="end_time"
                                class="form-control form-control-light timepicker end_time"
                                placeholder="--:-- --">
                            <span class="input-group-text"><i class="fas fa-clock"></i></span>
                        </div>
                    </td>
                    <td>
                       <input type="number" name="slot_duration_minutes"
                        class="form-control form-control-light slotTime"
                        placeholder="Slot Duration (Minute)">
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
        });
    </script>

@endsection

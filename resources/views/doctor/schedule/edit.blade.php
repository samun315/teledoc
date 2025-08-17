@extends('master')

@section('title', 'Schedule Edit')
@section('content')
    <x-toolbar-component title="Schedule Edit" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Drug & Others', 'url' => 'javascript:void(0)'],
        ['label' => 'Schedule', 'url' => route('schedule.index')],
        ['label' => 'Schedule Edit', 'active' => true],
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

                <form method="POST" action="{{ route('schedule.update', $editModeData?->schedule_id) }}" id="scheduleForm">
                    @csrf

                    @isset($editModeData)
                        @method('PUT')
                    @endisset

                    <input type="text" hidden value="{{$editModeData->schedule_id}}" name="schedule_id">
                    <div class="row p-3 mb-5">
                        <div class="col-md-6">
                            <label class="fs-5 fw-bold mb-2">Doctor</label>
                            <input type="text" class="form-control form-control" value="{{$editModeData->doctor?->title }} {{$editModeData->doctor?->name }}" disabled>
                            <input type="hidden" name="doctor_id" class="form-control form-control" value="{{$editModeData->doctor_id }}">
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm text-center p-3">
                                <img src="{{ $editModeData?->doctor?->photo
                                    ? asset('uploads/doctor/' . $editModeData->doctor->photo)
                                    : asset('assets/media/avatars/blank.png') }}"
                                    class="rounded-circle mb-2 mx-auto d-block" width="100" height="100"
                                    alt="Doctor Avatar">

                                <h5 class="fw-bold mb-1">{{ $editModeData?->doctor?->title }}
                                    {{ $editModeData?->doctor?->name }}</h5>
                                <p class="mb-1"><strong>Department :</strong>
                                    {{ $editModeData?->doctor?->department?->department_name ?? 'N/A' }}</p>
                                <p class="mb-1"><strong>Phone :</strong>{{ $editModeData?->doctor?->phone }}</p>
                                <p class="mb-1"><strong>Email: </strong>{{ $editModeData?->doctor?->email }}</p>
                                <p class="mb-0"><strong>Address :</strong>{{ $editModeData?->doctor?->address }}</p>
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
                                        <th class="rounded-end">Slot Duration (Minute)</th>
                                    </tr>
                                </thead>
                                <tbody id="daysTable">
                                    <tr>
                                        <td>
                                            <select name="day_of_week[]" class="form-select form-select-light dayOfWeek"
                                                data-control="select2" data-placeholder="Select Doctor">
                                                <option value=""></option>
                                                @foreach ($days as $day)
                                                    <option value="{{ $day }}"
                                                        {{ old('day_of_week', $editModeData->day_of_week ?? '') == $day ? 'selected' : '' }}>
                                                        {{ $day }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="start_time[]" value="{{$editModeData->start_time}}"
                                                    class="form-control form-control-light timepicker start_time"
                                                    placeholder="--:-- --">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="input-group">
                                                <input type="text" name="end_time[]" value="{{$editModeData->end_time}}"
                                                    class="form-control form-control-light timepicker end_time"
                                                    placeholder="--:-- --">
                                                <span class="input-group-text"><i class="fas fa-clock"></i></span>
                                            </div>
                                        </td>
                                        <td>
                                            <input type="number" name="slot_duration_minutes[]" value="{{$editModeData->slot_duration_minutes}}"
                                                class="form-control form-control-light slotTime"
                                                placeholder="Slot Duration (Minute)">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--end::Card body-->

                    <div class="p-5 text-end">
                        <button type="submit" class="btn btn-success btn-sm" id="btnScheduleSubmit">Update</button>
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
    </script>

@endsection

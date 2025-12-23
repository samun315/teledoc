@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-one">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Schedule Your Appointment</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Appointment</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Appointment Booking Wizard -->
    <div class="appointment-booking-area pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-12">
                    <!-- Header -->
                    <div class="appointment-header text-center mb-5">
                        <h2>Schedule Your Appointment</h2>
                        <p>Follow the simple steps below to book your appointment with one of our qualified doctors.</p>
                    </div>

                    <!-- Progress Steps -->
                    <div class="appointment-progress mb-5">
                        <div class="progress-steps-container">
                            <div class="progress-step-wrapper">
                                <div class="progress-step" id="step-1-indicator">
                                    <div class="step-connector step-connector-right"></div>
                                    <div class="step-icon-wrapper">
                                        <div class="step-icon">
                                            <i class="icofont-user step-icon-default"></i>
                                            <i class="icofont-check step-icon-check" style="display: none;"></i>
                                        </div>
                                        <div class="step-number-badge">1</div>
                                    </div>
                                    <div class="step-content">
                                        <h4>Select Doctor</h4>
                                        <p>Choose your preferred doctor</p>
                                    </div>
                                </div>
                            </div>

                            <div class="progress-step-wrapper">
                                <div class="progress-step" id="step-2-indicator">
                                    <div class="step-connector step-connector-left"></div>
                                    <div class="step-connector step-connector-right"></div>
                                    <div class="step-icon-wrapper">
                                        <div class="step-icon">
                                            <i class="icofont-calendar step-icon-default"></i>
                                            <i class="icofont-check step-icon-check" style="display: none;"></i>
                                        </div>
                                        <div class="step-number-badge">2</div>
                                    </div>
                                    <div class="step-content">
                                        <h4>Date & Time</h4>
                                        <p>Pick appointment slot</p>
                                    </div>
                                </div>
                            </div>

                            <div class="progress-step-wrapper">
                                <div class="progress-step" id="step-3-indicator">
                                    <div class="step-connector step-connector-left"></div>
                                    <div class="step-icon-wrapper">
                                        <div class="step-icon">
                                            <i class="icofont-file-text step-icon-default"></i>
                                            <i class="icofont-check step-icon-check" style="display: none;"></i>
                                        </div>
                                        <div class="step-number-badge">3</div>
                                    </div>
                                    <div class="step-content">
                                        <h4>Patient Details</h4>
                                        <p>Enter your information</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step 1: Select Doctor -->
                    <div class="appointment-step" id="step-1">
                        <div class="step-header mb-4">
                            <h3><span class="step-number">1</span> Select Your Doctor</h3>
                        </div>

                        <!-- Search and Filter -->
                        <div class="doctor-search-section mb-4">
                            <div class="search-header">
                                <div class="search-header-icon">
                                    <i class="icofont-search-1"></i>
                                </div>
                                <div class="search-header-content">
                                    <h4>Find Your Doctor</h4>
                                    <p>Search by name, department, or specialty</p>
                                </div>
                            </div>

                            <div class="search-filters">
                                <div class="row g-3">
                                    <div class="col-md-8">
                                        <div class="search-input-wrapper">
                                            <div class="input-icon-wrapper">
                                                <i class="icofont-search-1"></i>
                                            </div>
                                            <input type="text" id="doctor-search" class="form-control search-input" placeholder="Search doctors by name, department, or specialty...">
                                            <button type="button" class="search-clear-btn" id="clear-search" style="display: none;">
                                                <i class="icofont-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="filter-input-wrapper">
                                            <div class="input-icon-wrapper">
                                                <i class="icofont-hospital"></i>
                                            </div>
                                            <select id="department-filter" class="form-control filter-select">
                                                <option value="">All Departments</option>
                                                @foreach($departments as $department)
                                                    <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="search-results-info">
                                <div class="results-badge">
                                    <i class="icofont-doctor-alt"></i>
                                    <span class="results-text">
                                        <strong id="doctor-count">0</strong> doctors found
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Doctors Grid -->
                        <div class="doctors-grid" id="doctors-grid">
                            <!-- Doctors will be loaded here via AJAX -->
                        </div>
                    </div>

                    <!-- Step 2: Date & Time -->
                    <div class="appointment-step" id="step-2" style="display: none;">
                        <div class="step-header mb-4">
                            <h3><span class="step-number">2</span> Choose Date & Time</h3>
                        </div>

                        <div class="row">
                            <!-- Selected Doctor Card -->
                            <div class="col-lg-4 mb-4">
                                <div class="selected-doctor-card">
                                    <div class="card-header">
                                        <h4>Selected Doctor</h4>
                                        <div class="card-actions">
                                            <button type="button" class="btn-edit" id="edit-doctor" title="Edit">
                                                <i class="icofont-pencil-alt-2"></i>
                                            </button>
                                            <button type="button" class="btn-close-card" id="remove-doctor" title="Remove">
                                                <i class="icofont-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" id="selected-doctor-info">
                                        <!-- Selected doctor info will be shown here -->
                                    </div>
                                </div>
                            </div>

                            <!-- Calendar and Time Slots -->
                            <div class="col-lg-8">
                                <!-- Calendar -->
                                <div class="calendar-card mb-4">
                                    <div class="calendar-header">
                                        <button type="button" class="btn-nav" id="prev-month">
                                            <i class="icofont-simple-left"></i>
                                        </button>
                                        <h4 id="current-month-year"></h4>
                                        <button type="button" class="btn-nav" id="next-month">
                                            <i class="icofont-simple-right"></i>
                                        </button>
                                    </div>
                                    <div class="calendar-body">
                                        <div class="calendar-weekdays">
                                            <div>Sun</div>
                                            <div>Mon</div>
                                            <div>Tue</div>
                                            <div>Wed</div>
                                            <div>Thu</div>
                                            <div>Fri</div>
                                            <div>Sat</div>
                                        </div>
                                        <div class="calendar-days" id="calendar-days">
                                            <!-- Calendar days will be generated here -->
                                        </div>
                                    </div>
                                    <div class="calendar-legend">
                                        <div class="legend-item">
                                            <span class="legend-color selected"></span>
                                            <span>Selected</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-color available"></span>
                                            <span>Available</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-color unavailable"></span>
                                            <span>Unavailable</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Time Slots -->
                                <div class="time-slots-card">
                                    <div class="time-slots-header">
                                        <h4><i class="icofont-clock-time"></i> Available Time Slots</h4>
                                        <span class="slots-count" id="slots-count">0 slots available</span>
                                    </div>
                                    <div class="selected-date-info" id="selected-date-info"></div>
                                    <div class="time-slots-grid" id="time-slots-grid">
                                        <div class="no-slots-message">
                                            <i class="icofont-clock-time"></i>
                                            <p>Please select a date first</p>
                                        </div>
                                    </div>
                                    <div class="time-slots-legend">
                                        <div class="legend-item">
                                            <span class="legend-color selected"></span>
                                            <span>Selected</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-color available"></span>
                                            <span>Available</span>
                                        </div>
                                        <div class="legend-item">
                                            <span class="legend-color booked"></span>
                                            <span>Booked</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="button" class="btn btn-primary btn-lg" id="proceed-to-step-3">Proceed to Patient Details</button>
                        </div>
                    </div>

                    <!-- Step 3: Patient Details -->
                    <div class="appointment-step" id="step-3" style="display: none;">
                        <div class="step-header mb-4">
                            <h3><span class="step-number">3</span> Enter Patient Details</h3>
                        </div>

                        <div class="row">
                            <!-- Left Column: Selected Doctor & Summary -->
                            <div class="col-lg-4 mb-4">
                                <!-- Selected Doctor Card -->
                                <div class="selected-doctor-card">
                                    <div class="card-header">
                                        <h4>Selected Doctor</h4>
                                        <div class="card-actions">
                                            <button type="button" class="btn-edit" id="edit-doctor-step3" title="Edit">
                                                <i class="icofont-pencil-alt-2"></i>
                                            </button>
                                            <button type="button" class="btn-close-card" id="remove-doctor-step3" title="Remove">
                                                <i class="icofont-close"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="card-body" id="selected-doctor-info-step3">
                                        <!-- Selected doctor info will be shown here -->
                                    </div>
                                </div>

                                <!-- Appointment Summary -->
                                <div class="appointment-summary-card">
                                    <div class="card-header">
                                        <h4>Appointment Summary</h4>
                                    </div>
                                    <div class="card-body" id="appointment-summary">
                                        <!-- Summary will be shown here -->
                                    </div>
                                    <div class="card-footer">
                                        <a href="#" class="change-link" id="change-datetime">Change Date/Time</a>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column: Patient Information Form -->
                            <div class="col-lg-8">
                                <div class="patient-info-card">
                                    <div class="card-header">
                                        <h4>Patient Information</h4>
                                        <a href="#" class="account-link" id="have-account-link" style="display: none;">I have an account</a>
                                    </div>
                                    <div class="card-body">
                                        <!-- Guest/Registered Patient Banner -->
                                        <div class="patient-status-banner" id="patient-status-banner">
                                            <div class="alert alert-info">
                                                <i class="icofont-info-circle"></i>
                                                <strong>Guest Booking</strong>
                                                <p>Please fill in your details to continue</p>
                                            </div>
                                        </div>

                                        <!-- Patient Form -->
                                        <form id="patient-form">
                                            <input type="hidden" id="selected-doctor-id" name="doctor_id">
                                            <input type="hidden" id="selected-date" name="appointment_date">
                                            <input type="hidden" id="selected-slot-id" name="slot_id">
                                            <input type="hidden" id="selected-slot-time" name="slot_time">
                                            <input type="hidden" id="is-registered" name="is_registered" value="0">
                                            <input type="hidden" id="patient-id" name="patient_id">

                                            <div class="form-group">
                                                <label>Full Name <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="icofont-user"></i></span>
                                                    <input type="text" class="form-control" id="patient-name" name="patient_name" placeholder="Enter your full name" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Phone Number <span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="icofont-ui-call"></i></span>
                                                    <input type="text" class="form-control" id="patient-phone" name="patient_phone" placeholder="Enter your phone number" required>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Email Address <span class="text-muted">(Optional)</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="icofont-ui-message"></i></span>
                                                    <input type="email" class="form-control" id="patient-email" name="patient_email" placeholder="Enter your email address">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label>Additional Notes <span class="text-muted">(Optional)</span></label>
                                                <div class="input-group">
                                                    <span class="input-group-text"><i class="icofont-file-text"></i></span>
                                                    <textarea class="form-control" id="additional-notes" name="additional_notes" rows="4" placeholder="Any specific concerns or symptoms you'd like to mention..."></textarea>
                                                </div>
                                            </div>

                                            <div class="text-center mt-4">
                                                <button type="submit" class="btn btn-primary btn-lg btn-block" id="confirm-booking">
                                                    <i class="icofont-check-circled"></i> Confirm Booking
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Appointment Booking Wizard -->
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/appointment.css') }}">
@endpush

@section('page_script')
<!-- Configuration for appointment booking -->
<script nonce="{{ $cspNonce }}">
    // Pass configuration and data from Blade to JavaScript
    window.appointmentConfig = {
        getDoctorsUrl: '{{ route("appointment.get-doctors") }}',
        getSlotsUrl: '{{ url("appointment/get-available-slots") }}',
        storeUrl: '{{ route("appointment.store") }}',
        homeUrl: '{{ route("home") }}',
        csrfToken: '{{ csrf_token() }}'
    };

    @if($selectedDoctor)
    window.selectedDoctorData = {
        doctor_id: {{ $selectedDoctor->doctor_id }},
        name: '{{ addslashes($selectedDoctor->name) }}',
        title: '{{ addslashes($selectedDoctor->title) }}',
        photo: '{{ $selectedDoctor->photo ? asset("uploads/doctor/" . $selectedDoctor->photo) : asset("assets/img/home-one/doctor/1.jpg") }}',
        department: '{{ addslashes($selectedDoctor->department->department_name ?? "General") }}',
        email: '{{ addslashes($selectedDoctor->email) }}',
        phone: '{{ addslashes($selectedDoctor->phone) }}',
        address: '{{ addslashes($selectedDoctor->address ?? "") }}',
        description: '{{ addslashes($selectedDoctor->description ?? "") }}'
    };
    @else
    window.selectedDoctorData = null;
    @endif
</script>
<script src="{{ asset('frontend/assets/js/appointment.js') }}"></script>
@endsection

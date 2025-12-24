$(document).ready(function() {
    // Get configuration from global variables set by Blade
    const config = window.appointmentConfig || {};
    const selectedDoctorData = window.selectedDoctorData || null;

    // Initialize appointment booking
    const appointmentBooking = {
        currentStep: 1,
        selectedDoctor: null,
        selectedDate: null,
        selectedSlot: null,
        currentMonth: new Date().getMonth(),
        currentYear: new Date().getFullYear(),

        init: function() {
            this.loadDoctors();
            this.initEventListeners();
            this.updateProgressIndicator();
            this.initCalendar();

            // If doctor is pre-selected (from URL parameter)
            if (selectedDoctorData) {
                this.selectDoctor(selectedDoctorData);
                this.goToStep(2);
            }
        },

        initEventListeners: function() {
            // Doctor search
            $('#doctor-search').on('keyup', (e) => {
                this.toggleClearButton();
                this.debounce(() => this.loadDoctors(), 500)();
            });

            // Clear search button
            $('#clear-search').on('click', () => {
                $('#doctor-search').val('');
                $('#clear-search').hide();
                this.loadDoctors();
            });

            $('#department-filter').on('change', () => this.loadDoctors());

            // Step navigation
            $('#edit-doctor, #edit-doctor-step3').on('click', () => this.goToStep(1));
            $('#remove-doctor, #remove-doctor-step3').on('click', () => this.clearSelection());
            $('#change-datetime').on('click', (e) => {
                e.preventDefault();
                this.goToStep(2);
            });

            // Calendar navigation
            $('#prev-month').on('click', () => this.navigateMonth(-1));
            $('#next-month').on('click', () => this.navigateMonth(1));

            // Form submission
            $('#patient-form').on('submit', (e) => this.handleFormSubmit(e));
            $('#registered-patient-form').on('submit', (e) => this.handleFormSubmit(e));

            // Registered patient toggle (toggles between guest and registered)
            $('#registered-patient-btn').on('click', () => this.togglePatientType());
        },

        loadDoctors: function() {
            const search = $('#doctor-search').val();
            const departmentId = $('#department-filter').val();

            $.ajax({
                url: config.getDoctorsUrl || '/appointment/get-doctors',
                method: 'GET',
                data: {
                    search: search,
                    department_id: departmentId
                },
                success: (response) => {
                    if (response.success) {
                        this.renderDoctors(response.doctors);
                        $('#doctor-count').text(response.doctors.length);
                    }
                },
                error: () => {
                    $('#doctors-grid').html('<div class="col-12 text-center"><p class="text-danger">Error loading doctors. Please try again.</p></div>');
                }
            });
        },

        renderDoctors: function(doctors) {
            let html = '<div class="row">';

            if (doctors.length === 0) {
                html += '<div class="col-12 text-center py-5"><p class="text-muted">No doctors found matching your criteria.</p></div>';
            } else {
                doctors.forEach((doctor, index) => {
                    html += `
                        <div class="col-md-4 mb-4">
                            <div class="doctor-card">
                                <div class="doctor-image">
                                    <img src="${doctor.photo}" alt="${doctor.name}">
                                </div>
                                <div class="doctor-info">
                                    <h4>${doctor.title} ${doctor.name}</h4>
                                    <p class="specialty">${doctor.department}</p>
                                    <div class="doctor-contact">
                                        <p><i class="icofont-ui-message"></i> ${doctor.email || 'N/A'}</p>
                                        <p><i class="icofont-location-pin"></i> ${doctor.address || 'N/A'}</p>
                                    </div>
                                    <button type="button" class="btn btn-primary btn-sm btn-block select-doctor-btn" data-doctor-id="${doctor.doctor_id}" data-doctor-index="${index}">
                                        Select Doctor
                                    </button>
                                </div>
                            </div>
                        </div>
                    `;
                });
            }

            html += '</div>';
            $('#doctors-grid').html(html);

            // Store doctors data in a variable accessible to click handler
            window.appointmentDoctorsData = doctors;

            // Attach click handlers using event delegation
            const self = this;
            $(document).off('click', '.select-doctor-btn').on('click', '.select-doctor-btn', function(e) {
                e.preventDefault();
                const doctorId = $(this).data('doctor-id');
                const doctorIndex = $(this).data('doctor-index');

                if (window.appointmentDoctorsData && window.appointmentDoctorsData[doctorIndex]) {
                    const doctorData = window.appointmentDoctorsData[doctorIndex];
                    self.selectDoctor(doctorData);
                } else if (window.appointmentDoctorsData) {
                    // Fallback: find by ID
                    const doctorData = window.appointmentDoctorsData.find(d => d.doctor_id == doctorId);
                    if (doctorData) {
                        self.selectDoctor(doctorData);
                    } else {
                        alert('Error selecting doctor. Please try again.');
                    }
                } else {
                    alert('Error selecting doctor. Please try again.');
                }
            });
        },

        selectDoctor: function(doctor) {
            this.selectedDoctor = doctor;
            this.renderSelectedDoctor();
            this.goToStep(2);
        },

        renderSelectedDoctor: function() {
            const html = `
                <div class="doctor-profile">
                    <img src="${this.selectedDoctor.photo}" alt="${this.selectedDoctor.name}" class="doctor-avatar">
                    <h5>${this.selectedDoctor.title} ${this.selectedDoctor.name}</h5>
                    <p class="specialty">${this.selectedDoctor.department}</p>
                    <div class="doctor-contact-info">
                        <p><i class="icofont-ui-call"></i> ${this.selectedDoctor.phone || 'N/A'}</p>
                        <p><i class="icofont-location-pin"></i> ${this.selectedDoctor.address || 'N/A'}</p>
                    </div>
                </div>
            `;
            $('#selected-doctor-info, #selected-doctor-info-step3').html(html);
            $('#selected-doctor-id').val(this.selectedDoctor.doctor_id);
        },

        initCalendar: function() {
            this.renderCalendar();
        },

        renderCalendar: function() {
            const firstDay = new Date(this.currentYear, this.currentMonth, 1);
            const lastDay = new Date(this.currentYear, this.currentMonth + 1, 0);
            const daysInMonth = lastDay.getDate();
            const startingDayOfWeek = firstDay.getDay();

            // Update month/year header
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            $('#current-month-year').text(`${monthNames[this.currentMonth]} ${this.currentYear}`);

            let html = '';

            // Previous month's trailing days
            const prevMonth = new Date(this.currentYear, this.currentMonth, 0);
            const daysInPrevMonth = prevMonth.getDate();
            for (let i = startingDayOfWeek - 1; i >= 0; i--) {
                const date = daysInPrevMonth - i;
                html += `<div class="calendar-day other-month" data-date="${prevMonth.getFullYear()}-${String(prevMonth.getMonth() + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}">${date}</div>`;
            }

            // Current month's days
            const today = new Date();
            for (let date = 1; date <= daysInMonth; date++) {
                const dateStr = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                const isToday = today.toDateString() === new Date(this.currentYear, this.currentMonth, date).toDateString();
                const isPast = new Date(dateStr) < new Date(today.toDateString());
                const dayClass = isPast ? 'past' : (isToday ? 'today' : '');

                html += `<div class="calendar-day ${dayClass}" data-date="${dateStr}">${date}</div>`;
            }

            // Next month's leading days
            const totalCells = 42; // 6 weeks * 7 days
            const remainingCells = totalCells - (startingDayOfWeek + daysInMonth);
            const nextMonth = new Date(this.currentYear, this.currentMonth + 1, 1);
            for (let date = 1; date <= remainingCells; date++) {
                const dateStr = `${nextMonth.getFullYear()}-${String(nextMonth.getMonth() + 1).padStart(2, '0')}-${String(date).padStart(2, '0')}`;
                html += `<div class="calendar-day other-month" data-date="${dateStr}">${date}</div>`;
            }

            $('#calendar-days').html(html);

            // Attach click handlers
            $('.calendar-day:not(.past):not(.other-month)').on('click', (e) => {
                const date = $(e.currentTarget).data('date');
                this.selectDate(date);
            });
        },

        navigateMonth: function(direction) {
            this.currentMonth += direction;
            if (this.currentMonth < 0) {
                this.currentMonth = 11;
                this.currentYear--;
            } else if (this.currentMonth > 11) {
                this.currentMonth = 0;
                this.currentYear++;
            }
            this.renderCalendar();
        },

        selectDate: function(date) {
            this.selectedDate = date;
            $('.calendar-day').removeClass('selected');
            $(`.calendar-day[data-date="${date}"]`).addClass('selected');
            this.loadAvailableSlots(date);
        },

        loadAvailableSlots: function(date) {
            if (!this.selectedDoctor) return;

            const doctorId = this.selectedDoctor.doctor_id;
            const formattedDate = date;
            const baseUrl = config.getSlotsUrl || '/appointment/get-available-slots';

            $.ajax({
                url: `${baseUrl}/${doctorId}/${formattedDate}`,
                method: 'GET',
                success: (response) => {
                    if (response.success) {
                        this.renderTimeSlots(response.slots, formattedDate);
                        $('#selected-date').val(formattedDate);
                    } else {
                        $('#time-slots-grid').html(`<div class="no-slots-message"><p>${response.message}</p></div>`);
                        $('#slots-count').text('0 slots available');
                    }
                },
                error: () => {
                    $('#time-slots-grid').html('<div class="no-slots-message"><p>Error loading time slots. Please try again.</p></div>');
                }
            });
        },

        renderTimeSlots: function(slots, date) {
            const availableSlots = slots.filter(slot => !slot.is_booked);
            $('#slots-count').text(`${availableSlots.length} slots available`);

            const dateObj = new Date(date);
            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const formattedDate = `${dayNames[dateObj.getDay()]}, ${monthNames[dateObj.getMonth()]} ${dateObj.getDate()}, ${dateObj.getFullYear()}`;

            $('#selected-date-info').html(`<p><i class="icofont-calendar"></i> ${formattedDate}</p>`);

            let html = '';
            if (availableSlots.length === 0) {
                html = '<div class="no-slots-message"><p>No available slots for this date.</p></div>';
            } else {
                availableSlots.forEach(slot => {
                    html += `
                        <button type="button" class="time-slot-btn ${slot.is_booked ? 'booked' : ''}"
                                data-slot-id="${slot.slot_id}"
                                data-slot-time="${slot.start}"
                                ${slot.is_booked ? 'disabled' : ''}>
                            ${slot.start_formatted}
                        </button>
                    `;
                });
            }

            $('#time-slots-grid').html(html);

            // Attach click handlers
            const self = this;
            $('.time-slot-btn:not(.booked)').on('click', function(e) {
                const clickedSlot = $(this);
                const slotId = clickedSlot.data('slot-id');
                const slotTime = clickedSlot.data('slot-time');
                
                // Check if this slot is already selected
                if (clickedSlot.hasClass('selected')) {
                    // If already selected, show confirmation to proceed
                    self.showSlotConfirmation(slotId, slotTime, clickedSlot);
                } else {
                    // If not selected, select it first, then show confirmation
                    $('.time-slot-btn').removeClass('selected');
                    clickedSlot.addClass('selected');
                    self.selectedSlot = {
                        slot_id: slotId,
                        slot_time: slotTime
                    };
                    $('#selected-slot-id').val(self.selectedSlot.slot_id);
                    $('#selected-slot-time').val(self.selectedSlot.slot_time);
                    
                    // Show confirmation popup
                    self.showSlotConfirmation(slotId, slotTime, clickedSlot);
                }
            });
        },

        goToStep: function(step) {
            $('.appointment-step').hide();
            $(`#step-${step}`).show();
            this.currentStep = step;
            this.updateProgressIndicator();

            if (step === 2 && this.selectedDoctor) {
                this.renderSelectedDoctor();
            }

            if (step === 3) {
                this.renderAppointmentSummary();
            }
        },

        renderAppointmentSummary: function() {
            if (!this.selectedDoctor || !this.selectedDate || !this.selectedSlot) return;

            const dateObj = new Date(this.selectedDate);
            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const formattedDate = `${dayNames[dateObj.getDay()]}, ${monthNames[dateObj.getMonth()]} ${dateObj.getDate()}, ${dateObj.getFullYear()}`;

            const timeObj = new Date(`2000-01-01 ${this.selectedSlot.slot_time}`);
            const formattedTime = timeObj.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });

            const html = `
                <div class="summary-item">
                    <i class="icofont-calendar"></i>
                    <span>${formattedDate}</span>
                </div>
                <div class="summary-item">
                    <i class="icofont-clock-time"></i>
                    <span>${formattedTime}</span>
                </div>
            `;
            $('#appointment-summary').html(html);
        },

        updateProgressIndicator: function() {
            for (let i = 1; i <= 3; i++) {
                const indicator = $(`#step-${i}-indicator`);
                const stepIcon = indicator.find('.step-icon');
                const defaultIcon = stepIcon.find('.step-icon-default');
                const checkIcon = stepIcon.find('.step-icon-check');

                indicator.removeClass('active completed');

                if (i < this.currentStep) {
                    // Completed step - show checkmark
                    indicator.addClass('completed');
                    defaultIcon.hide();
                    checkIcon.show();
                } else if (i === this.currentStep) {
                    // Active step - show default icon
                    indicator.addClass('active');
                    defaultIcon.show();
                    checkIcon.hide();
                } else {
                    // Pending step - show default icon
                    defaultIcon.show();
                    checkIcon.hide();
                }
            }
        },

        clearSelection: function() {
            this.selectedDoctor = null;
            this.selectedDate = null;
            this.selectedSlot = null;
            this.goToStep(1);
        },

        togglePatientType: function() {
            const isRegisteredVisible = $('#registered-patient-section').is(':visible');
            const button = $('#registered-patient-btn');
            const buttonSpan = button.find('span');
            
            if (isRegisteredVisible) {
                // Switch to Guest Patient
                $('#registered-patient-section').slideUp(300);
                $('#guest-patient-section').slideDown(300);
                
                // Update button text and state
                button.removeClass('active');
                buttonSpan.html('I am a registered patient - Click here');
                
                // Update hidden field
                $('#is-registered').val('0');
                $('#registered-is-registered').val('0');
                
                // Clear registered patient fields
                $('#registered-patient-id').val('');
                $('#registered-patient-phone').val('');
                $('#registered-additional-notes').val('');
            } else {
                // Switch to Registered Patient
                $('#guest-patient-section').slideUp(300);
                $('#registered-patient-section').slideDown(300);
                
                // Update button text and state
                button.addClass('active');
                buttonSpan.html('Switch to Guest Booking - Click here');
                
                // Update hidden field
                $('#is-registered').val('1');
                $('#registered-is-registered').val('1');
                
                // Copy values to registered form hidden fields
                $('#registered-doctor-id').val($('#selected-doctor-id').val());
                $('#registered-date').val($('#selected-date').val());
                $('#registered-slot-id').val($('#selected-slot-id').val());
                $('#registered-slot-time').val($('#selected-slot-time').val());
            }
        },

        showSlotConfirmation: function(slotId, slotTime, slotElement) {
            const self = this;
            
            // Format the time for display
            const timeObj = new Date(`2000-01-01 ${slotTime}`);
            const formattedTime = timeObj.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            
            // Format the date for display
            const dateObj = new Date(this.selectedDate);
            const dayNames = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            const formattedDate = `${dayNames[dateObj.getDay()]}, ${monthNames[dateObj.getMonth()]} ${dateObj.getDate()}, ${dateObj.getFullYear()}`;
            
            // Update modal content
            $('#modal-date').text(formattedDate);
            $('#modal-time').text(formattedTime);
            
            // Show modal
            $('#slot-confirmation-modal').addClass('show');
            
            // Handle Yes button click
            $('#modal-btn-yes').off('click').on('click', function() {
                $('#slot-confirmation-modal').removeClass('show');
                self.goToStep(3);
            });
            
            // Handle No button click
            $('#modal-btn-no').off('click').on('click', function() {
                $('#slot-confirmation-modal').removeClass('show');
                slotElement.removeClass('selected');
                self.selectedSlot = null;
                $('#selected-slot-id').val('');
                $('#selected-slot-time').val('');
            });
            
            // Handle overlay click to close
            $('.modal-overlay').off('click').on('click', function() {
                $('#slot-confirmation-modal').removeClass('show');
                slotElement.removeClass('selected');
                self.selectedSlot = null;
                $('#selected-slot-id').val('');
                $('#selected-slot-time').val('');
            });
        },

        handleFormSubmit: function(e) {
            e.preventDefault();

            if (!this.selectedDoctor || !this.selectedDate || !this.selectedSlot) {
                alert('Please complete all previous steps.');
                return;
            }

            // Check if registered patient form is visible
            const isRegistered = $('#registered-patient-section').is(':visible');
            
            let formData;
            
            if (isRegistered) {
                // Registered patient form
                const patientId = $('#registered-patient-id').val();
                const patientPhone = $('#registered-patient-phone').val();
                
                // Validate: at least one field required
                if (!patientId && !patientPhone) {
                    alert('Please provide at least Patient ID or Phone Number to verify your account.');
                    return;
                }
                
                formData = {
                    doctor_id: $('#registered-doctor-id').val() || $('#selected-doctor-id').val(),
                    appointment_date: $('#registered-date').val() || $('#selected-date').val(),
                    slot_id: $('#registered-slot-id').val() || $('#selected-slot-id').val(),
                    slot_time: $('#registered-slot-time').val() || $('#selected-slot-time').val(),
                    patient_id: patientId || null,
                    patient_phone: patientPhone,
                    patient_name: '', // Will be fetched from database
                    patient_email: '',
                    additional_notes: $('#registered-additional-notes').val() || '',
                    is_registered: '1'
                };
            } else {
                // Guest patient form
                formData = {
                    doctor_id: $('#selected-doctor-id').val(),
                    appointment_date: $('#selected-date').val(),
                    slot_id: $('#selected-slot-id').val(),
                    slot_time: $('#selected-slot-time').val(),
                    patient_name: $('#patient-name').val(),
                    patient_phone: $('#patient-phone').val(),
                    patient_email: $('#patient-email').val(),
                    additional_notes: $('#additional-notes').val(),
                    is_registered: $('#is-registered').val(),
                    patient_id: $('#patient-id').val()
                };
            }

            // Disable submit button
            const submitButton = isRegistered ? $('#confirm-registered-booking') : $('#confirm-booking');
            submitButton.prop('disabled', true).html('<i class="icofont-spinner-alt-4"></i> Processing...');

            $.ajax({
                url: config.storeUrl || '/appointment/store',
                method: 'POST',
                data: formData,
                headers: {
                    'X-CSRF-TOKEN': config.csrfToken || $('meta[name="csrf-token"]').attr('content')
                },
                success: (response) => {
                    if (response.success) {
                        alert('Appointment booked successfully! Your appointment code is: ' + response.appointment_code);
                        window.location.href = config.homeUrl || '/';
                    } else {
                        alert('Error: ' + response.message);
                        submitButton.prop('disabled', false).html('<i class="icofont-check-circled"></i> Confirm Booking');
                    }
                },
                error: (xhr) => {
                    let errorMsg = 'An error occurred. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    alert(errorMsg);
                    submitButton.prop('disabled', false).html('<i class="icofont-check-circled"></i> Confirm Booking');
                }
            });
        },

            toggleClearButton: function() {
                const searchValue = $('#doctor-search').val();
                if (searchValue.length > 0) {
                    $('#clear-search').fadeIn(200);
                } else {
                    $('#clear-search').fadeOut(200);
                }
            },

            debounce: function(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }
        };

    // Initialize
    appointmentBooking.init();
});


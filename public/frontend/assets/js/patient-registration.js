// Patient Registration Form JavaScript

(function() {
    'use strict';

    // DOM Elements
    const registrationForm = document.getElementById('patient-registration-form');
    const dateOfBirthInput = document.getElementById('date_of_birth');
    const ageInput = document.getElementById('age');
    const photoInput = document.getElementById('photo');
    const photoPreview = document.getElementById('photo-preview');
    const photoPlaceholder = document.getElementById('photo-placeholder');
    const removePhotoBtn = document.getElementById('remove-photo');
    const togglePasswordBtn = document.getElementById('toggle-password');
    const togglePasswordConfirmationBtn = document.getElementById('toggle-password-confirmation');
    const passwordInput = document.getElementById('password');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const submitBtn = document.getElementById('submit-btn');

    // Calculate age from date of birth
    function calculateAge(dateOfBirth) {
        if (!dateOfBirth) {
            ageInput.value = '';
            return;
        }

        const birthDate = new Date(dateOfBirth);
        const today = new Date();
        
        let years = today.getFullYear() - birthDate.getFullYear();
        let months = today.getMonth() - birthDate.getMonth();
        let days = today.getDate() - birthDate.getDate();

        if (days < 0) {
            months--;
            const prevMonth = new Date(today.getFullYear(), today.getMonth(), 0);
            days += prevMonth.getDate();
        }

        if (months < 0) {
            years--;
            months += 12;
        }

        // Calculate fractional age
        const fractionalAge = years + months / 12 + days / 365;
        ageInput.value = fractionalAge >= 0 ? fractionalAge.toFixed(1) : '';
    }

    // Photo Preview Handler
    function handlePhotoPreview(event) {
        const file = event.target.files[0];
        
        if (file) {
            // Validate file size (2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('File size must be less than 2MB');
                photoInput.value = '';
                return;
            }

            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG or PNG)');
                photoInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
                photoPreview.style.display = 'block';
                photoPlaceholder.style.display = 'none';
                removePhotoBtn.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    // Remove Photo Handler
    function removePhoto() {
        photoInput.value = '';
        photoPreview.src = '';
        photoPreview.style.display = 'none';
        photoPlaceholder.style.display = 'flex';
        removePhotoBtn.style.display = 'none';
    }

    // Toggle Password Visibility
    function togglePasswordVisibility(input, icon) {
        const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
        input.setAttribute('type', type);
        
        // Toggle icon
        if (type === 'password') {
            icon.classList.remove('icofont-eye-blocked');
            icon.classList.add('icofont-eye');
        } else {
            icon.classList.remove('icofont-eye');
            icon.classList.add('icofont-eye-blocked');
        }
    }

    // Form Validation
    function validateForm() {
        const name = document.getElementById('name').value.trim();
        const phone = document.getElementById('phone').value.trim();
        const dateOfBirth = document.getElementById('date_of_birth').value;
        const password = passwordInput.value;
        const passwordConfirmation = passwordConfirmationInput.value;

        // Basic validation
        if (!name) {
            alert('Please enter your full name');
            return false;
        }

        if (!phone) {
            alert('Please enter your phone number');
            return false;
        }

        if (!dateOfBirth) {
            alert('Please select your date of birth');
            return false;
        }

        if (!password) {
            alert('Please enter a password');
            return false;
        }

        if (password.length < 6) {
            alert('Password must be at least 6 characters long');
            return false;
        }

        if (password !== passwordConfirmation) {
            alert('Password and confirmation password do not match');
            return false;
        }

        return true;
    }

    // Form Submission Handler
    function handleFormSubmit(event) {
        event.preventDefault();

        if (!validateForm()) {
            return;
        }

        // Disable submit button
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="icofont-spinner-alt icofont-spin"></i> Registering...';

        // Submit form
        registrationForm.submit();
    }

    // Event Listeners
    if (dateOfBirthInput) {
        dateOfBirthInput.addEventListener('change', function() {
            calculateAge(this.value);
        });

        // Calculate age on page load if date is already set
        if (dateOfBirthInput.value) {
            calculateAge(dateOfBirthInput.value);
        }
    }

    if (photoInput) {
        photoInput.addEventListener('change', handlePhotoPreview);
    }

    if (removePhotoBtn) {
        removePhotoBtn.addEventListener('click', removePhoto);
    }

    if (togglePasswordBtn) {
        togglePasswordBtn.addEventListener('click', function() {
            togglePasswordVisibility(passwordInput, document.getElementById('password-icon'));
        });
    }

    if (togglePasswordConfirmationBtn) {
        togglePasswordConfirmationBtn.addEventListener('click', function() {
            togglePasswordVisibility(passwordConfirmationInput, document.getElementById('password-confirmation-icon'));
        });
    }

    if (registrationForm) {
        registrationForm.addEventListener('submit', handleFormSubmit);
    }

    // Real-time password match validation
    if (passwordConfirmationInput) {
        passwordConfirmationInput.addEventListener('input', function() {
            if (this.value && passwordInput.value) {
                if (this.value !== passwordInput.value) {
                    this.setCustomValidity('Passwords do not match');
                } else {
                    this.setCustomValidity('');
                }
            }
        });
    }

    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            if (passwordConfirmationInput.value) {
                if (this.value !== passwordConfirmationInput.value) {
                    passwordConfirmationInput.setCustomValidity('Passwords do not match');
                } else {
                    passwordConfirmationInput.setCustomValidity('');
                }
            }
        });
    }

    // Phone number formatting (optional)
    const phoneInput = document.getElementById('phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            // Remove non-numeric characters except + and spaces
            this.value = this.value.replace(/[^\d+\s-]/g, '');
        });
    }

})();

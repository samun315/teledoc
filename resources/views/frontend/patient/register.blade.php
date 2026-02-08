@extends('frontend.master')

@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-one">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Patient Registration</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Patient Registration</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Registration Section -->
    <div class="patient-registration-area pt-100 pb-70">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="registration-card">
                        <div class="registration-header text-center mb-4">
                            <h2>Create Your Patient Account</h2>
                            <p>Fill in your details to register as a patient. All fields marked with <span class="text-danger">*</span> are required.</p>
                        </div>

                        <!-- Success/Error Messages -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="icofont-check-circled"></i>
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="icofont-close-circled"></i>
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="icofont-close-circled"></i>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form id="patient-registration-form" method="POST" action="{{ route('patient.register.store') }}" enctype="multipart/form-data">
                            @csrf

                            <!-- Personal Information Section -->
                            <div class="form-section">
                                <div class="section-header">
                                    <h3><i class="icofont-user"></i> Personal Information</h3>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-user"></i></span>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                                   id="name" name="name" value="{{ old('name') }}" 
                                                   placeholder="Enter your full name" required>
                                        </div>
                                        @error('name')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-ui-call"></i></span>
                                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                                   id="phone" name="phone" value="{{ old('phone') }}" 
                                                   placeholder="Enter your phone number" required>
                                        </div>
                                        @error('phone')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-ui-message"></i></span>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" 
                                                   placeholder="Enter your email address">
                                        </div>
                                        @error('email')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="date_of_birth" class="form-label">Date of Birth <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-calendar"></i></span>
                                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                                   id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                                                   max="{{ date('Y-m-d', strtotime('-1 day')) }}" required>
                                        </div>
                                        @error('date_of_birth')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="gender" class="form-label">Gender</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-venus-mars"></i></span>
                                            <select class="form-select @error('gender') is-invalid @enderror" 
                                                    id="gender" name="gender">
                                                <option value="">Select Gender</option>
                                                @foreach($genderList as $gender)
                                                    <option value="{{ $gender }}" {{ old('gender') == $gender ? 'selected' : '' }}>
                                                        {{ $gender }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('gender')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="blood_group" class="form-label">Blood Group</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-blood-drop"></i></span>
                                            <select class="form-select @error('blood_group') is-invalid @enderror" 
                                                    id="blood_group" name="blood_group">
                                                <option value="">Select Blood Group</option>
                                                @foreach($bloodGroupList as $bloodGroup)
                                                    <option value="{{ $bloodGroup }}" {{ old('blood_group') == $bloodGroup ? 'selected' : '' }}>
                                                        {{ $bloodGroup }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('blood_group')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="marital_status" class="form-label">Marital Status</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-heart"></i></span>
                                            <select class="form-select @error('marital_status') is-invalid @enderror" 
                                                    id="marital_status" name="marital_status">
                                                <option value="">Select Status</option>
                                                @foreach($maritalStatusList as $status)
                                                    <option value="{{ $status }}" {{ old('marital_status') == $status ? 'selected' : '' }}>
                                                        {{ $status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @error('marital_status')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-location-pin"></i></span>
                                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                                      id="address" name="address" rows="3" 
                                                      placeholder="Enter your address">{{ old('address') }}</textarea>
                                        </div>
                                        @error('address')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Medical Information Section -->
                            <div class="form-section">
                                <div class="section-header">
                                    <h3><i class="icofont-heartbeat"></i> Medical Information</h3>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="height" class="form-label">Height</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-ruler"></i></span>
                                            <input type="text" class="form-control @error('height') is-invalid @enderror" 
                                                   id="height" name="height" value="{{ old('height') }}" 
                                                   placeholder="e.g., 5'8&quot; or 173 cm">
                                        </div>
                                        @error('height')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="weight" class="form-label">Weight</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-weight"></i></span>
                                            <input type="text" class="form-control @error('weight') is-invalid @enderror" 
                                                   id="weight" name="weight" value="{{ old('weight') }}" 
                                                   placeholder="e.g., 70 kg or 154 lbs">
                                        </div>
                                        @error('weight')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4 mb-3">
                                        <label for="age" class="form-label">Age</label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-calendar"></i></span>
                                            <input type="number" class="form-control @error('age') is-invalid @enderror" 
                                                   id="age" name="age" value="{{ old('age') }}" 
                                                   placeholder="Auto-calculated" readonly>
                                        </div>
                                        <small class="form-text text-muted">Age will be calculated from date of birth</small>
                                        @error('age')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Account Information Section -->
                            <div class="form-section">
                                <div class="section-header">
                                    <h3><i class="icofont-lock"></i> Account Information</h3>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-lock"></i></span>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" 
                                                   placeholder="Enter password (min. 6 characters)" required>
                                            <button class="btn btn-outline-secondary" type="button" id="toggle-password">
                                                <i class="icofont-eye" id="password-icon"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text"><i class="icofont-lock"></i></span>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" 
                                                   placeholder="Confirm your password" required>
                                            <button class="btn btn-outline-secondary" type="button" id="toggle-password-confirmation">
                                                <i class="icofont-eye" id="password-confirmation-icon"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Photo Upload Section -->
                            <div class="form-section">
                                <div class="section-header">
                                    <h3><i class="icofont-camera"></i> Profile Photo (Optional)</h3>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="photo-upload-wrapper">
                                            <div class="photo-preview-container">
                                                <div class="photo-placeholder" id="photo-placeholder">
                                                    <i class="icofont-user"></i>
                                                    <p>No photo selected</p>
                                                </div>
                                                <img id="photo-preview" src="" alt="Photo Preview" style="display: none;">
                                                <button type="button" class="btn-remove-photo" id="remove-photo" style="display: none;">
                                                    <i class="icofont-close"></i>
                                                </button>
                                            </div>
                                            <div class="photo-upload-controls">
                                                <label for="photo" class="btn btn-outline-primary">
                                                    <i class="icofont-upload"></i> Choose Photo
                                                </label>
                                                <input type="file" class="d-none" id="photo" name="photo" 
                                                       accept="image/jpeg,image/jpg,image/png">
                                                <small class="form-text text-muted d-block mt-2">
                                                    Maximum file size: 2MB. Allowed formats: JPG, PNG
                                                </small>
                                            </div>
                                        </div>
                                        @error('photo')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="form-actions text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-lg px-5" id="submit-btn">
                                    <i class="icofont-check-circled"></i> Register Now
                                </button>
                                <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg px-5 ms-2">
                                    <i class="icofont-arrow-left"></i> Cancel
                                </a>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center mt-4">
                                <p class="mb-0">
                                    Already have an account? 
                                    <a href="{{ route('showLoginForm') }}" class="text-primary">Login here</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Registration Section -->
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('frontend/assets/css/patient-registration.css') }}">
@endpush

@section('page_script')
<script nonce="{{ $cspNonce }}">
    // Configuration
    window.registrationConfig = {
        registerUrl: '{{ route("patient.register.store") }}',
        csrfToken: '{{ csrf_token() }}'
    };
</script>
<script src="{{ asset('frontend/assets/js/patient-registration.js') }}"></script>
@endsection

@extends('master')
@section('title', 'Change Password')

@section('content')

    <!--begin::Toolbar -->
    <x-toolbar-component title="User Password Change" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'My Profile', 'url' => route('user.profile.viewProfile')],
        ['label' => 'User Password Change', 'active' => true],
    ]" />
    <!--end::Toolbar-->

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <div class="card" id="register-ticket">
                <!--begin::Header-->
                {{-- <div class="card-header border-2 pt-5 col-md-12">
                    <h3 class="col-md-3">
                        <span class="card-label fw-bolder fs-4 mb-1">User Password Change</span>
                    </h3>
                </div> --}}
                <!--end::Header-->
                @include('message')

                <!--begin::Card body-->
                <div class="card-body py-4">
                    <form class="form" method="POST" action="{{ route('user.profile.updatePassword') }}">
                        @csrf

                        <div class="row mb-5 col-md-12">
                            <div class="rounded border-gray-400 p-6 col-md-6">
                                <div class="col-md-12 fv-row mb-5">
                                    <label class="required fs-5 fw-bold mb-2">Current Password</label>
                                    <div class="input-group input-group-solid mb-5">
                                        <input type="password" class="form-control" id="currentPassword"
                                            name="current_password" placeholder="Enter Current Password" value="{{old('current_password')}}" required />
                                        <button type="button" class="input-group-text" id="toggleCurrentPasswordBtn">
                                            <i class="currentIcon"></i>
                                        </button>
                                    </div>
                                    @error('current_password')
                                        <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 fv-row mb-5">
                                    <label class="required fs-5 fw-bold mb-2">New Password</label>
                                    <div class="input-group input-group-solid mb-5">
                                        <input type="password" class="form-control" id="newpassword" name="new_password"
                                            minlength="8" placeholder="Enter New Password" required />
                                        <button type="button" class="input-group-text" id="toggleNewPasswordBtn">
                                            <i class="newIcon"></i>
                                        </button>
                                    </div>
                                    @error('new_password')
                                        <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 fv-row mb-5">
                                    <label class="required fs-5 fw-bold mb-2">Confirm Password</label>
                                    <div class="input-group input-group-solid mb-5">
                                        <input type="password" class="form-control" id="confirmnewpassword"
                                            name="confirm_password" placeholder="Enter Confirm Password" required />
                                        <button type="button" class="input-group-text" id="toggleConfirmPasswordBtn">
                                            <i class="confirmIcon"></i>
                                        </button>
                                    </div>
                                    @error('confirm_password')
                                        <span class="text-danger mt-2">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="d-flex flex-stack pt-5">
                                    <!--begin::Wrapper-->
                                    <div class="mr-2">
                                        <button type="button" class="btn btn-light me-2 formReset"
                                            data-bs-dismiss="modal">Reset
                                        </button>
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Wrapper-->
                                    <div>
                                        <button type="submit" class="btn btn-sm fs-6 btn-primary">Update
                                        </button>
                                    </div>

                                    <!--end::Wrapper-->
                                </div>
                            </div>
                            <div class="rounded border-gray-400 p-6 col-md-6">
                                <h4>Password Policy</h4>
                                <ul class="ps-10">
                                    <li>Be a minimum length of eight (8) characters</li>
                                    <li>Should include at least one upper case letter [A-Z].</li>
                                    <li>Should include at least one lower case letter [a-z].</li>
                                    <li>Should include at least one number [0-9].</li>
                                    {{-- <li>Should include at least one special character  (e.g. !@#$%()^&*\-=_+[\]{}/?. ).</li>
                                    <li >Not be a dictionary word or proper name.</li>
                                    <li >Not be the same as the User ID.</li> --}}
                                    <li>Not be identical to the previous three (3) passwords.</li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
    </div>
@endsection

@section('page_script')
    <script nonce="{{ $cspNonce }}">
        $(".formReset").on("click", function() {
            formReset();
        });

        function formReset() {
            $(".form").trigger("reset");
        }

        // Generic function to toggle password visibility and icon
        function togglePasswordVisibility(buttonSelector, fieldSelector, iconSelector) {
            $(buttonSelector).on('click', function() {
                const passwordField = $(fieldSelector);
                const icon = $(iconSelector);

                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    icon.removeClass('fas fa-eye').addClass('fa fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    icon.removeClass('fa fa-eye-slash').addClass('fas fa-eye');
                }
            });
        }

        // Initial setup of icons
        $(".currentIcon, .newIcon, .confirmIcon").addClass('fas fa-eye');

        // Apply function to each button and field
        togglePasswordVisibility('#toggleCurrentPasswordBtn', '#currentPassword', '.currentIcon');
        togglePasswordVisibility('#toggleNewPasswordBtn', '#newpassword', '.newIcon');
        togglePasswordVisibility('#toggleConfirmPasswordBtn', '#confirmnewpassword', '.confirmIcon');
    </script>
@endsection

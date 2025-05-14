<div class="modal fade" tabindex="-1" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"></h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 formReset" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fas fa-times"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <!--begin::Form-->
                <form class="px-9 form" id="submitForm">

                    @csrf

                    <input type="text" hidden name="id" id="kt_user_id" value="">

                    <!--begin::Step 1-->
                    <div class="current" data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->

                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row">

                                    <div class="col-md-6 fv-row mb-5 full_name">
                                        <label class="required fs-5 fw-bold mb-2">Full name</label>
                                        <input type="text" name="full_name" id="kt_full_name"
                                            class="form-control form-control-solid bg-gradient @error('full_name') is-invalid @enderror"
                                            placeholder="Enter full name" required />

                                        @error('full_name')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5 email">
                                        <label class="required fs-5 fw-bold mb-2">Email</label>
                                        <input type="email" name="email" id="kt_email"
                                            class="form-control form-control-solid bg-gradient @error('email') is-invalid @enderror"
                                            placeholder="Enter Email" required />
                                        @error('email')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5 phone">
                                        <label class="required fs-5 fw-bold mb-2">Phone</label>
                                        <input type="text" name="phone" id="kt_phone"
                                            class="form-control form-control-solid bg-gradient @error('phone') is-invalid @enderror"
                                            placeholder="Enter Phone" required />
                                        @error('phone')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5 role_id">
                                        <label class="required fs-5 fw-bold mb-2">User Role</label>
                                        <select name="role_id" id="kt_role_id"
                                            class="form-select form-select-solid bg-gradient @error('role_id') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select Role"
                                            data-dropdown-parent="#showModal" required>
                                            <option value=""></option>
                                            @foreach ($userRoles as $userRole)
                                                <option value="{{ $userRole->role_id ?? old('role_id') }}">
                                                    {{ $userRole->role_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('role_id')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5 user_name">
                                        <label class="required fs-5 fw-bold mb-2">Username</label>
                                        <input type="text" name="user_name" id="kt_user_name"
                                            class="form-control form-control-solid bg-gradient @error('user_name') is-invalid @enderror"
                                            placeholder="Enter Username" required />
                                        @error('user_name')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5 password">
                                        <label class="required fs-5 fw-bold mb-2">Password</label>
                                        <div class="passwordDiv">
                                            <input type="password" name="password"
                                                class="form-control form-control-solid kt_password bg-gradient @error('password') is-invalid @enderror"
                                                placeholder="Enter Password" autocomplete="off" required />
                                            <button type="button" class="togglePasswordBtn">
                                                <i class="passwordIcon"></i>
                                            </button>
                                        </div>
                                        <span id="error-message" class="error-message">This field is required.</span>
                                    </div>

                                    <div class="col-md-12 fv-row mb-5 address">
                                        <label class="required fs-5 fw-bold mb-2">Address</label>
                                        <textarea type="text" name="address" id="kt_address"
                                            class="form-control form-control-solid bg-gradient @error('address') is-invalid @enderror"
                                            placeholder="Enter Address...." required></textarea>
                                        @error('address')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5 country">
                                        <label class="fs-5 fw-bold mb-2">Country</label>
                                        <input type="text" name="country" id="kt_country"
                                            class="form-control form-control-solid bg-gradient @error('country') is-invalid @enderror"
                                            placeholder="Enter Country" />
                                        @error('country')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5 nid">
                                        <label class="fs-5 fw-bold mb-2">NID</label>
                                        <input type="number" name="nid" id="kt_nid"
                                            class="form-control form-control-solid bg-gradient @error('nid') is-invalid @enderror"
                                            placeholder="Enter NID number" />
                                        @error('nid')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5 diamond_per_usd">
                                        <label class="required fs-5 fw-bold mb-2">USD to Diamond</label>
                                        <input type="number" name="diamond_per_usd" id="kt_diamond_per_usd"
                                            class="form-control form-control-solid bg-gradient @error('diamond_per_usd') is-invalid @enderror"
                                            placeholder="Enter USD to Diamond" required />
                                        @error('diamond_per_usd')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 fv-row mb-5 active">
                                        <label class="required fs-5 fw-bold mb-2">Active</label>
                                        <select name="active" id="kt_active" data-placeholder="Select active Status"
                                            class="form-select form-select-solid bg-gradient @error('active') is-invalid @enderror"
                                            data-control="select2" data-dropdown-parent="#showModal">
                                            <option value=""></option>
                                            <option value="YES">YES</option>
                                            <option value="NO">NO</option>
                                        </select>
                                        @error('active')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-light me-2 formReset"
                                            data-bs-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-sm fs-6 btn-primary btnSubmit">
                                        </button>
                                    </div>
                                </div>
                                <!--end::Row-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Wrapper-->
                    </div>
                    <!--end::Step 1-->
                </form>
                <!--end::Form-->
            </div>
        </div>
    </div>
</div>

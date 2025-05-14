<div class="modal fade" tabindex="-1" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-md">
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

                    <!--begin::Step 1-->
                    <div class="current" data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->

                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row">
                                    <input type="text" hidden id="kt_current_balance" value="">
                                    <div class="col-md-12 fv-row mb-5">
                                        <label class="required fs-5 fw-bold mb-2">User</label>
                                        <select name="user_id" id="kt_user_id"
                                            class="form-select form-select-solid @error('user_id') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select User" required>
                                            <option value=""></option>
                                            @foreach ($users as $user)
                                                <option value="{{ $user?->id }}"
                                                    @if (old('user_id') == $user?->id) selected @endif>
                                                    {{ $user?->user_name }} | {{ $user?->full_name }} |
                                                    {{ $user?->email }} | {{ $user?->phone }}</option>
                                            @endforeach
                                        </select>
                                        @error('user_id')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 fv-row mb-5 type">
                                        <label class="required fs-5 fw-bold mb-2">Type</label>
                                        <select name="type" id="kt_type"
                                            class="form-select form-select-solid @error('type') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select Type"
                                            data-dropdown-parent="#showModal">
                                            <option value=""></option>
                                            <option value="add">ADD</option>
                                            <option value="minus">MINUS</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6 fv-row mb-5 password">
                                        <label class="required fs-5 fw-bold mb-2">Diamond Amount</label>
                                        <input type="number" name="balance" id="kt_balance" step=".001"
                                            class="form-control form-control-solid balance bg-gradient @error('balance') is-invalid @enderror"
                                            placeholder="Enter Diamond Amount" autocomplete="off" required />
                                        @error('balance')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12 d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-light me-2 formReset"
                                            data-bs-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-sm fs-6 btn-primary btnSubmit">
                                            SEND
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

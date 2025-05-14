<div class="modal fade" tabindex="-1" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create Balance Request</h3>

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

                    <input type="text" hidden name="id" id="kt_balance_request_id" value="">
                    <input type="text" hidden name="current_balance" id="kt_current_balance" value="{{$account?->current_balance}}">

                    <!--begin::Step 1-->
                    <div class="current" data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->

                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row">


                                    <div class="col-md-12 fv-row mb-5 password">
                                        <label class="required fs-5 fw-bold mb-2">Transferee Phone</label>
                                        <select name="mobile_number" id="kt_mobile_number"
                                            class="form-select form-select-solid mobile_number @error('mobile_number') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select Number" required>
                                            <option value=""></option>
                                            @foreach ($phones as $phone)
                                                <option value="{{ $phone?->mobile_number }}"
                                                    @if (old('mobile_number') == $phone?->mobile_number) selected @endif>
                                                    {{ $phone?->mobile_number }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('mobile_number')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 fv-row mb-5 password">
                                        <label class="required fs-5 fw-bold mb-2">Amount</label>
                                        <input type="number" name="amount" id="kt_amount"
                                            class="form-control form-control-solid amount bg-gradient @error('amount') is-invalid @enderror"
                                            placeholder="Enter Amount" autocomplete="off" required />
                                        @error('amount')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-end mt-3">
                                        <button type="button" class="btn btn-light me-2 formReset"
                                            data-bs-dismiss="modal">Close
                                        </button>
                                        <button type="submit" class="btn btn-sm fs-6 btn-primary btnSubmit">
                                            Request
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

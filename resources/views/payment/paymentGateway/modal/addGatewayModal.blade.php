<div class="modal fade" tabindex="-1" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
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

                    <input type="text" hidden name="id" id="kt_gateway_id" value="">

                    <!--begin::Step 1-->
                    <div class="current" data-kt-stepper-element="content">
                        <!--begin::Wrapper-->
                        <div class="w-100">
                            <!--begin::Heading-->

                            <!--begin::Input group-->
                            <div class="fv-row">
                                <!--begin::Row-->
                                <div class="row">
                                    <div class="col-md-12 fv-row mb-5 gateway">
                                        <label class="required fs-5 fw-bold mb-2">Gateway</label>
                                        <input type="text" name="gateway_name" id="kt_gateway_name"
                                            class="form-control form-control-solid gateway_name bg-gradient @error('gateway_name') is-invalid @enderror"
                                            placeholder="Enter Gateway name" autocomplete="off" required />
                                        @error('gateway_name')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 fv-row mb-5">
                                        <label class="required fs-5 fw-bold mb-2">Details</label>
                                        <textarea class="form-control form-control-solid details @error('details') is-invalid @enderror" id="kt_details"
                                            placeholder="Write Details...." name="details" data-kt-autosize="true">{{ old('details') }}</textarea>
                                        <span class="text-danger mt-2 terms_error"></span>
                                        @error('details')
                                            <span class="text-danger mt-2 terms_error">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 fv-row mb-5">
                                        <label class="required fs-5 fw-bold mb-2">Currency</label>
                                        <select name="currency_code" id="kt_currency_code"
                                            class="form-select form-select-solid @error('currency_code') is-invalid @enderror"
                                            data-control="select2" data-placeholder="Select Currency" required>
                                            <option value=""></option>
                                            @foreach ($currencyCodes as $currencyCode)
                                                <option value="{{ $currencyCode?->currency_code }}"
                                                    @if (old('currency_code') == $currencyCode?->currency_code) selected @endif>
                                                    {{ $currencyCode?->currency_code }}</option>
                                            @endforeach
                                        </select>
                                        @error('currency_code')
                                            <span class="text-danger mt-2">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-12 fv-row mb-5 gateway">
                                        <label class="required fs-5 fw-bold mb-2">Rate</label>
                                        <input type="text" name="rate" id="kt_rate"
                                            class="form-control form-control-solid rate bg-gradient @error('rate') is-invalid @enderror"
                                            placeholder="Enter Rate" autocomplete="off" required />
                                        @error('rate')
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

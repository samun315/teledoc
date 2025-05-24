<!--begin::Modal - New module-->
<div class="modal fade" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" action="javascript:void(0)" id="submitForm">

                @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_new_address_header">
                    <!--begin::Modal title-->
                    <h2 id="modalTitle"></h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 formReset" data-bs-dismiss="modal"
                        aria-label="Close">
                        <i class="fas fa-times"></i>
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <div class="row mb-5">

                        <input type="text" hidden name="drug_id" id="kt_drug_id">

                        <div class="col-md-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Trade Name</label>
                            <input type="text"
                                class="form-control form-control-solid trade_name @error('trade_name') is-invalid @enderror"
                                placeholder="Enter trade name" name="trade_name" required />
                        </div>
                        <div class="col-md-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Generic Name</label>
                            <input type="text"
                                class="form-control form-control-solid generic_name @error('generic_name') is-invalid @enderror"
                                placeholder="Enter generic name" name="generic_name" required />
                        </div>
                        <div class="col-md-6 fv-row mb-5">
                            <label class="fs-5 fw-bold mb-2">Note</label>
                            <textarea data-kt-autosize="true" class="form-control form-control-solid note @error('note') is-invalid @enderror"
                                placeholder="Write note...." name="note"></textarea>
                        </div>

                        <div class="col-md-6 fv-row mb-5">
                            <label class="fs-5 fw-bold mb-2">Warning</label>
                            <textarea data-kt-autosize="true" class="form-control form-control-solid warning @error('warning') is-invalid @enderror"
                                placeholder="Write warning...." name="warning"></textarea>
                        </div>

                        <div class="col-md-6 fv-row mb-5">
                            <label class="fs-5 fw-bold mb-2">Side Effect</label>
                            <textarea data-kt-autosize="true"
                                class="form-control form-control-solid side_effect @error('side_effect') is-invalid @enderror"
                                placeholder="Write side effect...." name="side_effect"></textarea>
                        </div>

                        <div class="col-md-6 fv-row mb-5">
                            <label class="fs-5 fw-bold mb-2">Additional Advice</label>
                            <textarea data-kt-autosize="true"
                                class="form-control form-control-solid additional_advice @error('additional_advice') is-invalid @enderror"
                                placeholder="Write additional advice...." name="additional_advice"></textarea>
                        </div>

                        <div class="col-md-12 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Status</label>
                            <select name="status"
                                class="form-select form-select-solid status @error('status') is-invalid @enderror"
                                data-control="select2" data-placeholder="Select Status"
                                data-dropdown-parent="#showModal">
                                <option value=""></option>
                                <option value="Active"> Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <!--begin::Button-->

                    <div class="col-md-12 d-flex justify-content-end">
                        <button type="button" class="btn btn-light me-2 formReset" data-bs-dismiss="modal">Close
                        </button>
                        <button type="submit" class="btn btn-sm fs-6 btn-primary btnSubmit">
                        </button>
                    </div>
                    <!--end::Button-->
                </div>
                <!--end::Modal body-->

            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - New module-->

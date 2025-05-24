<!--begin::Modal - New module-->
<div class="modal fade" id="showViewModal" data-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_new_address_header">
                <!--begin::Modal title-->
                <h2>View Drug</h2>
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

                    <div class="col-md-6 fv-row mb-5">
                        <label class="fs-5 fw-bold mb-2">Trade Name</label>
                        <input type="text" class="form-control form-control-solid trade_name" readonly />
                    </div>
                    <div class="col-md-6 fv-row mb-5">
                        <label class="required fs-5 fw-bold mb-2">Generic Name</label>
                        <input type="text" class="form-control form-control-solid generic_name" readonly />
                    </div>
                    <div class="col-md-6 fv-row mb-5">
                        <label class="fs-5 fw-bold mb-2">Note</label>
                        <textarea data-kt-autosize="true" class="form-control form-control-solid note" readonly></textarea>
                    </div>

                    <div class="col-md-6 fv-row mb-5">
                        <label class="fs-5 fw-bold mb-2">Warning</label>
                        <textarea data-kt-autosize="true" class="form-control form-control-solid warning" readonly></textarea>
                    </div>

                    <div class="col-md-6 fv-row mb-5">
                        <label class="fs-5 fw-bold mb-2">Side Effect</label>
                        <textarea data-kt-autosize="true" class="form-control form-control-solid side_effect" readonly></textarea>
                    </div>

                    <div class="col-md-6 fv-row mb-5">
                        <label class="fs-5 fw-bold mb-2">Additional Advice</label>
                        <textarea data-kt-autosize="true" class="form-control form-control-solid additional_advice" readonly></textarea>
                    </div>

                    <div class="col-md-12 fv-row mb-5">
                        <label class="fs-5 fw-bold mb-2">Status</label>
                        <input type="text" class="form-control form-control-solid status" readonly />
                    </div>
                </div>
                <!--begin::Button-->

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-light me-2 formReset" data-bs-dismiss="modal">Close
                    </button>
                </div>
                <!--end::Button-->
            </div>
            <!--end::Modal body-->
        </div>
    </div>
</div>
<!--end::Modal - New module-->

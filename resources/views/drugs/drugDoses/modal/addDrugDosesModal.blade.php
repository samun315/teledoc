<!--begin::Modal - New module-->
<div class="modal fade" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered">
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

                        <input type="text" hidden name="drug_dose_id" id="kt_drug_dose_id">

                        <div class="col-md-12 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Drug Frequency</label>
                            <textarea data-kt-autosize="true" class="form-control form-control-solid @error('drug_dose') is-invalid @enderror"
                                placeholder="Write drug frequency...." name="drug_dose" id="kt_drug_dose" required></textarea>
                        </div>

                        <div class="col-md-12 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Drug form</label>
                            <select name="drug_type_id" id="kt_drug_type_id"
                                class="form-select form-select-solid @error('drug_type_id') is-invalid @enderror"
                                data-control="select2" data-placeholder="Select drug form"
                                data-dropdown-parent="#showModal">
                                {{-- onchange="getdrug_typeItem(this);" --}}
                                <option value=""></option>
                                @foreach ($drugTypes as $drugType)
                                    <option {{ old('drug_type_id') ? 'selected' : '' }}
                                        value="{{ $drugType->drug_type_id ?? old('drug_type_id') }}">
                                        {{ $drugType->drug_type }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Status</label>
                            <select name="status" id="kt_status"
                                class="form-select form-select-solid @error('status') is-invalid @enderror"
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

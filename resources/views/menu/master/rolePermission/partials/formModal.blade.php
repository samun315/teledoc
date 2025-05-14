<div class="modal fade" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Group Name<span id="modal_ttl2"></span></h2>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>
            <form action="" id="submit_form">
                @csrf
                <div class="modal-body py-lg-10 px-lg-10">
                    <div class="row">
                        <div class="col-md-12 my-1">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">Group Name</span>
                            </label>
                            <input type="text"
                                   class="form-control form-control-solid @error('group_name') is-invalid @enderror"
                                   placeholder="Enter source name" name="group_name"/>
                        </div>
                        <div class="col-md-12 my-1">
                            <input type="hidden" name="id">
                            <label class="d-flex align-items-center fs-5 fw-semibold mb-2">
                                <span class="required">Active</span>
                            </label>
                            <select name="active"
                                    class="form-select form-select-solid"
                                    data-control="select2" data-hide-search="true" data-placeholder="Active">
                                <option value="YES">YES</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-center">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard
                        </button>
                        <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit"><span
                                class="indicator-label" id="btn_title">Submit</span><span class="indicator-progress">Please wait...<span
                                    class="spinner-border spinner-border-sm align-middle ms-2"></span></span></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

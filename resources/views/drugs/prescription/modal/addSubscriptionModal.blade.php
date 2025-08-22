<!--begin::Modal - New module-->
<div class="modal fade" id="showSubscriptionModal" data-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Modal header-->
            <div class="modal-header" id="kt_modal_new_address_header">
                <!--begin::Modal title-->
                <h2 id="modalTitle"></h2>
                <!--end::Modal title-->
                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 resetModal" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fas fa-times"></i>
                </div>
                <!--end::Close-->
            </div>
            <!--end::Modal header-->
            <!--begin::Modal body-->
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mb-7">
                        <!-- START SEARCH ICON-->
                        <x-search />
                        <!-- END SEARCH ICON-->
                    </div>
                </div>

                <div class="row mb-7">
                    <div id="subscriptionList">

                    </div>
                </div>
                <!--begin::Button-->

                <div class="col-md-12 d-flex justify-content-end">
                    <button type="button" class="btn btn-danger me-2 resetModal" data-bs-dismiss="modal">Close
                    </button>
                    <button type="submit" class="btn btn-sm fs-6 btn-primary btnAddSubscription">
                        Add
                    </button>
                </div>
                <!--end::Button-->
            </div>
            <!--end::Modal body-->
        </div>
    </div>
</div>
<!--end::Modal - New module-->

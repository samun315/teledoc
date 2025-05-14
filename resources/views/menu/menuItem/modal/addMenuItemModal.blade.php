<!--begin::Modal - New module-->
<div class="modal fade" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-lg">
        <!--begin::Modal content-->
        <div class="modal-content">
            <!--begin::Form-->
            <form class="form" id="submitForm">

                @csrf
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_new_address_header">
                    <!--begin::Modal title-->
                    <h2 class="menuItemTitle"></h2>
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

                        <input type="text" hidden name="menu_item_id" id="kt_menu_item_id">
                        <input type="text" hidden name="menu_id" id="kt_menu_id" value="{{ $menuInfos?->menu_id }}">
                        <input type="text" hidden id="hidden_module_item_id">
                        <input type="text" hidden id="hidden_parent_id">

                        
                        <div class="col-md-12 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Type</label>
                            <select name="type" id="kt_type"
                                class="form-select form-select-solid @error('type') is-invalid @enderror"
                                data-control="select2" data-placeholder="Select Type" data-dropdown-parent="#showModal">
                                <option value=""></option>
                                <option value="divider">Divider</option>
                                <option value="parent">Parent</option>
                                <option value="menu_item">Menu Item</option>
                            </select>
                        </div>

                        <div class="col-md-6 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Module Name</label>
                            <select name="module_id" id="kt_module_id"
                                class="form-select form-select-solid @error('module_id') is-invalid @enderror"
                                data-control="select2" data-placeholder="Select Module"
                                data-dropdown-parent="#showModal">
                                {{-- onchange="getModuleItem(this);" --}}
                                <option value=""></option>
                                @foreach ($menuModules as $menuModule)
                                    <option {{ old('module_id') ? 'selected' : '' }}
                                        value="{{ $menuModule->module_id ?? old('module_id') }}">
                                        {{ $menuModule->module_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 fv-row mb-5 moduleItemId">
                            <label class="required fs-5 fw-bold mb-2">Module Item Name</label>
                            <select name="module_item_id" id="kt_module_item_id"
                                class="form-select form-select-solid @error('module_item_id') is-invalid @enderror"
                                data-control="select2" data-placeholder="Select Module Item"
                                data-dropdown-parent="#showModal">
                                <option value=""></option>
                                @foreach ($moduleItems as $moduleItem)
                                    <option {{ old('module_item_id') ? 'selected' : '' }}
                                        value="{{ $moduleItem->item_id ?? old('module_item_id') }}">
                                        {{ $moduleItem->item_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 fv-row mb-5 parentId">
                            <label class="fs-5 fw-bold mb-2">Parent</label>
                            <select name="parent_id" id="kt_parent_id"
                                class="form-select form-select-solid @error('parent_id') is-invalid @enderror"
                                data-control="select2" data-placeholder="Select Parent"
                                data-dropdown-parent="#showModal">
                                <option value=""></option>
                                @foreach ($parents as $parent)
                                    <option {{ old('parent_id') ? 'selected' : '' }}
                                        value="{{ $parent?->menu_item_id ?? old('parent_id') }}">
                                        {{ $parent?->menu_item_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 fv-row mb-5 name">
                            <label class="required fs-5 fw-bold mb-2">Name</label>
                            <input type="text" name="menu_item_name" id="kt_name"
                                class="form-control form-control-solid @error('menu_item_name') is-invalid @enderror"
                                placeholder="Enter Item Name" />
                        </div>

                        <div class="col-md-6 fv-row mb-5 url">
                            <label class="fs-5 fw-bold mb-2">Url</label>
                            <input type="text" name="url" id="kt_url"
                                class="form-control form-control-solid @error('url') is-invalid @enderror"
                                placeholder="Enter Url" />
                        </div>

                        <div class="col-md-6 fv-row mb-5 iconClass">
                            <label class="required fs-5 fw-bold mb-2">Icon Class</label>
                            <input type="text" name="icon_class" id="kt_icon_class"
                                class="form-control form-control-solid @error('icon_class') is-invalid @enderror"
                                placeholder="Enter Icon Class" />
                        </div>

                        <div class="col-md-6 fv-row mb-5 target">
                            <label class="fs-5 fw-bold mb-2">Target</label>
                            <input type="text" name="target" id="kt_target"
                                class="form-control form-control-solid @error('target') is-invalid @enderror"
                                placeholder="Enter Target" />
                        </div>

                        <div class="col-md-6 fv-row mb-5 active">
                            <label class="required fs-5 fw-bold mb-2">Active</label>
                            <select name="active" id="active"
                                class="form-select form-select-solid @error('active') is-invalid @enderror"
                                data-control="select2" data-placeholder="Select Status"
                                data-dropdown-parent="#showModal">
                                <option value=""></option>
                                <option value="YES"> YES</option>
                                <option value="NO">NO</option>
                            </select>
                        </div>

                        <div class="col-md-12 d-flex justify-content-end mt-3">
                            <button type="button" class="btn btn-light me-2 formReset" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-sm fs-6 btn-primary btnSubmit">
                            </button>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - New module-->

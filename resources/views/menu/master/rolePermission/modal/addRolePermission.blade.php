<!--begin::Modal - New Role permission-->
<div class="modal fade" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <!--begin::Modal dialog-->
    <div class="modal-dialog modal-dialog-centered mw-650px">
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
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1"
                                    transform="rotate(-45 6 17.3137)" fill="black" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1"
                                    transform="rotate(45 7.41422 6)" fill="black" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body py-10 px-lg-17">
                    <div class="row mb-5">

                        <input type="text" hidden name="menu_role_permission_id" id="menu_role_permission_id">

                        <div class="col-md-12 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">User Role Name</label>
                            <select name="role_id" id="role_id" class="form-select form-select-solid"
                                data-control="select2" data-dropdown-parent="#showModal"
                                data-placeholder="Select module item name">

                                <option value=""></option>

                                @foreach ($userRoles as $userRole)
                                    <option value="{{ $userRole->role_id }}">{{ $userRole->role_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 fv-row mb-5">
                            <label class="required fs-5 fw-bold mb-2">Permission Name</label>
                            <select name="menu_permission_id" id="menu_permission_id"
                                class="form-select form-select-solid" data-control="select2"
                                data-dropdown-parent="#showModal" data-placeholder="Select module item name">

                                <option value=""></option>

                                @foreach ($permissions as $permission)
                                    <option value="{{ $permission->menu_permission_id }}">{{ $permission->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <!--end::Modal body-->
                <!--begin::Modal footer-->
                <div class="modal-footer flex-center">
                    <!--begin::Button-->
                    <button type="submit" id="btnSubmit" class="btn btn-primary">
                        <span class="indicator-label">Submit</span>
                    </button>
                    <!--end::Button-->
                </div>
                <!--end::Modal footer-->
            </form>
            <!--end::Form-->
        </div>
    </div>
</div>
<!--end::Modal - New Role permission-->

@extends('master')

@section('title', 'Role Permission Create')
@section('content')

    <!--begin::Toolbar -->
    <x-toolbar-component title="Role Permission Create" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Menu Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Menu Master', 'url' => 'javascript:void(0)'],
        ['label' => 'Role Permission Create', 'active' => true],
    ]" actionUrl="{{ route('menu.master.rolePermission.index') }}" actionIcon="fas fa-table"
        actionLabel="Role Permission List" />
    <!--end::Toolbar -->

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"> Add New </span>
                    </h3>
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body py-3">
                    @include('message')

                    <!--begin::Form-->
                    <form class="form" method="POST" action="{{ route('menu.master.rolePermission.store') }}">
                        @csrf

                        <div class="row mb-5">
                            <div class="col-md-12 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-2">User Role Name</label>
                                <select name="role_id"
                                    class="form-select form-select-solid @error('role_id') is-invalid @enderror"
                                    data-control="select2" data-placeholder="Select User Role Name">
                                    <option value=""></option>
                                    @foreach ($userRoles as $userRole)
                                        <option value="{{ $userRole->role_id }}">{{ $userRole->role_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-5">
                            <div class="col-md-12 fv-row row mb-5">
                                <label class="required fs-5 fw-bold mb-5">Permission</label>
                                <div class="col-md-12 form-check ms-3">
                                    <input class="form-check-input toggleSelectAll" type="checkbox" id="selectAllCheckbox"
                                        name="">
                                    Select All

                                    <div class="m-7 border">
                                    </div>
                                </div>
                                @foreach ($itemNames as $itemName)
                                    <div class="col-md-6 mb-5">
                                        <h4 class="mb-4">Module Item: {{ $itemName?->item_name }}</h4>

                                        @foreach ($permissions as $permission)
                                            @if ($itemName?->item_id == $permission?->item_id)
                                                <div class="form-check mb-4 ms-2">
                                                    <input
                                                        class="form-check-input checkboxes updateSelectAll @error('menu_permission_id') is-invalid @enderror"
                                                        type="checkbox" name="menu_permission_id[]"
                                                        value="{{ $permission->menu_permission_id }}" />
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $permission->name }}
                                                    </label>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach

                                @error('menu_permission_id')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer flex-center">
                            <button type="submit" class="btn btn-sm btn-primary">
                                <span class="indicator-label">Submit</span>
                            </button>
                            <!--end::Button-->
                        </div>
                        <!--end::Modal footer-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>


@endsection

@section('page_script')
    <script nonce="{{ $cspNonce }}">
        $(document).on("click", ".toggleSelectAll", function() {
            toggleSelectAll();
        });

        function toggleSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const checkboxes = document.querySelectorAll('.checkboxes');
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAllCheckbox.checked;
            });
        }

        $(document).on("click", ".updateSelectAll", function() {
            updateSelectAll();
        });

        function updateSelectAll() {
            const selectAllCheckbox = document.getElementById('selectAllCheckbox');
            const checkboxes = document.querySelectorAll('.checkboxes');
            selectAllCheckbox.checked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        }
    </script>

@endsection

@extends('master')

@section('title', isset($editModeData) ? 'Edit Division' : 'Division Create')
@section('breadcrumbMainTitle', isset($editModeData) ? 'Edit Division' : 'Division Create')

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"> Add New Division</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('hrm.employee.division.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-table"></i> Division List
                        </a>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body py-3">
                    @include('message')

                    <!--begin::Form-->
                    <form class="form" method="POST"
                        action="{{ isset($editModeData) ? route('hrm.employee.division.update', $editModeData->division_id) : route('hrm.employee.division.store') }}">
                        @csrf

                        @isset($editModeData)
                            @method('PUT')
                            <input type="text" hidden name="division_id" value="{{ $editModeData->division_id }}">
                        @endisset

                        <div class="row mb-5">

                            <div class="col-md-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-2">Division Name</label>
                                <input type="text"
                                    class="form-control form-control-solid @error('division_name') is-invalid @enderror"
                                    placeholder="Enter division name" name="division_name"
                                    value="{{ $editModeData->division_name ?? old('division_name') }}" />
                                @error('division_name')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-2">Active</label>
                                <select name="active"
                                    class="form-select form-select-solid @error('active') is-invalid @enderror"
                                    data-control="select2" data-hide-search="true" data-placeholder="Active">
                                    <option {{ isset($editModeData) && $editModeData->active == 'YES' ? 'selected' : '' }}
                                        value="YES">
                                        YES
                                    </option>
                                    <option {{ isset($editModeData) && $editModeData->active == 'NO' ? 'selected' : '' }}
                                        value="NO">NO
                                    </option>
                                </select>
                                @error('active')
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

@extends('master')

@section('title', isset($editModeData) ? 'Edit Sub Division' : 'Sub Division Create')
@section('breadcrumbMainTitle', isset($editModeData) ? 'Edit Sub Division' : 'Sub Division Create')

@section('content')
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                        <span class="card-label fw-bolder fs-3 mb-1"> {{ isset($editModeData) ? 'Edit' : 'Create' }} New Sub
                            Division</span>
                    </h3>
                    <div class="card-toolbar">
                        <a href="{{ route('hrm.employee.subDivision.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-table"></i>Sub Division List
                        </a>
                    </div>
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body py-3">
                    @include('message')

                    <!--begin::Form-->
                    <form class="form" method="POST"
                        action="{{ isset($editModeData) ? route('hrm.employee.subDivision.update', $editModeData->sub_division_id) : route('hrm.employee.subDivision.store') }}">
                        @csrf

                        @isset($editModeData)
                            @method('PUT')
                            <input type="text" hidden name="sub_division_id" value="{{ $editModeData->sub_division_id }}">
                        @endisset

                        <div class="row mb-5">

                            <div class="col-md-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-2">Division Name</label>
                                <select name="division_id"
                                    class="form-select form-select-solid @error('division_id') is-invalid @enderror"
                                    data-control="select2" data-placeholder="Division Name">
                                    @foreach ($divisions as $division)
                                        <option
                                            @isset($editModeData)
                                                {{ $editModeData->division_id == $division->division_id ? 'selected' : '' }}
                                            @endisset
                                            value="{{ $division->division_id }}">{{ $division->division_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('division_id')
                                    <span class="text-danger mt-2">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-md-6 fv-row mb-5">
                                <label class="required fs-5 fw-bold mb-2">Sub Division Name</label>
                                <input type="text"
                                    class="form-control form-control-solid @error('sub_division_name') is-invalid @enderror"
                                    placeholder="Enter sub division name" name="sub_division_name"
                                    value="{{ $editModeData->sub_division_name ?? old('sub_division_name') }}" />
                                @error('sub_division_name')
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

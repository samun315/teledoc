@extends('master')

@section('title', 'User Profile Edit')

@section('content')

    <!--begin::Toolbar -->
    <x-toolbar-component title="Edit User Profile" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'My Profile', 'url' => route('user.profile.viewProfile')],
        ['label' => 'Edit User Profile', 'active' => true],
    ]" />
    <!--end::Toolbar-->

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Stepper-->
            <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                id="kt_create_account_stepper">

                <!--begin::Content-->
                <div class="card d-flex flex-row-fluid flex-center">
                    <!--begin::Form-->
                    <form class="card-body py-10 w-100 px-9" method="POST" enctype="multipart/form-data"
                        id="kt_user_profile_info" action="{{ route('user.profile.profileUpdate', $editModeData->id) }}">

                        @csrf

                        @isset($editModeData)
                            @method('PUT')
                            <input type="text" hidden name="id" value="{{ $editModeData->id }}">
                        @endisset

                        <!--begin::Step 1-->
                        <div class="current" data-kt-stepper-element="content">
                            <!--begin::Wrapper-->
                            <div class="w-100">

                                @include('message')

                                <!--begin::Input group-->
                                <div class="fv-row">
                                    <!--begin::Row-->
                                    <div class="row mb-5">

                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="required fs-5 fw-bold mb-2">Name</label>
                                            <input type="text"
                                                class="form-control form-control-solid @error('full_name') is-invalid @enderror"
                                                placeholder="Enter name" name="full_name"
                                                value="{{ $editModeData->full_name ?? old('full_name') }}" required />
                                            @error('full_name')
                                                <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="required fs-5 fw-bold mb-2">User Name</label>
                                            <input type="text"
                                                class="form-control form-control-solid @error('user_name') is-invalid @enderror"
                                                placeholder="Enter nick name" name="user_name"
                                                value="{{ $editModeData->user_name ?? old('user_name') }}" required />
                                            @error('user_name')
                                                <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="required fs-5 fw-bold mb-2">Phone</label>
                                            <input type="text" name="phone"
                                                class="form-control form-control-solid @error('phone') is-invalid @enderror"
                                                placeholder="Enter phone" value="{{ $editModeData->phone ?? old('phone') }}"
                                                required />
                                            @error('phone')
                                                <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="required fs-5 fw-bold mb-2">Email</label>
                                            <input type="email"
                                                class="form-control form-control-solid @error('email') is-invalid @enderror"
                                                placeholder="Enter email" name="email"
                                                value="{{ $editModeData->email ?? old('email') }}" required />
                                            @error('email')
                                                <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">Profile Photo</label>
                                            <input type="file"
                                                class="form-control form-control-solid @error('profile_img') is-invalid @enderror"
                                                placeholder="Give profile photo" name="profile_img" />
                                            @error('profile_img')
                                                <span class="text-danger mt-2">{{ $message ?? '' }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">NID</label>
                                            <input type="number"
                                                class="form-control form-control-solid @error('nid') is-invalid @enderror"
                                                placeholder="Enter nid" name="nid"
                                                value="{{ $editModeData->nid ?? old('nid') }}" required />
                                            @error('nid')
                                                <span class="text-danger mt-2">{{ $message ?? '' }}</span>
                                            @enderror
                                        </div>

                                        @isset($editModeData->nid)
                                        
                                        {{-- <div class="col-md-6 fv-row mb-5">
                                            <label class="required fs-5 fw-bold mb-2">NID Front</label>
                                            <input type="file"
                                                class="form-control form-control-solid @error('nid_front') is-invalid @enderror"
                                                name="nid_front"
                                                value="{{ $editModeData->nid ?? old('nid_front') }}" required />
                                            @error('nid_front')
                                                <span class="text-danger mt-2">{{ $message ?? '' }}</span>
                                            @enderror
                                        </div>
                                        <div class="memberblock mb-0">
                                            <div class="row ">
                                                <input type="hidden" id="hiddenFront">
                                                <input type="hidden" id="hiddenBack">
                                                <div class="bg-white mainDiv">
                                                    <img src="" alt="TAKE FRONT PAGE OF NATIONAL ID" id="showFrontNid">
                                                    <input type="file" name="front_nid" id="front_nid" class="my_file"
                                                           onchange="displayFrontPart(this)">
                                                </div>
                                                <div class="bg-white mainDiv" id="back_part">
                                                    <img src="" alt="TAKE BACK PAGE OF NATIONAL ID" id="showBackNid">
                                                    <input type="file" name="back_nid" id="back_nid" class="my_file"
                                                           onchange="displayBackPart(this)">
                                                </div>
                                            </div>
                                        </div> --}}
                                        @endisset
                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">Country</label>
                                            <input type="text"
                                                class="form-control form-control-solid @error('country') is-invalid @enderror"
                                                placeholder="Enter country" name="country"
                                                value="{{ $editModeData->country ?? old('country') }}" required />
                                            @error('country')
                                                <span class="text-danger mt-2">{{ $message ?? '' }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 fv-row mb-5">
                                            <label class="required fs-5 fw-bold mb-2">Address</label>
                                            <textarea class="form-control form-control-solid" placeholder="Enter address" name="address" data-kt-autosize="true"
                                                required>{{ $editModeData->address ?? old('address') }}</textarea>
                                            @error('address')
                                                <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>


                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">Passport No</label>
                                            <input type="text"
                                                class="form-control form-control-solid @error('passport') is-invalid @enderror"
                                                placeholder="Enter passport no" name="passport"
                                                value="{{ $editModeData->passport ?? old('passport') }}" />
                                            @error('passport')
                                                <span class="text-danger mt-2">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Input group-->
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Step 1-->

                        <div class="d-flex flex-stack pt-5">
                            <!--begin::Wrapper-->
                            <div class="mr-2">
                                <button href="{{ route('user.profile.viewProfile') }}"
                                    class="btn btn-lg btn-light-primary me-3" data-kt-stepper-action="previous">
                                    <x-left-arrow />
                                    Back
                                </button>
                            </div>
                            <!--end::Wrapper-->
                            <!--begin::Wrapper-->
                            <div>


                                <button type="submit" class="btn btn-sm btn-primary" id="submitContinueBtn">
                                    Update
                                    <x-right-arrow />
                                </button>
                            </div>
                            <!--end::Wrapper-->
                        </div>

                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Stepper-->
        </div>
    </div>
@endsection

@section('page_script')
@endsection

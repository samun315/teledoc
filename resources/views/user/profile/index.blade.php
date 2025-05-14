@extends('master')
@section('title', 'User Profile')

@section('content')
    <x-toolbar-component title="User Profile" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'My Profile', 'url' => route('user.profile.viewProfile')],
        ['label' => 'User Profile', 'active' => true],
    ]" actionUrl="{{ route('user.profile.editProfile') }}"
        actionIcon="fas fa-edit" actionLabel="Edit Profile" />
    <div class="post d-flex flex-column-fluid" id="kt_post">
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Stepper-->
            <div class="stepper stepper-pills stepper-column d-flex flex-column flex-xl-row flex-row-fluid"
                id="kt_create_account_stepper">

                <!--begin::Content-->
                <div class="card d-flex flex-row-fluid flex-center">
                    <!--begin::Form-->
                    <div class="card-body py-10 w-100 px-9">

                        @csrf

                        @isset($personalInfoData)
                            <input type="text" hidden name="user_id" value="{{ $personalInfoData?->id }}">
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

                                        <div class="col-md-12 fv-row mb-5 d-flex justify-content-start">
                                            <div class="symbol symbol-150px">
                                                @if (isset($personalInfoData) && !empty($personalInfoData?->profile_img))
                                                    <img alt="Logo"
                                                        src="{{ asset('uploads/user/profile/' . $personalInfoData?->profile_img) }}" />
                                                @else
                                                    <img alt="Logo"
                                                        src="{{ asset('assets/media/avatars/300-1.jpg') }}" />
                                                @endif
                                            </div>
                                            <div class="ms-5">
                                                <p class="fs-3">Name: {{ $personalInfoData?->full_name }}</p>
                                                <p>Phone: {{ $personalInfoData?->phone }}</p>
                                                <p>Email: {{ $personalInfoData?->email }}</p>
                                                <p>User Name: {{ $personalInfoData?->user_name }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-12 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">Address</label>
                                            <textarea type="text" class="form-control form-control-solid" name="mother_name"
                                             disabled="true" >{{ $personalInfoData?->address }} </textarea>
                                        </div>
                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">Country</label>
                                            <input type="text" class="form-control form-control-solid" name="father_name"
                                                value="{{ $personalInfoData?->country }}" disabled="true" />
                                        </div>
                                        @isset($personalInfoData?->nid)
                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">NID</label>
                                            <input type="text" id="kt_marital_status"
                                                class="form-control form-control-solid" name="marital_status"
                                                value="{{ $personalInfoData?->nid }}" disabled="true" />
                                        </div>
                                        @endisset
                                        @isset($personalInfoData?->nit_front)
                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">NID Front</label>
                                            <img src="{{ asset('uploads/user/profile/nid/front/' . $personalInfoData?->nid_front) }}" alt="not found">
                                        </div>
                                        @endisset
                                        @isset($personalInfoData?->nit_back)
                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">NID Back</label>
                                            <img src="{{ asset('uploads/user/profile/nid/back/' . $personalInfoData?->nid_back) }}" alt="not found">
                                        </div>
                                        @endisset
                                        @isset($personalInfoData?->passport)
                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">Passport</label>
                                            <input type="text" id="kt_marital_status"
                                                class="form-control form-control-solid" name="marital_status"
                                                value="{{ $personalInfoData?->nid }}" disabled="true" />
                                        </div>
                                        <div class="col-md-6 fv-row mb-5">
                                            <label class="fs-5 fw-bold mb-2">Passport Image</label>
                                            <img src="{{ asset('uploads/user/profile/passport/' . $personalInfoData?->passport_img) }}" alt="not found">
                                        </div>
                                        @endisset
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

                            </div>
                            <!--end::Wrapper-->
                        </div>

                    </div>
                    <!--end::Form-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Stepper-->
        </div>
    </div>
@endsection

@section('page_script')

    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/user/index.js') }}" {{ Sri::html('assets/custom/js/user/index.js') }}>
    </script>
    <!--end::Page Custom Stylesheets(used by this page)-->

@endsection

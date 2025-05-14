<!DOCTYPE html>

<html lang="en">

<!--begin::Head-->

<head>
    @include('layout.stylesheet')
</head>
<!--end::Head-->

<!--begin::Body-->

<body id="kt_body"
      class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled toolbar-fixed aside-enabled aside-fixed">
<!--begin::Main-->
<!--begin::Root-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="page d-flex flex-row flex-column-fluid">

        <!--begin::Aside-->
        @include('layout.sidebar')
        <!--end::Aside-->

        <!--begin::Wrapper-->
        <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">

            <!--begin::Header-->
            @include('layout.header')
            <!--end::Header-->

            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                <!--begin::Post-->
                @yield('content')
                <!--end::Post-->
            </div>
            <!--end::Content-->

            <!--begin::Footer-->
            @include('layout.footer')
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Root-->

@include('layout.script')

<!-- IziToast -->
@include('vendor.lara-izitoast.toast')

</body>
<!--end::Body-->

</html>

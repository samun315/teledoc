<base href="../../">
<title>@yield('title') | OurAbs </title>

<meta charset="utf-8" />
<meta http-equiv="Content-Security-Policy"
    content="
    script-src 'self' 'nonce-{{ $cspNonce }}';
    style-src 'self' 'unsafe-inline' https://fonts.googleapis.com;
    font-src 'self' https://fonts.gstatic.com;
    img-src 'self' data:;
    object-src 'none';
    frame-src 'none';
    base-uri 'self';
">

<meta name="description"
    content="The most advanced ERP System beginners and professionals. Multi-demo, Laravel versions. Grab your copy now and get life-time updates for free." />
<meta name="keywords" content="ABS,OurABs, IMO, IMO Diamond" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta property="og:locale" content="en_US" />
<meta property="og:type" content="article" />
<meta property="og:title"
    content="ABS-Dashboard" />
<meta property="og:url" content="ourabs.com" />

<!--begin::CSRF Token-->
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.svg') }}" type="image/svg+xml" />

<!--begin::Fonts-->
<link nonce="{{ $cspNonce }}" href="https://fonts.googleapis.com">
<link nonce="{{ $cspNonce }}" rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" nonce="{{ $cspNonce }}"
    href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
<!--end::Fonts-->

<!--begin::Page Vendor Stylesheets(used by this page)-->
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"
    {{ Sri::html('assets/plugins/custom/datatables/datatables.bundle.css') }} />
<!--end::Page Vendor Stylesheets-->

<!--begin::Global Stylesheets Bundle(used by all pages)-->
<link nonce="{{ $cspNonce }}" href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet"
    type="text/css" {{ Sri::html('assets/plugins/global/plugins.bundle.css') }} />
<link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css"
    {{ Sri::html('assets/css/style.bundle.css') }} />
<!--end::Global Stylesheets Bundle-->

<!-- DataTable css -->
<link href="{{ asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"
    {{ Sri::html('assets/plugins/custom/datatables/datatables.bundle.css') }} />

<!-- Wait me css -->
<link href="{{ asset('assets/plugins/global/waitMe/waitMe.min.css') }}" rel="stylesheet" type="text/css"
    {{ Sri::html('assets/plugins/global/waitMe/waitMe.min.css') }} />

<!-- Custom Common css -->
<link href="{{ asset('assets/custom/css/divider.css') }}" rel="stylesheet" type="text/css"
    {{ Sri::html('assets/custom/css/divider.css') }} />

<!-- IziToast CSS-->
<link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">

@yield('page_css')

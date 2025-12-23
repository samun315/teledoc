        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
        <!-- Owl Carousel CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.carousel.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.theme.default.min.css') }}">
        <!-- Meanmenu CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/meanmenu.css') }}">
        <!-- Icofonts CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/icofont.min.css') }}">
        <!-- Slick Slider CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/slick-theme.min.css') }}">
        <!-- Magnific Popup CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/magnific-popup.min.css') }}">
        <!-- Animate CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
        <!-- Odometer CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/odometer.min.css') }}">
        <!-- Style CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
        <!-- Responsive CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
        <!-- Theme Dark CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/theme-dark.css') }}">

        <title>{{ $siteSettings['site_name'] ?? 'Medsev' }} - {{ $siteSettings['site_tagline'] ?? 'Healthcare Clinic & Doctor' }}</title>

        @if(!empty($siteSettings['meta_description']))
        <meta name="description" content="{{ $siteSettings['meta_description'] }}">
        @endif

        @if(!empty($siteSettings['meta_keywords']))
        <meta name="keywords" content="{{ $siteSettings['meta_keywords'] }}">
        @endif

        <link rel="icon" type="image/png" href="{{ $favicon }}">

        @stack('styles')

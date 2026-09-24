        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="index, follow">
        <meta name="theme-color" content="#0046c0">

        @php
            $pageTitle = trim($__env->yieldContent('title'));
            if ($pageTitle === '') {
                $pageTitle = ($siteSettings['site_name'] ?? 'Medsev') . ' - ' . ($siteSettings['site_tagline'] ?? 'Healthcare Clinic & Doctor');
            }
            $pageDescription = trim($__env->yieldContent('meta_description'));
            if ($pageDescription === '') {
                $pageDescription = $siteSettings['meta_description']
                    ?? 'Online healthcare platform providing quality, affordability and accessibility for medical consultations and healthcare solutions.';
            }
            $canonicalUrl = url()->current();
            $ogImage = $mainLogo ?? $favicon ?? asset('frontend/assets/img/home-one/4.jpg');
        @endphp

        <title>{{ $pageTitle }}</title>
        <meta name="description" content="{{ $pageDescription }}">
        @if(!empty($siteSettings['meta_keywords']))
        <meta name="keywords" content="{{ $siteSettings['meta_keywords'] }}">
        @endif

        <link rel="canonical" href="{{ $canonicalUrl }}">

        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ $canonicalUrl }}">
        <meta property="og:title" content="{{ $pageTitle }}">
        <meta property="og:description" content="{{ $pageDescription }}">
        <meta property="og:image" content="{{ $ogImage }}">
        <meta property="og:site_name" content="{{ $siteSettings['site_name'] ?? 'TeleDoc' }}">
        <meta property="og:locale" content="en_US">

        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="{{ $pageTitle }}">
        <meta name="twitter:description" content="{{ $pageDescription }}">
        <meta name="twitter:image" content="{{ $ogImage }}">

        <link rel="icon" type="image/png" href="{{ $favicon }}">

        <link rel="preload" href="{{ asset('frontend/assets/fonts/poppins/poppins-400.woff2') }}" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="{{ asset('frontend/assets/fonts/icofont.woff2') }}" as="font" type="font/woff2" crossorigin>

        @stack('head')

        <!-- Critical CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
        @stack('critical_styles')
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/meanmenu.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/icofont.min.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}?v={{ filemtime(public_path('frontend/assets/css/style.css')) }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/responsive.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/rich-text-content.css') }}">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/performance.css') }}">

        <!-- Non-critical CSS (async) -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}" media="print" onload="this.media='all'">
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/theme-dark.css') }}" media="print" onload="this.media='all'">
        <noscript>
            <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.min.css') }}">
            <link rel="stylesheet" href="{{ asset('frontend/assets/css/theme-dark.css') }}">
        </noscript>

        @stack('styles')

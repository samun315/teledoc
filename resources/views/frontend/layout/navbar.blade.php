<!-- Header Top -->
<div class="header-top">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-sm-9 col-lg-9">
                <div class="header-top-item">
                    <div class="header-top-left">
                        <ul>
                            @if(!empty($siteSettings['contact_phone_1']))
                            <li>
                                <a href="tel:{{ preg_replace('/\s+/', '', $siteSettings['contact_phone_1']) }}">
                                    <i class="icofont-ui-call" aria-hidden="true"></i>
                                    Call : {{ $siteSettings['contact_phone_1'] }}
                                </a>
                            </li>
                            @endif
                            @if(!empty($siteSettings['contact_whatsapp']))
                            <li>
                                <a href="https://wa.me/{{ str_replace([' ', '-', '(', ')', '+'], '', $siteSettings['contact_whatsapp']) }}" target="_blank" rel="noopener noreferrer">
                                    <i class="icofont-whatsapp" aria-hidden="true"></i>
                                    WhatsApp : {{ $siteSettings['contact_whatsapp'] }}
                                </a>
                            </li>
                            @endif
                            @if(!empty($siteSettings['contact_email_1']))
                            <li>
                                <a href="mailto:{{ $siteSettings['contact_email_1'] }}">
                                    <i class="icofont-ui-message" aria-hidden="true"></i>
                                    {{ $siteSettings['contact_email_1'] }}
                                </a>
                            </li>
                            @endif
                            @if(!empty($siteSettings['contact_address_1']))
                            <li>
                                <i class="icofont-location-pin" aria-hidden="true"></i>
                                {{ $siteSettings['contact_address_1'] }}
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 col-lg-3">
                <div class="header-top-item">
                    <div class="header-top-right">
                        <ul>
                            @foreach($socialMediaHeader as $social)
                            <li>
                                <a href="{{ $social->url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ ucfirst($social->platform ?? 'Social media') }}">
                                    <i class="{{ $social->icon_class }}" aria-hidden="true"></i>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Header Top -->
<!-- Start Navbar Area -->
<div class="navbar-area sticky-top">
    <!-- Menu For Mobile Device -->
    <div class="mobile-nav">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ $mobileLogo }}" alt="{{ $siteSettings['site_name'] ?? 'Site Logo' }}" width="120" height="40" decoding="async">
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light" aria-label="Main navigation">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ $mainLogo }}" alt="{{ $siteSettings['site_name'] ?? 'Site Logo' }}" width="160" height="50" decoding="async">
                </a>
                <div class="collapse navbar-collapse mean-menu" id="navbarSupportedContent">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">Home</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about') }}" class="nav-link">About</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('blog') }}" class="nav-link">Blog</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('service') }}" class="nav-link">Services</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('doctors') }}" class="nav-link ">Doctor</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payment-instructions') }}" class="nav-link ">Payment</a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contact-us') }}" class="nav-link">Contact Us</a>
                        </li>
                    </ul>
                    <div class="nav-srh">
                        <div class="search-toggle">
                            <button type="button" class="search-icon icon-search" aria-label="Open search">
                                <i class="icofont-search-1" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="search-icon icon-close" aria-label="Close search">
                                <i class="icofont-close" aria-hidden="true"></i>
                            </button>
                        </div>
                        <div class="search-area">
                            <form role="search" aria-label="Site search">
                                <label class="sr-only" for="search-terms">Search</label>
                                <input type="text" class="src-input" id="search-terms"
                                    placeholder="Search here..." name="q" autocomplete="off">
                                <button type="submit" name="submit" value="Go" class="search-icon" aria-label="Submit search">
                                    <i class="icofont-search-1" aria-hidden="true"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- End Navbar Area -->

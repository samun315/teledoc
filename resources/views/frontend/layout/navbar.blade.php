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
                                <a href="tel:{{ $siteSettings['contact_phone_1'] }}">
                                    <i class="icofont-ui-call"></i>
                                    Call : {{ $siteSettings['contact_phone_1'] }}
                                </a>
                            </li>
                            @endif
                            @if(!empty($siteSettings['contact_whatsapp']))
                            <li>
                                <a href="https://wa.me/{{ str_replace([' ', '-', '(', ')', '+'], '', $siteSettings['contact_whatsapp']) }}" target="_blank">
                                    <i class="icofont-whatsapp"></i>
                                    WhatsApp : {{ $siteSettings['contact_whatsapp'] }}
                                </a>
                            </li>
                            @endif
                            @if(!empty($siteSettings['contact_email_1']))
                            <li>
                                <a href="mailto:{{ $siteSettings['contact_email_1'] }}">
                                    <i class="icofont-ui-message"></i>
                                    {{ $siteSettings['contact_email_1'] }}
                                </a>
                            </li>
                            @endif
                            @if(!empty($siteSettings['contact_address_1']))
                            <li>
                                <i class="icofont-location-pin"></i>
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
                                <a href="{{ $social->url }}" target="_blank">
                                    <i class="{{ $social->icon_class }}"></i>
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
            <img src="{{ $mobileLogo }}" alt="{{ $siteSettings['site_name'] ?? 'Site Logo' }}">
        </a>
    </div>

    <!-- Menu For Desktop Device -->
    <div class="main-nav">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-light">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ $mainLogo }}" alt="{{ $siteSettings['site_name'] ?? 'Site Logo' }}">
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
                            <button class="search-icon icon-search"><i class="icofont-search-1"></i></button>
                            <button class="search-icon icon-close"><i class="icofont-close"></i></button>
                        </div>
                        <div class="search-area">
                            <form>
                                <input type="text" class="src-input" id="search-terms"
                                    placeholder="Search here...">
                                <button type="submit" name="submit" value="Go" class="search-icon"><i
                                        class="icofont-search-1"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</div>
<!-- End Navbar Area -->


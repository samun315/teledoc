<!-- Footer -->
        <footer class="pb-70">

            <!-- Newsletter -->
            {{-- <div class="newsletter-area">
                <div class="container">
                    <div class="row newsletter-wrap align-items-center">
                        <div class="col-lg-7">
                            <div class="newsletter-item">
                                <h2>Join Our Newsletter</h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod.</p>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="newsletter-item">
                                <div class="newsletter-form">
                                    <form class="newsletter-form" data-toggle="validator">
                                        <input type="email" class="form-control" placeholder="Enter Your Email" name="EMAIL" required="" autocomplete="off">

                                        <button class="btn newsletter-btn" type="submit">
                                            Subscribe
                                        </button>

                                        <div id="validator-newsletter" class="form-result"></div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            <!-- End Newsletter -->

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-lg-4">
                        <div class="footer-item">
                            <div class="footer-contact">
                                <div class="footer-logo mb-3">
                                    <a href="{{ route('home') }}">
                                        <img src="{{ $footerLogo }}" alt="{{ $siteSettings['site_name'] ?? 'Site Logo' }}" style="max-height: 100px;" width="180" height="100" loading="lazy" decoding="async">
                                    </a>
                                </div>
                                <h3>Contact Us</h3>
                                <ul>
                                    @if(!empty($siteSettings['contact_email_1']) || !empty($siteSettings['contact_email_2']))
                                    <li>
                                        <i class="icofont-ui-message"></i>
                                        @if(!empty($siteSettings['contact_email_1']))
                                        <a href="mailto:{{ $siteSettings['contact_email_1'] }}">{{ $siteSettings['contact_email_1'] }}</a>
                                        @endif
                                        @if(!empty($siteSettings['contact_email_2']))
                                        <a href="mailto:{{ $siteSettings['contact_email_2'] }}">{{ $siteSettings['contact_email_2'] }}</a>
                                        @endif
                                    </li>
                                    @endif
                                    @if(!empty($siteSettings['contact_phone_1']) || !empty($siteSettings['contact_phone_2']))
                                    <li>
                                        <i class="icofont-stock-mobile"></i>
                                        @if(!empty($siteSettings['contact_phone_1']))
                                        <a href="tel:{{ $siteSettings['contact_phone_1'] }}">Call: {{ $siteSettings['contact_phone_1'] }}</a>
                                        @endif
                                        @if(!empty($siteSettings['contact_phone_2']))
                                        <a href="tel:{{ $siteSettings['contact_phone_2'] }}">Call: {{ $siteSettings['contact_phone_2'] }}</a>
                                        @endif
                                    </li>
                                    @endif
                                    @if(!empty($siteSettings['contact_address_1']))
                                    <li>
                                        <i class="icofont-location-pin"></i>
                                        {{ $siteSettings['contact_address_1'] }}
                                        @if(!empty($siteSettings['contact_city']) || !empty($siteSettings['contact_country']))
                                        <br>
                                        {{ $siteSettings['contact_city'] ?? '' }} {{ $siteSettings['contact_country'] ?? '' }}
                                        @endif
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-2">
                        <div class="footer-item">
                            <div class="footer-quick">
                                <h3>Quick Links</h3>
                                <ul>
                                    @forelse($footerQuickLinks as $link)
                                    <li>
                                        <a href="{{ $link->url }}" target="{{ $link->target }}" @if($link->target === '_blank') rel="noopener noreferrer" @endif>
                                            @if($link->icon)
                                            <i class="{{ $link->icon }}" aria-hidden="true"></i>
                                            @endif
                                            {{ $link->title }}
                                        </a>
                                    </li>
                                    @empty
                                    <li><a href="{{ route('about') }}">About us</a></li>
                                    <li><a href="{{ route('blog') }}">Blog</a></li>
                                    <li><a href="{{ route('doctors') }}">Doctors</a></li>
                                    <li><a href="{{ route('contact-us') }}">Contact us</a></li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="footer-item">
                            <div class="footer-quick">
                                <h3>Our Services</h3>
                                <ul>
                                    @forelse($footerServices as $service)
                                    <li>
                                        <a href="{{ route('service-details', $service->service_id) }}">
                                            {{ $service->title }}
                                        </a>
                                    </li>
                                    @empty
                                    <li><a href="{{ route('service') }}">View All Services</a></li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="footer-item">
                            <div class="footer-feedback">
                                <h3>Feedback</h3>
                                <form id="feedbackForm" method="POST" action="{{ route('feedback.store') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="sr-only" for="feedback_name">Name</label>
                                        <input type="text" name="name" id="feedback_name" class="form-control" placeholder="Name" required autocomplete="name">
                                        <span class="error text-danger" id="error_name" role="alert"></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="feedback_phone">Phone</label>
                                        <input type="text" name="phone" id="feedback_phone" class="form-control" placeholder="Phone" required autocomplete="tel">
                                        <span class="error text-danger" id="error_phone" role="alert"></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="sr-only" for="feedback_message">Message</label>
                                        <textarea class="form-control" name="message" id="feedback_message" rows="5" placeholder="Message" required></textarea>
                                        <span class="error text-danger" id="error_message" role="alert"></span>
                                    </div>
                                    <div class="text-left">
                                        <button type="submit" class="btn feedback-btn" id="feedbackSubmitBtn">SUBMIT</button>
                                    </div>
                                    <div id="feedbackMessage" class="mt-2"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- End Footer -->

        <!-- Copyright -->
        <div class="copyright-area">
            <div class="container">
                <div class="copyright-item">
                    <p>{{ $siteSettings['copyright_text'] ?? '© ' . ($siteSettings['site_name'] ?? 'Medsev') . ' ' . date('Y') . '. All rights reserved.' }}</p>
                </div>
            </div>
        </div>
        <!-- End Copyright -->


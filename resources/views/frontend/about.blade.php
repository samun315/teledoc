@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-four">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>About</h2>
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>About</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- About -->
    @if($about)
    <div class="about-area pt-100 pb-70">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="about-item">
                        <div class="about-left">
                            <img src="{{ $about->left_image ? asset('storage/' . $about->left_image) : asset('frontend/assets/img/home-one/4.jpg') }}" alt="About">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-item about-right">
                        @if($about->right_image)
                        <img src="{{ asset('storage/' . $about->right_image) }}" alt="About">
                        @endif
                        <h2>{{ $about->title }}</h2>
                        <div class="about-description">{!! $about->description !!}</div>
                        @if($about->feature_1 || $about->feature_2 || $about->feature_3)
                        <ul>
                            @if($about->feature_1)
                            <li>
                                <i class="icofont-check-circled"></i>
                                {{ $about->feature_1 }}
                            </li>
                            @endif
                            @if($about->feature_2)
                            <li>
                                <i class="icofont-check-circled"></i>
                                {{ $about->feature_2 }}
                            </li>
                            @endif
                            @if($about->feature_3)
                            <li>
                                <i class="icofont-check-circled"></i>
                                {{ $about->feature_3 }}
                            </li>
                            @endif
                        </ul>
                        @endif
                        @if($about->button_text && $about->button_link)
                        @php
                            $buttonUrl = $about->button_link;
                            if (!str_starts_with($buttonUrl, '/') && !str_starts_with($buttonUrl, 'http')) {
                                try {
                                    $buttonUrl = route($buttonUrl);
                                } catch (\Exception $e) {
                                    $buttonUrl = '#' . $about->button_link;
                                }
                            }
                        @endphp
                        <a href="{{ $buttonUrl }}">{{ $about->button_text }}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- End About -->

    <!-- Counter -->
    <div class="counter-area counter-bg counter-area-four">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="counter-item">
                        <i class="icofont-patient-bed"></i>
                        <h3>
                            <span class="odometer" data-count="850">00</span>
                        </h3>
                        <p>Patients Beds</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="counter-item">
                        <i class="icofont-people"></i>
                        <h3>
                            <span class="odometer" data-count="2500">00</span>
                            <span class="target">+</span>
                        </h3>
                        <p>Happy Patients</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="counter-item">
                        <i class="icofont-doctor-alt"></i>
                        <h3>
                            <span class="odometer" data-count="750">00</span>
                        </h3>
                        <p>Doctors  & Nurse</p>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3 col-lg-3">
                    <div class="counter-item">
                        <i class="icofont-badge"></i>
                        <h3>
                            <span class="odometer" data-count="18">00</span>
                        </h3>
                        <p>Year Experience</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Counter -->

    <!-- Speciality -->
    <section class="speciality-area pb-100">
        <div class="container-fluid p-0">
            <div class="row m-0">
                <div class="col-lg-7">
                    <div class="speciality-left">
                        <div class="section-title-two">
                            <span>Speciality</span>
                            <h2>Our Expertise</h2>
                        </div>
                        <div class="speciality-item">
                            <div class="row m-0">
                                @forelse($specialities as $index => $speciality)
                                <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".{{ 3 + ($index % 2) * 2 }}s">
                                    <div class="speciality-inner">
                                        <i class="{{ $speciality->icon ?? 'icofont-check-circled' }}"></i>
                                        <h3>{{ $speciality->title }}</h3>
                                        <p>{{ $speciality->description }}</p>
                                    </div>
                                </div>
                                @empty
                                <div class="col-12 text-center py-5">
                                    <p class="text-muted">No specialities available at the moment.</p>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 pr-0">
                    <div class="speciality-item speciality-right">
                        <img src="assets/img/home-two/8.jpg" alt="Speciality">
                        <div class="speciality-emergency">
                            <div class="speciality-icon">
                                <i class="icofont-ui-call"></i>
                            </div>
                            <h3>Call Now</h3>
                            <a href="tel:+07554332322">+07 554 332 322</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Speciality -->

    <!-- Services -->
    <section class="services-area pb-70">
        <div class="container">
            <div class="section-title-two">
                <span>Services</span>
                <h2>Our Hospital Services</h2>
            </div>
            <div class="row justify-content-center">
                @forelse($services as $index => $service)
                <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".{{ 3 + ($index % 4) * 2 }}s">
                    <div class="service-item">
                        <div class="service-front">
                            <i class="{{ $service->icon ?? 'icofont-cog' }}"></i>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ Str::limit($service->short_description, 70) }}</p>
                        </div>
                        <div class="service-end">
                            <i class="{{ $service->icon ?? 'icofont-cog' }}"></i>
                            <h3>{{ $service->title }}</h3>
                            <p>{{ Str::limit($service->short_description, 70) }}</p>
                            <a href="{{ route('service-details', $service->service_id) }}">Read More</a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No services available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- End Services -->

    <!-- Testimonials -->
    <section class="testimonial-area ptb-100">
        <div class="container">
            <div class="testimonial-wrap">
                <h2>What our patient say</h2>

                <div class="testimonial-slider owl-theme owl-carousel">
                    @forelse($testimonials as $testimonial)
                        <div class="testimonial-item">
                            @if($testimonial->patient_image)
                                <img src="{{ asset('storage/' . $testimonial->patient_image) }}" alt="{{ $testimonial->patient_name }}">
                            @else
                                <img src="{{ asset('assets/img/home-three/7.png') }}" alt="{{ $testimonial->patient_name }}">
                            @endif
                            <h3>{{ $testimonial->patient_name }}</h3>
                            @if($testimonial->patient_designation)
                                <span class="designation">{{ $testimonial->patient_designation }}</span>
                            @endif
                            @if($testimonial->rating)
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="icofont-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-muted' }}"></i>
                                    @endfor
                                </div>
                            @endif
                            <p>{{ $testimonial->testimonial_text }}</p>
                        </div>
                    @empty
                        <div class="testimonial-item">
                            <img src="{{ asset('assets/img/home-three/7.png') }}" alt="Testimonial">
                            <h3>No Testimonials Yet</h3>
                            <p>We are collecting patient testimonials. Check back soon!</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- End Testimonials -->

    <!-- Blog -->
    <section class="blog-area pt-100 pb-70">
        <div class="container">
            <div class="section-title-two">
                <span>Blogs</span>
                <h2>Our latest blogs</h2>
            </div>
            <div class="row justify-content-center">
                @forelse($latestBlogs as $index => $latestBlog)
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ .3 + ($index * 0.2) }}s">
                    <div class="blog-item">
                        <div class="blog-top">
                            <a href="{{ route('blog-details', $latestBlog->slug) }}">
                                <img src="{{ $latestBlog->banner_image ? asset('storage/' . $latestBlog->banner_image) : asset('assets/img/home-one/11.jpg') }}" alt="{{ $latestBlog->title }}">
                            </a>
                        </div>
                        <div class="blog-bottom">
                            <h3>
                                <a href="{{ route('blog-details', $latestBlog->slug) }}">
                                    {{ $latestBlog->title }}
                                </a>
                            </h3>
                            <p>{{ Str::limit(strip_tags($latestBlog->content), 100, '....') }}</p>
                            <ul>
                                <li>
                                    <a href="{{ route('blog-details', $latestBlog->slug) }}">
                                        Read More
                                        <i class="icofont-long-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <i class="icofont-calendar"></i>
                                    {{ $latestBlog->published_at ? $latestBlog->published_at->format('M d, Y') : $latestBlog->created_at->format('M d, Y') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No recent blogs available</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- End Blog -->
@endsection

@section('page_script')
@endsection

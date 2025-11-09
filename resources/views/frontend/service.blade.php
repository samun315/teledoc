@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-four">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Our Services</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Services</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Services -->
    <section class="services-area pt-100 pb-70">
        <div class="container">
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

    <!-- Expertise -->
    <section class="expertise-area pb-70">
        <div class="container">
            <div class="section-title">
                <h2>Our Expertise</h2>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="expertise-item">
                        <div class="row justify-content-center">
                            <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                <a href="blog-details.html">
                                    <div class="expertise-inner">
                                        <i class="icofont-doctor-alt"></i>
                                        <h3>Certified Doctors</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                <a href="blog-details.html">
                                    <div class="expertise-inner">
                                        <i class="icofont-stretcher"></i>
                                        <h3>Emergency</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                <a href="blog-details.html">
                                    <div class="expertise-inner">
                                        <i class="icofont-network"></i>
                                        <h3>Teachnology</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                <a href="blog-details.html">
                                    <div class="expertise-inner">
                                        <i class="icofont-ambulance-cross"></i>
                                        <h3>Ambulance</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="expertise-item">
                        <div class="expertise-right">
                            <img src="assets/img/home-one/6.jpg" alt="Expertise">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Expertise -->

    <!-- Blog -->
    <section class="blog-area pt-100 pb-70">
        <div class="container">
            <div class="section-title">
                <h2>Our Latest Blogs</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                    <div class="blog-item">
                        <div class="blog-top">
                            <a href="blog-details.html">
                                <img src="assets/img/home-one/11.jpg" alt="Blog">
                            </a>
                        </div>
                        <div class="blog-bottom">
                            <h3>
                                <a href="blog-details.html">In this hospital there are special surgeon.</a>
                            </h3>
                            <p>Lorem ipsum is  dolor sit amet, csectetur adipiscing elit, dolore smod tempor incididunt ut labore et....</p>
                            <ul>
                                <li>
                                    <a href="blog-details.html">
                                        Read More
                                        <i class="icofont-long-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <i class="icofont-calendar"></i>
                                    Jan 03, 2024
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".5s">
                    <div class="blog-item">
                        <div class="blog-top">
                            <a href="blog-details.html">
                                <img src="assets/img/home-one/12.jpg" alt="Blog">
                            </a>
                        </div>
                        <div class="blog-bottom">
                            <h3>
                                <a href="blog-details.html">World AIDS Day, designated on 1 December.</a>
                            </h3>
                            <p>Lorem ipsum is  dolor sit amet, csectetur adipiscing elit, dolore smod tempor incididunt ut labore et....</p>
                            <ul>
                                <li>
                                    <a href="blog-details.html">
                                        Read More
                                        <i class="icofont-long-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <i class="icofont-calendar"></i>
                                    Jan 03, 2024
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6   col-lg-4 wow fadeInUp" data-wow-delay=".7s">
                    <div class="blog-item">
                        <div class="blog-top">
                            <a href="blog-details.html">
                                <img src="assets/img/home-one/13.jpg" alt="Blog">
                            </a>
                        </div>
                        <div class="blog-bottom">
                            <h3>
                                <a href="blog-details.html">More than 80 clinical trials launch to test coronavirus.</a>
                            </h3>
                            <p>Lorem ipsum is  dolor sit amet, csectetur adipiscing elit, dolore smod tempor incididunt ut labore et....</p>
                            <ul>
                                <li>
                                    <a href="blog-details.html">
                                        Read More
                                        <i class="icofont-long-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <i class="icofont-calendar"></i>
                                    Jan 03, 2024
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Blog -->
@endsection

@section('page_script')
@endsection

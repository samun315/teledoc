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
    @if($expertise)
    <section class="expertise-area pb-70">
        <div class="container">
            <div class="section-title">
                <h2>{{ $expertise->title }}</h2>
            </div>
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6">
                    <div class="expertise-item">
                        <div class="row justify-content-center">
                            @if($expertise->item_1_title)
                            <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                @php
                                    $link1 = $expertise->item_1_link ?? '#';
                                    if ($link1 && !str_starts_with($link1, '/') && !str_starts_with($link1, 'http')) {
                                        try {
                                            $link1 = route($link1);
                                        } catch (\Exception $e) {
                                            $link1 = '#' . $expertise->item_1_link;
                                        }
                                    }
                                @endphp
                                <a href="{{ $link1 }}">
                                    <div class="expertise-inner">
                                        @if($expertise->item_1_icon)
                                        <i class="{{ $expertise->item_1_icon }}"></i>
                                        @endif
                                        <h3>{{ $expertise->item_1_title }}</h3>
                                        @if($expertise->item_1_description)
                                        <p>{{ $expertise->item_1_description }}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                            @endif
                            @if($expertise->item_2_title)
                            <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                @php
                                    $link2 = $expertise->item_2_link ?? '#';
                                    if ($link2 && !str_starts_with($link2, '/') && !str_starts_with($link2, 'http')) {
                                        try {
                                            $link2 = route($link2);
                                        } catch (\Exception $e) {
                                            $link2 = '#' . $expertise->item_2_link;
                                        }
                                    }
                                @endphp
                                <a href="{{ $link2 }}">
                                    <div class="expertise-inner">
                                        @if($expertise->item_2_icon)
                                        <i class="{{ $expertise->item_2_icon }}"></i>
                                        @endif
                                        <h3>{{ $expertise->item_2_title }}</h3>
                                        @if($expertise->item_2_description)
                                        <p>{{ $expertise->item_2_description }}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                            @endif
                            @if($expertise->item_3_title)
                            <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                @php
                                    $link3 = $expertise->item_3_link ?? '#';
                                    if ($link3 && !str_starts_with($link3, '/') && !str_starts_with($link3, 'http')) {
                                        try {
                                            $link3 = route($link3);
                                        } catch (\Exception $e) {
                                            $link3 = '#' . $expertise->item_3_link;
                                        }
                                    }
                                @endphp
                                <a href="{{ $link3 }}">
                                    <div class="expertise-inner">
                                        @if($expertise->item_3_icon)
                                        <i class="{{ $expertise->item_3_icon }}"></i>
                                        @endif
                                        <h3>{{ $expertise->item_3_title }}</h3>
                                        @if($expertise->item_3_description)
                                        <p>{{ $expertise->item_3_description }}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                            @endif
                            @if($expertise->item_4_title)
                            <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                @php
                                    $link4 = $expertise->item_4_link ?? '#';
                                    if ($link4 && !str_starts_with($link4, '/') && !str_starts_with($link4, 'http')) {
                                        try {
                                            $link4 = route($link4);
                                        } catch (\Exception $e) {
                                            $link4 = '#' . $expertise->item_4_link;
                                        }
                                    }
                                @endphp
                                <a href="{{ $link4 }}">
                                    <div class="expertise-inner">
                                        @if($expertise->item_4_icon)
                                        <i class="{{ $expertise->item_4_icon }}"></i>
                                        @endif
                                        <h3>{{ $expertise->item_4_title }}</h3>
                                        @if($expertise->item_4_description)
                                        <p>{{ $expertise->item_4_description }}</p>
                                        @endif
                                    </div>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="expertise-item">
                        <div class="expertise-right">
                            <img src="{{ $expertise->image ? asset('storage/' . $expertise->image) : asset('frontend/assets/img/home-one/6.jpg') }}" alt="Expertise">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif
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

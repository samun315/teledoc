    @extends('frontend.master')
        @section('content')
            <!-- Start Home Slider -->
            @include('frontend.layout.slider');
            <!-- End Home Slider -->

            <!-- Counter -->
            {{-- <div class="counter-area">
                <div class="container">
                    <div class="row counter-bg">
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
                                <p>Doctors & Nurse</p>
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
            </div> --}}
            <!-- End Counter -->

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
                                <p>{{ $about->description }}</p>
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

            <!-- Services -->
            <section class="services-area pb-70">
                <div class="container">
                    <div class="section-title">
                        <h2>Our Services</h2>
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

            <!-- Video -->
            {{-- <div class="video-wrap">
                <div class="container-fluid p-0">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel"
                            aria-labelledby="pills-home-tab">
                            <div class="video-area">
                                <div class="d-table">
                                    <div class="d-table-cell">
                                        <div class="container">
                                            <div class="video-item">
                                                <a href="http://www.youtube.com/watch?v=0O2aH4XLbto"
                                                    class="popup-youtube">
                                                    <i class="icofont-ui-play"></i>
                                                </a>
                                                <div class="video-content">
                                                    <h3>Hospital Introduction</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis
                                                        ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                                                        accumsan lacus vel facilisis. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel"
                            aria-labelledby="pills-profile-tab">
                            <div class="video-area">
                                <div class="d-table">
                                    <div class="d-table-cell">
                                        <div class="container">
                                            <div class="video-item">
                                                <a href="http://www.youtube.com/watch?v=0O2aH4XLbto"
                                                    class="popup-youtube">
                                                    <i class="icofont-ui-play"></i>
                                                </a>
                                                <div class="video-content">
                                                    <h3>About Our Pharmacy</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis
                                                        ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                                                        accumsan lacus vel facilisis. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel"
                            aria-labelledby="pills-contact-tab">
                            <div class="video-area">
                                <div class="d-table">
                                    <div class="d-table-cell">
                                        <div class="container">
                                            <div class="video-item">
                                                <a href="http://www.youtube.com/watch?v=0O2aH4XLbto"
                                                    class="popup-youtube">
                                                    <i class="icofont-ui-play"></i>
                                                </a>
                                                <div class="video-content">
                                                    <h3>Our reasearch center and lab </h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis
                                                        ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                                                        accumsan lacus vel facilisis. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-icu" role="tabpanel" aria-labelledby="pills-icu-tab">
                            <div class="video-area">
                                <div class="d-table">
                                    <div class="d-table-cell">
                                        <div class="container">
                                            <div class="video-item">
                                                <a href="http://www.youtube.com/watch?v=0O2aH4XLbto"
                                                    class="popup-youtube">
                                                    <i class="icofont-ui-play"></i>
                                                </a>
                                                <div class="video-content">
                                                    <h3>CCU & ICU</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis
                                                        ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                                                        accumsan lacus vel facilisis. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-doctor" role="tabpanel" aria-labelledby="pills-doctor-tab">
                            <div class="video-area">
                                <div class="d-table">
                                    <div class="d-table-cell">
                                        <div class="container">
                                            <div class="video-item">
                                                <a href="http://www.youtube.com/watch?v=0O2aH4XLbto"
                                                    class="popup-youtube">
                                                    <i class="icofont-ui-play"></i>
                                                </a>
                                                <div class="video-content">
                                                    <h3>Our Doctors</h3>
                                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do
                                                        eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis
                                                        ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas
                                                        accumsan lacus vel facilisis. </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <ul class="video-nav nav nav-pills" id="pills-tab" role="tablist">
                        <li class="nav-item video-nav-item">
                            <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home"
                                role="tab" aria-controls="pills-home" aria-selected="true">Hospital Introduction</a>
                        </li>
                        <li class="nav-item video-nav-item">
                            <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile"
                                role="tab" aria-controls="pills-profile" aria-selected="false">Pharmacy</a>
                        </li>
                        <li class="nav-item video-nav-item">
                            <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact"
                                role="tab" aria-controls="pills-contact" aria-selected="false">Reasearch & Lab</a>
                        </li>

                        <li class="nav-item video-nav-item">
                            <a class="nav-link" id="pills-icu-tab" data-bs-toggle="pill" href="#pills-icu"
                                role="tab" aria-controls="pills-icu" aria-selected="false">CCU & ICU</a>
                        </li>
                        <li class="nav-item video-nav-item">
                            <a class="nav-link" id="pills-doctor-tab" data-bs-toggle="pill" href="#pills-doctor"
                                role="tab" aria-controls="pills-doctor" aria-selected="false">Doctors</a>
                        </li>
                    </ul>
                </div>
            </div> --}}
            <!-- End Video -->

            <!-- Doctors -->
            <section class="doctors-area ptb-100">
                <div class="container">
                    <div class="section-title">
                        <h2>Meet Our Doctors</h2>
                    </div>
                    <div class="row justify-content-center">
                        @forelse($doctors as $index => $doctor)
                            @php
                                $delays = ['.3s', '.5s', '.7s'];
                                $delay = $delays[$index % 3];
                                $photoPath = $doctor->photo ? asset('uploads/doctor/' . $doctor->photo) : asset('frontend/assets/img/home-one/doctor/1.jpg');
                            @endphp
                            <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ $delay }}">
                                <div class="doctor-item">
                                    <div class="doctor-top">
                                        <img src="{{ $photoPath }}" alt="{{ $doctor->name }}" style="width: 100%; height: 350px; object-fit: cover;">
                                        <a href="{{ route('appointment.create') }}?doctor_id={{ $doctor->doctor_id }}">Get Appointment</a>
                                    </div>
                                    <div class="doctor-bottom">
                                        <h3>
                                            <a href="{{ route('doctor-details', $doctor->doctor_id) }}">{{ $doctor->title }} {{ $doctor->name }}</a>
                                        </h3>
                                        <span>{{ $doctor->department->department_name ?? 'General' }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5">
                                <p class="text-muted">No doctors available at the moment.</p>
                            </div>
                        @endforelse
                    </div>
                    <div class="doctor-btn">
                        <a href="{{ route('doctors') }}">See All</a>
                    </div>
                </div>
            </section>
            <!-- End Doctors -->

            <!-- Blog -->
            <section class="blog-area pt-100 pb-70">
                <div class="container">
                    <div class="section-title">
                        <h2>Our Latest Blogs</h2>
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

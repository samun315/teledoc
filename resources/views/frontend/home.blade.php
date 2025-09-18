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
            <div class="about-area pt-100 pb-70">
                <div class="container">
                    <div class="row align-items-center justify-content-center">
                        <div class="col-lg-6">
                            <div class="about-item">
                                <div class="about-left">
                                    <img src="frontend/assets/img/home-one/4.jpg" alt="About">
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="about-item about-right">
                                <img src="frontend/assets/img/home-one/5.png" alt="About">
                                <h2>About </h2>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
                                    ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo
                                    viverra maecenas accumsan lacus vel facilisis. </p>
                                <ul>
                                    <li>
                                        <i class="icofont-check-circled"></i>
                                        Browse Our Website
                                    </li>
                                    <li>
                                        <i class="icofont-check-circled"></i>
                                        Choose Service
                                    </li>
                                    <li>
                                        <i class="icofont-check-circled"></i>
                                        Send Messege
                                    </li>
                                </ul>
                                <a href="about.html">Know More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End About -->

            <!-- Services -->
            <section class="services-area pb-70">
                <div class="container">
                    <div class="section-title">
                        <h2>Our Services</h2>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".3s">
                            <div class="service-item">
                                <div class="service-front">
                                    <i class="icofont-doctor"></i>
                                    <h3>Expert Doctor</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                </div>
                                <div class="service-end">
                                    <i class="icofont-doctor"></i>
                                    <h3>Expert Doctor</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                    <a href="service-details.html">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".5s">
                            <div class="service-item">
                                <div class="service-front">
                                    <i class="icofont-prescription"></i>
                                    <h3>Diagnosis</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                </div>
                                <div class="service-end">
                                    <i class="icofont-prescription"></i>
                                    <h3>Diagnosis</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                    <a href="service-details.html">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".7s">
                            <div class="service-item">
                                <div class="service-front">
                                    <i class="icofont-patient-file"></i>
                                    <h3>Pathology</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                </div>
                                <div class="service-end">
                                    <i class="icofont-patient-file"></i>
                                    <h3>Pathology</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                    <a href="service-details.html">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".9s">
                            <div class="service-item">
                                <div class="service-front">
                                    <i class="icofont-tooth"></i>
                                    <h3>Dental Care</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                </div>
                                <div class="service-end">
                                    <i class="icofont-tooth"></i>
                                    <h3>Dental Care</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                    <a href="service-details.html">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".3s">
                            <div class="service-item">
                                <div class="service-front">
                                    <i class="icofont-heart-beat-alt"></i>
                                    <h3>Cardiology</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                </div>
                                <div class="service-end">
                                    <i class="icofont-heart-beat-alt"></i>
                                    <h3>Cardiology</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                    <a href="service-details.html">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".5s">
                            <div class="service-item">
                                <div class="service-front">
                                    <i class="icofont-drug"></i>
                                    <h3>Medicine</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                </div>
                                <div class="service-end">
                                    <i class="icofont-drug"></i>
                                    <h3>Medicine</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                    <a href="service-details.html">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".7s">
                            <div class="service-item">
                                <div class="service-front">
                                    <i class="icofont-dna-alt-1"></i>
                                    <h3>Neurology</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                </div>
                                <div class="service-end">
                                    <i class="icofont-dna-alt-1"></i>
                                    <h3>Neurology</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                    <a href="service-details.html">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".9s">
                            <div class="service-item">
                                <div class="service-front">
                                    <i class="icofont-ambulance-cross"></i>
                                    <h3>Ambulance</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                </div>
                                <div class="service-end">
                                    <i class="icofont-ambulance-cross"></i>
                                    <h3>Ambulance</h3>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod</p>
                                    <a href="service-details.html">Read More</a>
                                </div>
                            </div>
                        </div>
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
                                    <img src="frontend/assets/img/home-one/6.jpg" alt="Expertise">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
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
                        <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                            <div class="doctor-item">
                                <div class="doctor-top">
                                    <img src="frontend/assets/img/home-one/doctor/1.jpg" alt="Doctor">
                                    <a href="appointment.html">Get Appointment</a>
                                </div>
                                <div class="doctor-bottom">
                                    <h3>
                                        <a href="doctor-details.html">Dr. Babatunde</a>
                                    </h3>
                                    <span>Neurosurgeon</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".5s">
                            <div class="doctor-item">
                                <div class="doctor-top">
                                    <img src="frontend/assets/img/home-one/doctor/2.jpg" alt="Doctor">
                                    <a href="appointment.html">Get Appointment</a>
                                </div>
                                <div class="doctor-bottom">
                                    <h3>
                                        <a href="doctor-details.html">Dr. Addision Smith</a>
                                    </h3>
                                    <span>Neurosurgeon</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6   col-lg-4 wow fadeInUp" data-wow-delay=".7s">
                            <div class="doctor-item">
                                <div class="doctor-top">
                                    <img src="frontend/assets/img/home-one/doctor/3.jpg" alt="Doctor">
                                    <a href="appointment.html">Get Appointment</a>
                                </div>
                                <div class="doctor-bottom">
                                    <h3>
                                        <a href="doctor-details.html">Dr. Sarah Tylor</a>
                                    </h3>
                                    <span>Dental Surgeon</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="doctor-btn">
                        <a href="doctor.html">See All</a>
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
                        <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                            <div class="blog-item">
                                <div class="blog-top">
                                    <a href="blog-details.html">
                                        <img src="frontend/assets/img/home-one/11.jpg" alt="Blog">
                                    </a>
                                </div>
                                <div class="blog-bottom">
                                    <h3>
                                        <a href="blog-details.html">In this hospital there are special surgeon.</a>
                                    </h3>
                                    <p>Lorem ipsum is dolor sit amet, csectetur adipiscing elit, dolore smod tempor
                                        incididunt ut labore et....</p>
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
                                        <img src="frontend/assets/img/home-one/12.jpg" alt="Blog">
                                    </a>
                                </div>
                                <div class="blog-bottom">
                                    <h3>
                                        <a href="blog-details.html">World AIDS Day, designated on 1 December.</a>
                                    </h3>
                                    <p>Lorem ipsum is dolor sit amet, csectetur adipiscing elit, dolore smod tempor
                                        incididunt ut labore et....</p>
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
                                        <img src="frontend/assets/img/home-one/13.jpg" alt="Blog">
                                    </a>
                                </div>
                                <div class="blog-bottom">
                                    <h3>
                                        <a href="blog-details.html">More than 80 clinical trials launch to test
                                            coronavirus.</a>
                                    </h3>
                                    <p>Lorem ipsum is dolor sit amet, csectetur adipiscing elit, dolore smod tempor
                                        incididunt ut labore et....</p>
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

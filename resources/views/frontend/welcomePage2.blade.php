    @extends('frontend.master')
        @section('content')
            <!-- Start Home Slider -->
            @include('frontend.layout.slider');
            <!-- End Home Slider -->

            <!-- Emergency -->
        <div class="emergency-area">
            <div class="container">
                <div class="row emergency-bg">
                    <div class="col-sm-6 col-lg-4">
                        <div class="emergency-item">
                            <i class="icofont-ui-call"></i>
                            <div class="emergency-inner">
                                <h3>Emergency Call</h3>
                                <a href="tel:+0755543332322">+07 5554 3332 322</a>
                                <a href="tel:+0754647665322">+07 5464 7665 322</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="emergency-item">
                            <i class="icofont-location-pin"></i>
                            <div class="emergency-inner">
                                <h3>Location</h3>
                                <p>2108-267 Road Quadra, Toronto, Canada Victiria Canada</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6   col-lg-4">
                        <div class="emergency-item">
                            <i class="icofont-ambulance-crescent"></i>
                            <div class="emergency-inner">
                                <h3>Ambulance</h3>
                                <a href="tel:+0754566456322">+07 5456 6456 322</a>
                                <a href="tel:+075554335456">+07 5554 3335 456</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Emergency -->

        <!-- Welcome -->
        <section class="welcome-area ptb-100">
            <div class="container-fluid p-0">
                <div class="row m-0">
                    <div class="col-lg-6 p-0">
                        <div class="welcome-item welcome-left">
                            <img src="assets/img/home-two/3.jpg" alt="image">
                        </div>
                    </div>
                    <div class="col-lg-6 p-0">
                        <div class="welcome-item welcome-right">
                            <div class="section-title-two">
                                <span>About Us</span>
                                <h2>Welcome to Mediserv Hospital. We have...</h2>
                            </div>
                            <ul>
                                <li class="wow fadeInUp" data-wow-delay=".3s">
                                    <i class="icofont-doctor-alt"></i>
                                    <div class="welcome-inner">
                                        <h3>Certified Doctors</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.consectetur adipiscing elit.</p>
                                    </div>
                                </li>
                                <li class="wow fadeInUp" data-wow-delay=".5s">
                                    <i class="icofont-stretcher"></i>
                                    <div class="welcome-inner">
                                        <h3>Emergency 24 hours</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.consectetur adipiscing elit.</p>
                                    </div>
                                </li>
                                <li class="wow fadeInUp" data-wow-delay=".7s">
                                    <i class="icofont-network"></i>
                                    <div class="welcome-inner">
                                        <h3>Modern Technologey</h3>
                                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.consectetur adipiscing elit.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Welcome -->

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
                                    <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                        <div class="speciality-inner">
                                            <i class="icofont-check-circled"></i>
                                            <h3>Child Care</h3>
                                            <p>Lorem ipsum dolor sit amet, is consectetur adipiscing</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                        <div class="speciality-inner">
                                            <i class="icofont-check-circled"></i>
                                            <h3>More Stuff</h3>
                                            <p>Lorem ipsum dolor sit amet, is consectetur adipiscing</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".3s">
                                        <div class="speciality-inner">
                                            <i class="icofont-check-circled"></i>
                                            <h3>Enough Lab</h3>
                                            <p>Lorem ipsum dolor sit amet, is consectetur adipiscing</p>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-6 wow fadeInUp" data-wow-delay=".5s">
                                        <div class="speciality-inner">
                                            <i class="icofont-check-circled"></i>
                                            <h3>24 Hour Doctor</h3>
                                            <p>Lorem ipsum dolor sit amet, is consectetur adipiscing</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 pr-0">
                        <div class="speciality-item speciality-right">
                            <img src="assets/img/home-two/4.jpg" alt="Speciality">
                            <div class="speciality-emergency">
                                <div class="speciality-icon">
                                    <i class="icofont-ui-call"></i>
                                </div>
                                <h3>Emergency Call</h3>
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
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".3s">
                        <div class="service-item">
                            <div class="d-table">
                                <div class="d-table-cell">
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
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".5s">
                        <div class="service-item">
                            <div class="d-table">
                                <div class="d-table-cell">
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
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".7s">
                        <div class="service-item">
                            <div class="d-table">
                                <div class="d-table-cell">
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
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".9s">
                        <div class="service-item">
                            <div class="d-table">
                                <div class="d-table-cell">
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
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".3s">
                        <div class="service-item">
                            <div class="d-table">
                                <div class="d-table-cell">
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
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".5s">
                        <div class="service-item">
                            <div class="d-table">
                                <div class="d-table-cell">
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
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".7s">
                        <div class="service-item">
                            <div class="d-table">
                                <div class="d-table-cell">
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
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3 wow fadeInUp" data-wow-delay=".9s">
                        <div class="service-item">
                            <div class="d-table">
                                <div class="d-table-cell">
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
                </div>
            </div>
        </section>
        <!-- End Services -->

        <!-- Video -->
        <div class="video-wrap video-wrap-two">
            <div class="container-fluid p-0">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                        <div class="video-area">
                            <div class="d-table">
                                <div class="d-table-cell">
                                    <div class="container">
                                        <div class="video-item">
                                            <a href="http://www.youtube.com/watch?v=0O2aH4XLbto" class="popup-youtube">
                                                <i class="icofont-ui-play"></i>
                                            </a>
                                            <div class="video-content">
                                                <h3>Hospital Introduction</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <div class="video-area">
                            <div class="d-table">
                                <div class="d-table-cell">
                                    <div class="container">
                                        <div class="video-item">
                                            <a href="http://www.youtube.com/watch?v=0O2aH4XLbto" class="popup-youtube">
                                                <i class="icofont-ui-play"></i>
                                            </a>
                                            <div class="video-content">
                                                <h3>About Our Pharmacy</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <div class="video-area">
                            <div class="d-table">
                                <div class="d-table-cell">
                                    <div class="container">
                                        <div class="video-item">
                                            <a href="http://www.youtube.com/watch?v=0O2aH4XLbto" class="popup-youtube">
                                                <i class="icofont-ui-play"></i>
                                            </a>
                                            <div class="video-content">
                                                <h3>Our reasearch  center and  lab </h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
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
                                            <a href="http://www.youtube.com/watch?v=0O2aH4XLbto" class="popup-youtube">
                                                <i class="icofont-ui-play"></i>
                                            </a>
                                            <div class="video-content">
                                                <h3>CCU & ICU</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
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
                                            <a href="http://www.youtube.com/watch?v=0O2aH4XLbto" class="popup-youtube">
                                                <i class="icofont-ui-play"></i>
                                            </a>
                                            <div class="video-content">
                                                <h3>Our Doctors</h3>
                                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Quis ipsum suspendisse ultrices gravida. Risus commodo viverra maecenas accumsan lacus vel facilisis. </p>
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
                        <a class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Hospital Introduction</a>
                    </li>
                    <li class="nav-item video-nav-item">
                        <a class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Pharmacy</a>
                    </li>
                    <li class="nav-item video-nav-item">
                        <a class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Reasearch & Lab</a>
                    </li>

                    <li class="nav-item video-nav-item">
                        <a class="nav-link" id="pills-icu-tab" data-bs-toggle="pill" href="#pills-icu" role="tab" aria-controls="pills-icu" aria-selected="false">CCU & ICU</a>
                    </li>
                    <li class="nav-item video-nav-item">
                        <a class="nav-link" id="pills-doctor-tab" data-bs-toggle="pill" href="#pills-doctor" role="tab" aria-controls="pills-doctor" aria-selected="false">Doctors</a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- End Video -->

        <!-- Doctors -->
        <section class="doctors-area pt-100">
            <div class="container">
                <div class="section-title-two">
                    <span>Doctors</span>
                    <h2>Meet Our Doctors </h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                        <div class="doctor-item">
                            <div class="doctor-top">
                                <img src="assets/img/home-one/doctor/1.jpg" alt="Doctor">
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
                                <img src="assets/img/home-one/doctor/2.jpg" alt="Doctor">
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
                                <img src="assets/img/home-one/doctor/3.jpg" alt="Doctor">
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

        <!-- Counter -->
        <div class="counter-area counter-area-two">
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

        <!-- Appointment -->
        <section class="appointment-area pb-100">
            <div class="container-fluid p-0">
                <div class="appointment-item">
                    <h2>Book your appointment</h2>
                    <span>We will confirm your  appointment within 2 hours</span>
                    <div class="appointment-form">
                        <form>
                            <div class="row justify-content-center">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <i class="icofont-business-man-alt-1"></i>
                                        <label>Name</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Name">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <i class="icofont-ui-message"></i>
                                        <label>Email</label>
                                        <input type="email" class="form-control" placeholder="Enter Your Email">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <i class="icofont-ui-call"></i>
                                        <label>Phone</label>
                                        <input type="text" class="form-control" placeholder="Enter Your Number">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <i class="icofont-hospital"></i>
                                        <label>Services</label>
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>Dental Care</option>
                                            <option>Neurology</option>
                                            <option>Cardiology</option>
                                            <option>Pathology</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <i class="icofont-doctor"></i>
                                        <label>Doctor</label>
                                        <select class="form-control" id="exampleFormControlSelect1">
                                            <option>Choose Your Doctor</option>
                                            <option>John Smith</option>
                                            <option>Sarah Taylor</option>
                                            <option>Stevn King</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <i class="icofont-business-man"></i>
                                        <label>Age</label>
                                        <input type="text" class="form-control" placeholder="Your Age">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn appointment-btn">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Appointment -->

        <!-- Blog -->
        <section class="blog-area pt-100 pb-70">
            <div class="container">
                <div class="section-title-two">
                    <span>Blogs</span>
                    <h2>Our latest blogs</h2>
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

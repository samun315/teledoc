@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-one">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Meet Our Qualified Doctors</h2>
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Doctors</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Doctor Search -->
    <div class="doctor-search-area">
        <div class="container">
            <form>
                <div class="row doctor-search-wrap">
                    <div class="col-sm-6 col-lg-6">
                        <div class="doctor-search-item">
                            <div class="form-group">
                                <i class="icofont-doctor-alt"></i>
                                <label>Search</label>
                                <input type="text" class="form-control" placeholder="Doctor Name">
                            </div>
                            <button type="submit" class="btn doctor-search-btn">
                                <i class="icofont-search-1"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-6">
                        <div class="doctor-search-item">
                            <div class="form-group">
                                <i class="icofont-hospital"></i>
                                <label>Category</label>
                                <select class="form-control">
                                    <option>Neurosurgeon</option>
                                    <option>Cardiology</option>
                                    <option>Pathology</option>
                                    <option>Dental Care</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Doctor Search -->

    <!-- Doctors -->
    <section class="doctors-area doctors-area-two pt-100">
        <div class="container">
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
                                <a href="doctor-details.html">Dr. Addition Smith</a>
                            </h3>
                            <span>Neurosurgeon</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".7s">
                    <div class="doctor-item">
                        <div class="doctor-top">
                            <img src="assets/img/home-one/doctor/3.jpg" alt="Doctor">
                            <a href="appointment.html">Get Appointment</a>
                        </div>
                        <div class="doctor-bottom">
                            <h3>
                                <a href="doctor-details.html">Dr. Sarah Taylor</a>
                            </h3>
                            <span>Dental Surgeon</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                    <div class="doctor-item">
                        <div class="doctor-top">
                            <img src="assets/img/home-one/doctor/4.jpg" alt="Doctor">
                            <a href="appointment.html">Get Appointment</a>
                        </div>
                        <div class="doctor-bottom">
                            <h3>
                                <a href="doctor-details.html">Dr. Mac Smith</a>
                            </h3>
                            <span>Neurosurgeon</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".5s">
                    <div class="doctor-item">
                        <div class="doctor-top">
                            <img src="assets/img/home-one/doctor/5.jpg" alt="Doctor">
                            <a href="appointment.html">Get Appointment</a>
                        </div>
                        <div class="doctor-bottom">
                            <h3>
                                <a href="doctor-details.html">Dr. Alinson Backer</a>
                            </h3>
                            <span>Neurosurgeon</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".7s">
                    <div class="doctor-item">
                        <div class="doctor-top">
                            <img src="assets/img/home-one/doctor/6.jpg" alt="Doctor">
                            <a href="appointment.html">Get Appointment</a>
                        </div>
                        <div class="doctor-bottom">
                            <h3>
                                <a href="doctor-details.html">Dr. Jas Macham</a>
                            </h3>
                            <span>Dental Surgeon</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".3s">
                    <div class="doctor-item">
                        <div class="doctor-top">
                            <img src="assets/img/home-one/doctor/7.jpg" alt="Doctor">
                            <a href="appointment.html">Get Appointment</a>
                        </div>
                        <div class="doctor-bottom">
                            <h3>
                                <a href="doctor-details.html">Dr. John Micheal</a>
                            </h3>
                            <span>Neurosurgeon</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay=".5s">
                    <div class="doctor-item">
                        <div class="doctor-top">
                            <img src="assets/img/home-one/doctor/8.jpg" alt="Doctor">
                            <a href="appointment.html">Get Appointment</a>
                        </div>
                        <div class="doctor-bottom">
                            <h3>
                                <a href="doctor-details.html">Dr. Shane Warne</a>
                            </h3>
                            <span>Neurosurgeon</span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6   col-lg-4 wow fadeInUp" data-wow-delay=".7s">
                    <div class="doctor-item">
                        <div class="doctor-top">
                            <img src="assets/img/home-one/doctor/9.jpg" alt="Doctor">
                            <a href="appointment.html">Get Appointment</a>
                        </div>
                        <div class="doctor-bottom">
                            <h3>
                                <a href="doctor-details.html">Dr. Luis Moris</a>
                            </h3>
                            <span>Dental Surgeon</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Doctors -->
@endsection

@section('page_script')
@endsection

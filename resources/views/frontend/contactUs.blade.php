@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-five">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Contact Us</h2>
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Contact us</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Location -->
    <div class="location-area">
        <div class="container">
            <div class="row location-wrap">
                <div class="col-sm-6 col-lg-4">
                    <div class="location-item">
                        <i class="icofont-location-pin"></i>
                        <h3>Location</h3>
                        <p>2108-267 Road Quadra,Toronto,<br> Victiria Canada</p>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-4">
                    <div class="location-item">
                        <i class="icofont-ui-message"></i>
                        <h3>Email</h3>
                        <ul>
                            <li>
                                <a href="/cdn-cgi/l/email-protection#e9818c858586a9848c8d9a8c9fc78a8684"><span class="__cf_email__" data-cfemail="7e161b1212113e131b1a0d1b08501d1113">[email&#160;protected]</span></a>
                            </li>
                            <li>
                                <a href="/cdn-cgi/l/email-protection#553038343c39302d3438253930153b3438307b363a38"><span class="__cf_email__" data-cfemail="a5c0c8c4ccc9c0ddc4c8d5c9c0e5cbc4c8c08bc6cac8">[email&#160;protected]</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6   col-lg-4">
                    <div class="location-item">
                        <i class="icofont-ui-call"></i>
                        <h3>Phone</h3>
                        <ul>
                            <li>
                                <a href="tel:+07 5554 3332 322">+07 5554 3332 322</a>
                            </li>
                            <li>
                                <a href="tel:+07 5554 3332 322">+07 5554 3332 322</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Location -->

    <!-- Drop -->
    <section class="drop-area pt-100">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-lg-7 p-0">
                    <div class="drop-item drop-img">
                        <div class="drop-left">
                            <h2>Drop your message for any info or question.</h2>
                            <form id="contactForm">
                                <div class="row justify-content-center">
                                    <div class="col-sm-6 col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="name" id="name" class="form-control" required="" data-error="Please enter your name" placeholder="Name">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6">
                                        <div class="form-group">
                                            <input type="email" name="email" id="email" class="form-control" required="" data-error="Please enter your email" placeholder="Email">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="phone_number" id="phone_number" required="" data-error="Please enter your number" class="form-control" placeholder="Phone">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-sm-6 col-lg-6">
                                        <div class="form-group">
                                            <input type="text" name="msg_subject" id="msg_subject" class="form-control" required="" data-error="Please enter your subject" placeholder="Subject">
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12">
                                        <div class="form-group">
                                            <textarea name="message" class="form-control" id="message" cols="30" rows="5" required="" data-error="Write your message" placeholder="Your Message"></textarea>
                                            <div class="help-block with-errors"></div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <div class="form-check agree-label">
                                                <input name="gridCheck" value="I agree to the terms and privacy policy." class="form-check-input" type="checkbox" id="gridCheck" required="">

                                                <label class="form-check-label" for="gridCheck">
                                                    Accept <a href="terms-condition.html">Terms & Conditions</a> And <a href="privacy-policy.html">Privacy Policy.</a>
                                                </label>
                                                <div class="help-block with-errors gridCheck-error"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-lg-12">
                                        <button type="submit" class="drop-btn">
                                            Send
                                        </button>
                                        <div id="msgSubmit" class="h3 text-center hidden"></div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 p-0">
                    <div class="speciality-item speciality-right speciality-right-two speciality-right-three">
                        <img src="assets/img/home-two/4.jpg" alt="Contact">
                        <div class="speciality-emergency">
                            <div class="speciality-icon">
                                <i class="icofont-ui-call"></i>
                            </div>
                            <h3>Emergency Call</h3>
                            <p>+07 554 332 322</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Drop -->

    <!-- Map -->
    <iframe id="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59843174.53779285!2d62.17507173408571!3d23.728204508550363!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3663f18a24cbe857%3A0xa9416bfcd3a0f459!2sAsia!5e0!3m2!1sen!2sbd!4v1609366033158!5m2!1sen!2sbd" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
    <!-- End Map -->
@endsection

@section('page_script')
@endsection

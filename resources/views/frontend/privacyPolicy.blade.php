@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-four">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Privacy Policy</h2>
                    <ul>
                        <li>
                            <a href="index.html">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Privacy Policy</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Privacy Policy -->
    <section class="faq-area pt-100 pb-70">
        <div class="container">
            <div class="row faq-wrap">
                <div class="col-lg-12">
                    @if($privacyPolicy && $privacyPolicy->privacy_policy)
                        <div class="privacy-policy-content">
                            {!! $privacyPolicy->privacy_policy !!}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted">Privacy policy content is not available at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- End Privacy Policy -->
@endsection

@section('page_script')
@endsection

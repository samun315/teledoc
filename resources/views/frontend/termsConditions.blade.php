@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-four">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Terms & Conditions</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Terms & Conditions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Terms & Conditions -->
    <section class="faq-area pt-100 pb-70">
        <div class="container">
            <div class="row faq-wrap">
                <div class="col-lg-12">
                    @if($termsConditions && $termsConditions->terms_conditions)
                        <div class="terms-conditions-content">
                            {!! $termsConditions->terms_conditions !!}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <p class="text-muted">Terms and conditions content is not available at the moment.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- End Terms & Conditions -->
@endsection

@section('page_script')
@endsection

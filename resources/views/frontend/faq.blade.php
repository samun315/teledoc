@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-four">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Frequently Asked Questions</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>FAQ</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Faq -->
    <section class="faq-area pt-100 pb-70">
        <div class="container">
            <div class="row faq-wrap">
                <div class="col-lg-12">
                    <div class="faq-head">
                        <h2>Frequently Asked Questions</h2>
                    </div>
                    <div class="faq-item">
                        <ul class="accordion">
                            @forelse($faqs as $index => $faq)
                                <li class="wow fadeInUp" data-wow-delay=".{{ 3 + ($index * 1) }}s">
                                    <h3 class="faq-head">{{ $faq->question }}</h3>
                                    <div class="faq-content">
                                        <p>{{ $faq->answer }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-center py-5">
                                    <p class="text-muted">No FAQs available at the moment. Please check back later!</p>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Faq -->
@endsection

@section('page_script')
@endsection

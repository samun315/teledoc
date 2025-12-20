@extends('frontend.master')
@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-four">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>{{ $service->title }}</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>
                            <a href="{{ route('service') }}">Services</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>{{ $service->title }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Service Details -->
    <div class="service-details-area ptb-100">
        <div class="container">
            <div class="services-details-img">
                @if($service->banner_image)
                    <img src="{{ asset('storage/' . $service->banner_image) }}" alt="{{ $service->title }}">
                @else
                    <img src="{{ asset('frontend/assets/img/service-details-bg.jpg') }}" alt="{{ $service->title }}">
                @endif
                <h2>{{ $service->title }}</h2>
                <div class="service-content">
                    {!! $service->content !!}
                </div>
            </div>
            @if($service->detail_image)
            <div class="row justify-content-center mt-5">
                <div class="col-lg-5">
                    <div class="service-details-inner-left">
                        <img src="{{ asset('storage/' . $service->detail_image) }}" alt="{{ $service->title }}">
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="service-details-inner">
                        <h2>{{ $service->title }}</h2>
                        <p>{{ $service->short_description }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    <!-- End Service Details -->

    <!-- Blog -->
    <section class="blog-area pt-100 pb-70">
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
    <!-- End Blog -->
@endsection

@section('page_script')
@endsection

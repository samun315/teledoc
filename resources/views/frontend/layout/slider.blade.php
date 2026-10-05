<!-- Home Slider -->
        <div class="home-slider owl-theme owl-carousel">
            @forelse($sliders as $index => $slider)
            @php
                $bgLarge = $slider->image ? responsive_image($slider->image, 1280, 55) : null;
                $shapeSrc = $slider->shape_image ? responsive_image($slider->shape_image, 960, 70) : asset('frontend/assets/img/home-one/home-slider/' . ($index + 1) . '.png');
            @endphp
            <div class="slider-item slider-item-img" @if($bgLarge) style="background-image: url('{{ $bgLarge }}');" @endif>
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="slider-text">
                                <div class="slider-shape{{ $index == 0 ? '' : ($index == 1 ? '-two' : '-three') }}">
                                    <img class="slider-shape-img" @if($index === 0) src="{{ $shapeSrc }}" @else data-src="{{ $shapeSrc }}" @endif alt="" decoding="async" aria-hidden="true">
                                </div>
                                <h2 class="slider-heading">{{ $slider->title }}</h2>
                                @if($slider->subtitle)
                                    <p>{{ $slider->subtitle }}</p>
                                @endif
                                <div class="common-btn">
                                    @if($slider->button_text_1 && $slider->button_url_1)
                                        @php
                                            $buttonUrl1 = $slider->button_url_1;
                                            // Check if it's a route name (doesn't start with / or http)
                                            if (!str_starts_with($buttonUrl1, '/') && !str_starts_with($buttonUrl1, 'http') && !str_starts_with($buttonUrl1, '#')) {
                                                try {
                                                    $buttonUrl1 = route($buttonUrl1);
                                                } catch (\Exception $e) {
                                                    // If route doesn't exist, treat as relative URL
                                                    $buttonUrl1 = '/' . ltrim($buttonUrl1, '/');
                                                }
                                            } elseif (!str_starts_with($buttonUrl1, 'http') && !str_starts_with($buttonUrl1, '#')) {
                                                // Ensure relative URLs start with /
                                                $buttonUrl1 = '/' . ltrim($buttonUrl1, '/');
                                            }
                                        @endphp
                                        <a href="{{ $buttonUrl1 }}">{{ $slider->button_text_1 }}</a>
                                    @endif
                                    @if($slider->button_text_2 && $slider->button_url_2)
                                        @php
                                            $buttonUrl2 = $slider->button_url_2;
                                            // Check if it's a route name (doesn't start with / or http)
                                            if (!str_starts_with($buttonUrl2, '/') && !str_starts_with($buttonUrl2, 'http') && !str_starts_with($buttonUrl2, '#')) {
                                                try {
                                                    $buttonUrl2 = route($buttonUrl2);
                                                } catch (\Exception $e) {
                                                    // If route doesn't exist, treat as relative URL
                                                    $buttonUrl2 = '/' . ltrim($buttonUrl2, '/');
                                                }
                                            } elseif (!str_starts_with($buttonUrl2, 'http') && !str_starts_with($buttonUrl2, '#')) {
                                                // Ensure relative URLs start with /
                                                $buttonUrl2 = '/' . ltrim($buttonUrl2, '/');
                                            }
                                        @endphp
                                        <a class="cmn-btn-right" href="{{ $buttonUrl2 }}">{{ $slider->button_text_2 }}</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <!-- Fallback slider if no sliders in database -->
            <div class="slider-item slider-item-img">
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="slider-text">
                                <div class="slider-shape">
                                    <img src="{{ asset('frontend/assets/img/home-one/home-slider/1.png') }}" alt="" width="400" height="400" decoding="async" aria-hidden="true">
                                </div>
                                <h2 class="slider-heading">Welcome to Our Healthcare Center</h2>
                                <p>Providing exceptional healthcare services with care and compassion.</p>
                                <div class="common-btn">
                                    <a href="{{ route('contact-us') }}">Contact Us</a>
                                    <a class="cmn-btn-right" href="{{ route('about') }}">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforelse
        </div>
        <!-- End Home Slider -->

<!-- Home Slider -->
        <div class="home-slider owl-theme owl-carousel">
            @forelse($sliders as $index => $slider)
            <div class="slider-item slider-item-img" @if($slider->image) style="background-image: url('{{ asset('storage/' . $slider->image) }}');" @endif>
                <div class="d-table">
                    <div class="d-table-cell">
                        <div class="container">
                            <div class="slider-text">
                                <div class="slider-shape{{ $index == 0 ? '' : ($index == 1 ? '-two' : '-three') }}">
                                    @if($slider->shape_image)
                                        <img src="{{ asset('storage/' . $slider->shape_image) }}" alt="{{ $slider->title }}">
                                    @else
                                        <img src="frontend/assets/img/home-one/home-slider/{{ $index + 1 }}.png" alt="Shape">
                                    @endif
                                </div>
                                <h1>{{ $slider->title }}</h1>
                                @if($slider->subtitle)
                                    <p>{{ $slider->subtitle }}</p>
                                @endif
                                <div class="common-btn">
                                    @if($slider->button_text_1 && $slider->button_url_1)
                                        <a href="{{ $slider->button_url_1 }}">{{ $slider->button_text_1 }}</a>
                                    @endif
                                    @if($slider->button_text_2 && $slider->button_url_2)
                                        <a class="cmn-btn-right" href="{{ $slider->button_url_2 }}">{{ $slider->button_text_2 }}</a>
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
                                    <img src="frontend/assets/img/home-one/home-slider/1.png" alt="Shape">
                                </div>
                                <h1>Welcome to Our Healthcare Center</h1>
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

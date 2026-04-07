{{-- Terms: dynamic items or legacy full HTML --}}
@if($paymentTermItems->isEmpty())
    @include('frontend.partials.payment-instructions.terms-default')
@else
    @include('frontend.partials.payment-instructions.terms-intro')

    <div class="accordion payment-terms-accordion mt-4 text-start" id="paymentTermsAccordion">
        @foreach($paymentTermItems as $term)
            <div class="accordion-item">
                <h2 class="accordion-header" id="ptHeading{{ $term->id }}">
                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                        data-bs-target="#ptCollapse{{ $term->id }}"
                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="ptCollapse{{ $term->id }}">
                        <span class="d-flex align-items-center gap-3 w-100">
                            <span class="pt-icon pt-icon-{{ $term->icon_color }}"><i class="{{ $term->icon }}"></i></span>
                            <span>{{ $term->title }}</span>
                        </span>
                    </button>
                </h2>
                <div id="ptCollapse{{ $term->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                    aria-labelledby="ptHeading{{ $term->id }}" data-bs-parent="#paymentTermsAccordion">
                    <div class="accordion-body">
                        <div class="pt-inner {{ $loop->first ? 'pt-inner-blue' : '' }} pi-text--richtext">
                            {!! $term->description !!}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif

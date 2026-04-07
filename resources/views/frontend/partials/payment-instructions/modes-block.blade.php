{{-- Payment modes: dynamic rows or legacy default --}}
@if($paymentModes->isEmpty())
    @include('frontend.partials.payment-instructions.modes-default')
@else
    <div id="section-payment-modes" class="payment-modes-wrap text-center text-md-start" tabindex="-1">
        <h2 class="payment-modes-heading">Payment modes</h2>
        <p class="payment-modes-lead">
            Choose a payment method below. Each section includes steps and applicable terms for completing your consultation fee.
        </p>

        <div class="accordion pm-accordion text-start" id="paymentModesAccordion">
            @foreach($paymentModes as $mode)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="pmHeading{{ $mode->id }}">
                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse"
                            data-bs-target="#pmCollapse{{ $mode->id }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="pmCollapse{{ $mode->id }}">
                            {{ $mode->title }}
                        </button>
                    </h2>
                    <div id="pmCollapse{{ $mode->id }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                        aria-labelledby="pmHeading{{ $mode->id }}" data-bs-parent="#paymentModesAccordion">
                        <div class="accordion-body">
                            <div class="row g-4 align-items-stretch">
                                <div class="col-md-5">
                                    <div class="pm-mode-visual h-100 d-flex align-items-center justify-content-center p-3 rounded-3"
                                        style="min-height: 160px; background: linear-gradient(180deg, #f8fafc 0%, #f1f5f9 100%); border: 1px solid #e2e8f0;">
                                        @if($mode->image)
                                            <img src="{{ asset('storage/'.$mode->image) }}" alt="{{ $mode->title }}" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                                        @else
                                            <span class="fs-5 fw-bold text-secondary text-center px-2">{{ $mode->title }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-7">
                                    <div class="pm-pay-title">{{ $mode->title }}</div>
                                    <div class="pm-subblock">
                                        <div class="pm-subblock-title">Account details</div>
                                        <div class="pm-instruction-list pi-text--richtext">{!! $mode->account_details !!}</div>
                                    </div>
                                    <div class="pm-subblock">
                                        <div class="pm-subblock-title">Instructions</div>
                                        <div class="pm-instruction-list pi-text--richtext">{!! $mode->instruction !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

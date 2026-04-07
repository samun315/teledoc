{{-- Quick Summary: dynamic list or legacy default --}}
@if($paymentQuickSummaryItems->isEmpty())
    @include('frontend.partials.payment-instructions.summary-default')
@else
    <div class="payment-terms-summary text-start">
        <h3>
            <i class="icofont-info-circle"></i>
            Quick Summary
        </h3>
        <ul class="pt-summary-list">
            @foreach($paymentQuickSummaryItems as $item)
                <li>
                    <span class="pt-num pt-num-{{ $item->badge_variant }}">{{ $loop->iteration }}</span>
                    <span>{{ $item->line_text }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endif

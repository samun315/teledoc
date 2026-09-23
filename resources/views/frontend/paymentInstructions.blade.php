@extends('frontend.master')

@push('extra_scripts')
<script src="{{ asset('frontend/assets/js/sweetalert2.all.min.js') }}"></script>
@endpush

@push('styles')
<style>
    html {
        scroll-behavior: smooth;
    }
    @media (prefers-reduced-motion: reduce) {
        html {
            scroll-behavior: auto;
        }
        .payment-instruction-hero:hover,
        .pi-jump-btn--primary:hover,
        .pi-jump-btn--ghost:hover,
        .pi-back-top:hover,
        .btn-copy-pm:hover {
            transform: none !important;
        }
    }
    #section-payment-intro,
    #section-payment-modes,
    #section-payment-terms {
        scroll-margin-top: 88px;
    }
    .payment-instruction-intro {
        padding: 2rem 0 2.5rem;
        background: linear-gradient(180deg, #f1f5f9 0%, #ffffff 55%, #ffffff 100%);
    }
    @media (min-width: 992px) {
        .payment-instruction-intro {
            padding: 2.5rem 0 3rem;
        }
    }
    .payment-instruction-hero {
        max-width: 900px;
        margin: 0 auto;
        background: #fff;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 10px 40px rgba(15, 23, 42, 0.08);
        border: 1px solid #e2e8f0;
        transition: box-shadow 0.35s ease, transform 0.35s ease;
    }
    .payment-instruction-hero:hover {
        box-shadow: 0 16px 48px rgba(15, 23, 42, 0.12);
        transform: translateY(-2px);
    }
    .pi-banner-wrap {
        position: relative;
        width: 100%;
        overflow: hidden;
        background: linear-gradient(135deg, #e0f2fe 0%, #dbeafe 50%, #eff6ff 100%);
        border-radius: 16px 16px 0 0;
    }
    .pi-banner-img {
        width: 100%;
        height: auto;
        min-height: 200px;
        max-height: 280px;
        object-fit: cover;
        object-position: center;
        display: block;
    }
    @media (min-width: 768px) {
        .pi-banner-img {
            max-height: 320px;
        }
    }
    .pi-banner-content {
        padding: 1.5rem 1.35rem 1.75rem;
    }
    @media (min-width: 768px) {
        .pi-banner-content {
            padding: 1.85rem 2rem 2rem;
        }
    }
    .pi-heading {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.3;
        margin: 0 0 0.85rem;
    }
    @media (min-width: 768px) {
        .pi-heading {
            font-size: 1.85rem;
        }
    }
    .pi-text {
        font-size: 1rem;
        line-height: 1.65;
        color: #475569;
        margin: 0 0 1.5rem;
    }
    .pi-text--richtext {
        font-size: 1rem;
        line-height: 1.65;
        color: #475569;
        margin: 0 0 1.5rem;
    }
    .pi-text--richtext p {
        margin: 0 0 0.85rem;
    }
    .pi-text--richtext p:last-child {
        margin-bottom: 0;
    }
    .pi-text--richtext ul,
    .pi-text--richtext ol {
        margin: 0 0 0.85rem;
        padding-left: 1.25rem;
    }
    .pi-text--richtext a {
        color: #0284c7;
        text-decoration: underline;
    }
    .pi-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.65rem;
        justify-content: center;
    }
    @media (min-width: 768px) {
        .pi-actions {
            justify-content: flex-start;
        }
    }
    .pi-jump-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        font-size: 0.9rem;
        font-weight: 600;
        padding: 0.55rem 1.1rem;
        border-radius: 999px;
        text-decoration: none;
        transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease, transform 0.15s ease;
        border: 2px solid transparent;
    }
    .pi-jump-btn:focus {
        outline: 2px solid #0ea5e9;
        outline-offset: 2px;
    }
    .pi-jump-btn--primary {
        background: #0ea5e9;
        color: #fff;
        border-color: #0ea5e9;
    }
    .pi-jump-btn--primary:hover {
        background: #0284c7;
        border-color: #0284c7;
        color: #fff;
        transform: translateY(-1px);
    }
    .pi-jump-btn--ghost {
        background: #fff;
        color: #0f172a;
        border-color: #e2e8f0;
    }
    .pi-jump-btn--ghost:hover {
        border-color: #0ea5e9;
        color: #0284c7;
        background: #f0f9ff;
        transform: translateY(-1px);
    }

    /* Back to top */
    .pi-back-top {
        position: fixed;
        bottom: calc(1.25rem + env(safe-area-inset-bottom, 0));
        right: 1rem;
        z-index: 1019;
        width: 46px;
        height: 46px;
        border-radius: 50%;
        border: none;
        background: #0f172a;
        color: #fff;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.25);
        transition: transform 0.2s ease, background 0.2s ease;
        padding-bottom: env(safe-area-inset-bottom, 0);
    }
    .pi-back-top.is-visible {
        display: flex;
    }
    .pi-back-top:hover {
        background: #1e293b;
        transform: translateY(-2px);
    }
    .pi-back-top:focus-visible {
        outline: 3px solid #38bdf8;
        outline-offset: 2px;
    }
    @media (min-width: 992px) {
        .pi-back-top {
            bottom: 2rem;
            right: 1.5rem;
        }
    }

    /* Copy number */
    .pm-copy-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 0.5rem;
    }
    .btn-copy-pm {
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
        font-size: 0.75rem;
        font-weight: 600;
        padding: 0.25rem 0.6rem;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #475569;
        cursor: pointer;
        transition: border-color 0.2s ease, background 0.2s ease, color 0.2s ease;
    }
    .btn-copy-pm:hover {
        border-color: #0ea5e9;
        color: #0284c7;
        background: #f0f9ff;
    }
    .btn-copy-pm:focus-visible {
        outline: 2px solid #0ea5e9;
        outline-offset: 2px;
    }
    .btn-copy-pm.copied {
        border-color: #22c55e;
        color: #15803d;
        background: #f0fdf4;
    }

    .payment-terms-wrap {
        --pt-yellow-bg: #FEF9C3;
        --pt-yellow-text: #854D0E;
        --pt-blue-bg: #EFF6FF;
        --pt-blue: #1D4ED8;
        --pt-green-bg: #DCFCE7;
        --pt-green: #15803D;
        --pt-orange-bg: #FFEDD5;
        --pt-orange: #C2410C;
        --pt-red-bg: #FEE2E2;
        --pt-red: #B91C1C;
        --pt-purple-bg: #F3E8FF;
        --pt-purple: #7E22CE;
        --pt-card-radius: 12px;
        --pt-shadow: 0 4px 24px rgba(15, 23, 42, 0.06);
    }
    .payment-terms-wrap {
        max-width: 900px;
        margin: 0 auto;
    }
    .payment-terms-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        background: var(--pt-yellow-bg);
        color: var(--pt-yellow-text);
        font-size: 0.875rem;
        font-weight: 600;
        padding: 0.35rem 0.85rem;
        border-radius: 999px;
    }
    .payment-terms-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: #0f172a;
        margin: 1rem 0 0.5rem;
        line-height: 1.25;
    }
    @media (min-width: 768px) {
        .payment-terms-title { font-size: 2rem; }
    }
    .payment-terms-lead {
        color: #64748b;
        font-size: 1rem;
        margin-bottom: 0;
    }
    .payment-terms-notice {
        background: var(--pt-yellow-bg);
        border: 1px solid rgba(133, 77, 14, 0.2);
        border-radius: var(--pt-card-radius);
        padding: 1rem 1.25rem;
        margin-top: 1.75rem;
        display: flex;
        gap: 0.85rem;
        align-items: flex-start;
    }
    .payment-terms-notice i {
        font-size: 1.35rem;
        color: #CA8A04;
        flex-shrink: 0;
        margin-top: 2px;
    }
    .payment-terms-notice h3 {
        font-size: 1rem;
        font-weight: 700;
        color: var(--pt-yellow-text);
        margin: 0 0 0.35rem;
    }
    .payment-terms-notice p {
        margin: 0;
        color: var(--pt-yellow-text);
        font-size: 0.9375rem;
        line-height: 1.55;
    }
    .payment-terms-accordion .accordion-item {
        border: none;
        margin-bottom: 0.75rem;
        border-radius: var(--pt-card-radius) !important;
        overflow: hidden;
        box-shadow: var(--pt-shadow);
        background: #fff;
        transition: box-shadow 0.2s ease, transform 0.2s ease;
    }
    .payment-terms-accordion .accordion-item:hover {
        box-shadow: 0 8px 28px rgba(15, 23, 42, 0.1);
    }
    .payment-terms-accordion .accordion-button {
        font-weight: 600;
        font-size: 1rem;
        color: #0f172a;
        padding: 1rem 1.15rem;
        box-shadow: none !important;
        background: #fff !important;
    }
    .payment-terms-accordion .accordion-button:not(.collapsed) {
        color: #0f172a;
        background: #fff !important;
    }
    .payment-terms-accordion .accordion-button::after {
        filter: grayscale(1) opacity(0.55);
    }
    .payment-terms-accordion .accordion-body {
        padding: 0 1.15rem 1.15rem;
    }
    .payment-terms-accordion .pt-inner {
        background: #f1f5f9;
        border-radius: 10px;
        padding: 1rem 1.1rem;
        color: #475569;
        font-size: 0.9375rem;
        line-height: 1.6;
    }
    .payment-terms-accordion .pt-inner.pt-inner-blue {
        background: var(--pt-blue-bg);
    }
    .pt-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        flex-shrink: 0;
    }
    .pt-icon-blue { background: var(--pt-blue-bg); color: var(--pt-blue); }
    .pt-icon-green { background: var(--pt-green-bg); color: var(--pt-green); }
    .pt-icon-orange { background: var(--pt-orange-bg); color: var(--pt-orange); }
    .pt-icon-red { background: var(--pt-red-bg); color: var(--pt-red); }
    .pt-icon-purple { background: var(--pt-purple-bg); color: var(--pt-purple); }
    .payment-terms-summary {
        background: #f8fafc;
        border-radius: var(--pt-card-radius);
        padding: 1.25rem 1.35rem;
        margin-top: 1.5rem;
        border: 1px solid #e2e8f0;
    }
    .payment-terms-summary h3 {
        font-size: 1.05rem;
        font-weight: 700;
        color: #0f172a;
        margin: 0 0 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .payment-terms-summary h3 i {
        color: var(--pt-blue);
        font-size: 1.2rem;
    }
    .pt-summary-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pt-summary-list li {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 0.65rem;
        font-size: 0.9375rem;
        color: #334155;
        line-height: 1.45;
    }
    .pt-summary-list li:last-child { margin-bottom: 0; }
    .pt-num {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }
    .pt-num-1 { background: var(--pt-blue); }
    .pt-num-2 { background: var(--pt-green); }
    .pt-num-3 { background: var(--pt-orange); }
    .pt-num-4 { background: var(--pt-red); }
    .pt-num-5 { background: var(--pt-purple); }

    /* Payment modes (bKash / Nagad / Card) */
    .payment-modes-wrap {
        max-width: 900px;
        margin: 0 auto 3rem;
    }
    .payment-modes-heading {
        font-size: 1.35rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 0.35rem;
    }
    .payment-modes-lead {
        color: #64748b;
        font-size: 0.95rem;
        margin-bottom: 1.25rem;
    }
    .pm-accordion .accordion-item {
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        overflow: hidden;
        background: #fff;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .pm-accordion .accordion-item:hover {
        border-color: #cbd5e1;
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.06);
    }
    .pm-accordion .accordion-button {
        font-weight: 600;
        font-size: 1rem;
        color: #334155;
        padding: 0.9rem 1.1rem;
        box-shadow: none !important;
        background: #fafafa !important;
    }
    .pm-accordion .accordion-button:not(.collapsed) {
        background: #fff !important;
        color: #0f172a;
        border-bottom: 1px solid #e5e7eb;
        position: relative;
    }
    .pm-accordion .accordion-button:not(.collapsed)::before {
        content: "";
        position: absolute;
        top: 0;
        right: 0;
        width: 48px;
        height: 3px;
        background: linear-gradient(90deg, transparent, #f97316 40%);
        border-radius: 0 8px 0 0;
    }
    .pm-accordion .accordion-body {
        padding: 1.25rem 1.15rem;
        background: #fff;
    }
    .pm-bkash-brand {
        background: linear-gradient(180deg, #fff5f9 0%, #fce7f3 100%);
        border: 1px solid #fbcfe8;
        border-radius: 12px;
        min-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
    }
    .pm-bkash-logo {
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
        font-size: 1.75rem;
        font-weight: 700;
        color: #E2136E;
        letter-spacing: -0.02em;
    }
    .pm-bkash-logo span {
        display: block;
        font-size: 0.7rem;
        font-weight: 600;
        color: #db2777;
        margin-top: 0.35rem;
        text-align: center;
    }
    .pm-pay-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 1rem;
    }
    .pm-subblock {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 1rem 1.1rem;
        margin-bottom: 1rem;
    }
    .pm-subblock:last-child {
        margin-bottom: 0;
    }
    .pm-subblock-title {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: #64748b;
        margin: 0 0 0.75rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e2e8f0;
    }
    .pm-instruction-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .pm-instruction-list li {
        padding: 0.65rem 0;
        border-bottom: 1px solid #e5e7eb;
        font-size: 0.9375rem;
        line-height: 1.55;
        color: #334155;
    }
    .pm-instruction-list li:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }
    .pm-instruction-list li:first-child {
        padding-top: 0;
    }
    .pm-instruction-list .pm-note-en {
        color: #64748b;
        font-style: italic;
    }
    .pm-nagad-brand {
        background: linear-gradient(180deg, #fffbeb 0%, #fef3c7 100%);
        border: 1px solid #fcd34d;
        border-radius: 12px;
        min-height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.25rem;
    }
    .pm-nagad-logo {
        font-size: 1.65rem;
        font-weight: 800;
        color: #f7941d;
    }
    .pm-card-brand {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 1px solid #cbd5e1;
        border-radius: 12px;
        min-height: 160px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #475569;
        font-size: 2.5rem;
    }
</style>
@endpush

@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-four">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Payment Instructions</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Payment Instructions</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Payment instruction (banner + intro) -->
    <section id="section-payment-intro" class="payment-instruction-intro" aria-labelledby="pi-heading">
        <div class="container">
            <div class="payment-instruction-hero">
                <div class="pi-banner-wrap">
                    <img
                        class="pi-banner-img"
                        src="{{ $paymentInstructionHero['banner_src'] }}"
                        alt="{{ $paymentInstructionHero['title'] }}"
                        width="800"
                        height="600"
                        loading="eager"
                        decoding="async"
                    >
                </div>
                <div class="pi-banner-content text-center text-md-start">
                    <h2 class="pi-heading" id="pi-heading">
                        {{ $paymentInstructionHero['title'] }}
                    </h2>
                    <div class="pi-text pi-text--richtext">
                        {!! $paymentInstructionHero['description'] !!}
                    </div>
                    <div class="pi-actions" role="navigation" aria-label="Jump to page sections">
                        <a href="#section-payment-modes" class="pi-jump-btn pi-jump-btn--primary">
                            <i class="icofont-wallet"></i>
                            Payment modes
                        </a>
                        {{-- <a href="#section-payment-terms" class="pi-jump-btn pi-jump-btn--ghost">
                            <i class="icofont-file-text"></i>
                            Terms &amp; Conditions
                        </a> --}}
                        <a href="{{ route('patient.appointment') }}" class="pi-jump-btn pi-jump-btn--ghost">
                            <i class="icofont-calendar"></i>
                            Book appointment
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Payment instruction intro -->

    <button type="button" class="pi-back-top" id="piBackTop" aria-label="Back to top" title="Back to top">
        <i class="icofont-arrow-up"></i>
    </button>

    <section class="faq-area pt-4 pt-md-5 pb-70">
        <div class="container">
            {{-- Payment modes: admin/settings/payment-instructions (tab Payment modes) --}}
            @include('frontend.partials.payment-instructions.modes-block', ['paymentModes' => $paymentModes])

            {{-- <div id="section-payment-terms" class="payment-terms-wrap text-center text-md-start" tabindex="-1">
                @include('frontend.partials.payment-instructions.terms-block', ['paymentTermItems' => $paymentTermItems])
                @include('frontend.partials.payment-instructions.summary-block', ['paymentQuickSummaryItems' => $paymentQuickSummaryItems])
            </div> --}}
        </div>
    </section>
@endsection

@section('page_script')
<script nonce="{{ $cspNonce ?? '' }}">
(function () {
    var backTop = document.getElementById('piBackTop');
    var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    function onScroll() {
        var y = window.scrollY || document.documentElement.scrollTop;
        if (backTop) {
            backTop.classList.toggle('is-visible', y > 380);
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    if (backTop) {
        backTop.addEventListener('click', function () {
            window.scrollTo({ top: 0, behavior: reduceMotion ? 'auto' : 'smooth' });
        });
    }

    document.querySelectorAll('.btn-copy-pm').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var text = btn.getAttribute('data-copy') || '';
            var labelEl = btn.querySelector('.btn-copy-pm__label');

            function finish(ok) {
                btn.classList.toggle('copied', ok);
                if (labelEl) {
                    labelEl.textContent = ok ? 'Copied' : 'Copy';
                }
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        toast: true,
                        position: 'bottom-end',
                        icon: ok ? 'success' : 'error',
                        title: ok ? 'Number copied' : 'Copy failed — select and copy manually',
                        showConfirmButton: false,
                        timer: ok ? 2200 : 4000,
                        timerProgressBar: true
                    });
                }
                if (ok && labelEl) {
                    setTimeout(function () {
                        btn.classList.remove('copied');
                        labelEl.textContent = 'Copy';
                    }, 2200);
                }
            }

            function fallback() {
                var ta = document.createElement('textarea');
                ta.value = text;
                ta.setAttribute('readonly', '');
                ta.style.position = 'fixed';
                ta.style.left = '-9999px';
                document.body.appendChild(ta);
                ta.select();
                var ok = false;
                try {
                    ok = document.execCommand('copy');
                } catch (e) {}
                document.body.removeChild(ta);
                finish(ok);
            }

            if (navigator.clipboard && navigator.clipboard.writeText) {
                navigator.clipboard.writeText(text).then(function () { finish(true); }).catch(fallback);
            } else {
                fallback();
            }
        });
    });
})();
</script>
@endsection

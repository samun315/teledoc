<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend.layout.stylesheet')
</head>

<body>

    <!-- Preloader -->
    <div class="loader" id="siteLoader" role="status" aria-live="polite" aria-label="Loading">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="spinner" aria-hidden="true">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Preloader -->
    <script nonce="{{ $cspNonce ?? '' }}">
        (function () {
            var loader = document.getElementById('siteLoader');
            if (!loader) return;
            var showTimer = setTimeout(function () {
                loader.classList.add('is-visible');
            }, 250);
            function hideLoader() {
                clearTimeout(showTimer);
                loader.classList.remove('is-visible');
                loader.classList.add('is-hidden');
            }
            if (document.readyState === 'complete' || document.readyState === 'interactive') {
                hideLoader();
            } else {
                document.addEventListener('DOMContentLoaded', hideLoader);
            }
            window.addEventListener('load', hideLoader);
        })();
    </script>

    <!-- Header Top -->
    @include('frontend.layout.navbar')
    <!-- End Header Top -->

    <main id="main-content">
        @yield('content')
    </main>

    @include('frontend.layout.footer')

    @include('frontend.layout.script')
</body>

</html>

<!DOCTYPE html>
<html lang="zxx">

<head>
    @include('frontend.layout.stylesheet')
</head>

<body>

    <!-- Preloader -->
    <div class="loader">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="spinner">
                    <div class="double-bounce1"></div>
                    <div class="double-bounce2"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Preloader -->

    <!-- Header Top -->
    @include('frontend.layout.navbar')
    <!-- End Header Top -->



    @yield('content')




    @include('frontend.layout.footer')

    @include('frontend.layout.script')
</body>

</html>

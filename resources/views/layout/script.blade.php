<!--begin::Javascript-->
<script nonce="{{ $cspNonce }}">
    var hostUrl = "assets/";
</script>

<!--begin::Global Javascript Bundle(used by all pages)-->
<script src="{{ asset('assets/plugins/global/plugins.bundle.js') }}"
    {{ Sri::html('assets/plugins/global/plugins.bundle.js') }}></script>
<script src="{{ asset('assets/js/scripts.bundle.js') }}" {{ Sri::html('assets/js/scripts.bundle.js') }}></script>
<!--end::Global Javascript Bundle-->

<!--begin::Page Vendors Javascript(used by this page)-->
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"
    {{ Sri::html('assets/plugins/custom/datatables/datatables.bundle.js') }}></script>
<!--end::Page Vendors Javascript-->

<!--begin::Page Custom Javascript(used by this page)-->
<script src="{{ asset('assets/js/widgets.bundle.js') }}" {{ Sri::html('assets/js/widgets.bundle.js') }}></script>
<script src="{{ asset('assets/js/custom/widgets.js') }}" {{ Sri::html('assets/js/custom/widgets.js') }}></script>
<script src="{{ asset('assets/js/custom/apps/chat/chat.js') }}" {{ Sri::html('assets/js/custom/apps/chat/chat.js') }}>
</script>
<script src="{{ asset('assets/js/custom/utilities/modals/upgrade-plan.js') }}"
    {{ Sri::html('assets/js/custom/utilities/modals/upgrade-plan.js') }}></script>
<script src="{{ asset('assets/js/custom/utilities/modals/create-app.js') }}"
    {{ Sri::html('assets/js/custom/utilities/modals/create-app.js') }}></script>
<script src="{{ asset('assets/js/custom/utilities/modals/users-search.js') }}"
    {{ Sri::html('assets/js/custom/utilities/modals/users-search.js') }}></script>
<!--end::Page Custom Javascript-->

<!-- DataTable js -->
<script src="{{ asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"
    {{ Sri::html('assets/plugins/custom/datatables/datatables.bundle.js') }}></script>
<!-- <script src="{{ asset('assets/js/pages/crud/datatables/extensions/buttons.js') }}"></script> -->

<!-- Wait Me js -->
<script src="{{ asset('assets/plugins/global/waitMe/waitMe.min.js') }}"
    {{ Sri::html('assets/plugins/global/waitMe/waitMe.min.js') }}></script>

<script nonce="{{ $cspNonce }}">
    $(".alert-success").delay(2000).fadeOut("slow");
    //   $(".alert-danger").delay(2000).fadeOut("slow");
</script>

<!-- Custom Common js -->
<script src="{{ asset('assets/custom/js/common/common.js') }}" {{ Sri::html('assets/custom/js/common/common.js') }}>
</script>

<!-- Jquery Validate js -->
<script src="{{ asset('assets/plugins/global/jqueryValidate/jquery.validate.min.js') }}"
    {{ Sri::html('assets/plugins/global/jqueryValidate/jquery.validate.min.js') }}></script>

<!-- Jquery Validate js -->
<script src="{{ asset('assets/plugins/custom/draggable/jquery-nestable.js') }}"
    {{ Sri::html('assets/plugins/custom/draggable/jquery-nestable.js') }}></script>

<script nonce="{{ $cspNonce }}">
    $(document).ready(function() {
        console.log('Initializing menu...');

        // Set active menu first
        $(".menu .menu-item a").each(function () {
            var pageUrl = window.location.href.split(/[?#]/)[0];

            if (this.href == pageUrl) {
                $(this).addClass("active");
                $(this).parent().parent().parent().addClass("here show");
                $(this).parent().parent().parent().parent().parent().addClass("here show");
            }
        });

        // Wait for DOM to be fully ready, then initialize KTMenu
        setTimeout(function() {
            if (typeof KTMenu !== 'undefined') {
                console.log('KTMenu found, creating instances...');

                // Destroy existing instances first
                var menuElements = document.querySelectorAll('[data-kt-menu="true"]');
                menuElements.forEach(function(element) {
                    var menuInstance = KTMenu.getInstance(element);
                    if (menuInstance) {
                        menuInstance.destroy();
                    }
                });

                // Recreate instances
                KTMenu.createInstances('[data-kt-menu="true"]');
                console.log('KTMenu instances created successfully');

                // Debug: Test click handler
                setTimeout(function() {
                    var triggers = document.querySelectorAll('[data-kt-menu-trigger="click"]');
                    console.log('Setting up click handlers for', triggers.length, 'triggers');

                    triggers.forEach(function(trigger, index) {
                        trigger.addEventListener('click', function(e) {
                            console.log('Menu item clicked:', index);

                            // Check if submenu exists
                            var submenu = this.querySelector('.menu-sub');
                            if (submenu) {
                                console.log('Submenu found, current display:', window.getComputedStyle(submenu).display);
                                console.log('Parent has class "show":', this.classList.contains('show'));
                            } else {
                                console.log('No submenu found for this trigger');
                            }
                        });
                    });

                    // Force show submenus if sidebar is NOT minimized
                    var body = document.body;
                    if (!body.classList.contains('aside-minimize')) {
                        console.log('Sidebar is expanded, ensuring submenus can be shown');
                    } else {
                        console.log('Sidebar is minimized');
                    }
                }, 200);
            } else {
                console.error('KTMenu not defined!');
            }
        }, 100);
    });
</script>

<!-- IziToast Js-->
<script src="{{ asset('js/iziToast.js') }}"></script>

@yield('page_script')

@extends('master')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <!-- Page Header -->
        <div class="card mb-5">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h1 class="mb-0">Frontend Settings</h1>
                </div>
            </div>
        </div>

        <!-- Tabbed Settings Card -->
        <div class="card">
            <div class="card-body">
                <!-- Nav Tabs -->
                <ul class="nav nav-tabs nav-line-tabs mb-5" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#general-tab" role="tab">
                            <i class="icofont-settings"></i> General Information
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#contact-tab" role="tab">
                            <i class="icofont-phone"></i> Contact Details
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#social-tab" role="tab">
                            <i class="icofont-social-facebook"></i> Social Media
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#quick-links-tab" role="tab">
                            <i class="icofont-link"></i> Quick Links
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#services-tab" role="tab">
                            <i class="icofont-list"></i> Footer Services
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#logo-tab" role="tab">
                            <i class="icofont-image"></i> Logo & Branding
                        </a>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content">
                    <!-- General Tab -->
                    <div class="tab-pane fade show active" id="general-tab" role="tabpanel">
                        @include('backend.settings.partials.general-tab')
                    </div>

                    <!-- Contact Tab -->
                    <div class="tab-pane fade" id="contact-tab" role="tabpanel">
                        @include('backend.settings.partials.contact-tab')
                    </div>

                    <!-- Social Media Tab -->
                    <div class="tab-pane fade" id="social-tab" role="tabpanel">
                        @include('backend.settings.partials.social-media-tab')
                    </div>

                    <!-- Quick Links Tab -->
                    <div class="tab-pane fade" id="quick-links-tab" role="tabpanel">
                        @include('backend.settings.partials.quick-links-tab')
                    </div>

                    <!-- Services Tab -->
                    <div class="tab-pane fade" id="services-tab" role="tabpanel">
                        @include('backend.settings.partials.services-tab')
                    </div>

                    <!-- Logo Tab -->
                    <div class="tab-pane fade" id="logo-tab" role="tabpanel">
                        @include('backend.settings.partials.logo-tab')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modals -->
@include('backend.settings.partials.social-media-modal')
@include('backend.settings.partials.footer-link-modal')
@endsection

@section('page_script')
<script nonce="{{ $cspNonce }}">
$(document).ready(function() {
    // Remember last active tab
    let activeTab = localStorage.getItem('frontendSettingsActiveTab');
    if (activeTab) {
        $('.nav-link[href="' + activeTab + '"]').tab('show');
    }

    // Save active tab on change
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        localStorage.setItem('frontendSettingsActiveTab', $(e.target).attr('href'));
    });

    // Load tab scripts
    @include('backend.settings.partials.scripts')
});
</script>
@endsection


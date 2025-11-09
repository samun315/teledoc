// General Settings Form
$('#generalSettingsForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '{{ route("admin.settings.frontend.general") }}',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            iziToast.success({
                title: 'Success',
                message: response.message,
                position: 'topRight'
            });
        },
        error: function(xhr) {
            iziToast.error({
                title: 'Error',
                message: xhr.responseJSON?.message || 'An error occurred',
                position: 'topRight'
            });
        }
    });
});

// Contact Settings Form
$('#contactSettingsForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
        url: '{{ route("admin.settings.frontend.contact") }}',
        method: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            iziToast.success({
                title: 'Success',
                message: response.message,
                position: 'topRight'
            });
        },
        error: function(xhr) {
            iziToast.error({
                title: 'Error',
                message: xhr.responseJSON?.message || 'An error occurred',
                position: 'topRight'
            });
        }
    });
});

// Social Media Functions
function openSocialMediaModal(id = null) {
    $('#socialMediaForm')[0].reset();
    $('#socialMediaId').val('');
    $('#socialMediaModalTitle').text('Add Social Media Link');

    if (id) {
        $('#socialMediaModalTitle').text('Edit Social Media Link');
        // Fetch data and populate form
        $.ajax({
            url: `/admin/settings/frontend/social-media/${id}`,
            method: 'GET',
            success: function(response) {
                $('#socialMediaId').val(response.data.id);
                $('#socialPlatform').val(response.data.platform);
                $('#socialUrl').val(response.data.url);
                $('#socialIcon').val(response.data.icon_class);
                $('#socialLocation').val(response.data.display_location);
                $('#socialOrder').val(response.data.order);
                $('#socialActive').val(response.data.active);
            }
        });
    }

    $('#socialMediaModal').modal('show');
}

// Auto-fill icon on platform change
$('#socialPlatform').on('change', function() {
    const platform = $(this).val();
    const icons = {
        'facebook': 'icofont-facebook',
        'twitter': 'icofont-twitter',
        'instagram': 'icofont-instagram',
        'linkedin': 'icofont-linkedin',
        'youtube': 'icofont-youtube-play',
        'pinterest': 'icofont-pinterest',
        'tiktok': 'icofont-brand-tiktok',
        'whatsapp': 'icofont-whatsapp'
    };
    $('#socialIcon').val(icons[platform] || 'icofont-link');
});

$('#socialMediaForm').on('submit', function(e) {
    e.preventDefault();
    const id = $('#socialMediaId').val();
    const url = id ? `/admin/settings/frontend/social-media/${id}` : '{{ route("admin.settings.frontend.social-media.store") }}';
    const method = id ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        method: method,
        data: $(this).serialize(),
        success: function(response) {
            iziToast.success({
                title: 'Success',
                message: response.message,
                position: 'topRight'
            });
            $('#socialMediaModal').modal('hide');
            location.reload();
        },
        error: function(xhr) {
            iziToast.error({
                title: 'Error',
                message: xhr.responseJSON?.message || 'An error occurred',
                position: 'topRight'
            });
        }
    });
});

function editSocialMedia(id) {
    openSocialMediaModal(id);
}

function deleteSocialMedia(id) {
    if (confirm('Are you sure you want to delete this social media link?')) {
        $.ajax({
            url: `/admin/settings/frontend/social-media/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });
                location.reload();
            },
            error: function(xhr) {
                iziToast.error({
                    title: 'Error',
                    message: xhr.responseJSON?.message || 'An error occurred',
                    position: 'topRight'
                });
            }
        });
    }
}

// Footer Link Functions
function openFooterLinkModal(section, id = null) {
    $('#footerLinkForm')[0].reset();
    $('#footerLinkId').val('');
    $('#footerLinkSection').val(section);
    $('#footerLinkModalTitle').text(section === 'quick_links' ? 'Add Quick Link' : 'Add Service Link');

    if (id) {
        $('#footerLinkModalTitle').text(section === 'quick_links' ? 'Edit Quick Link' : 'Edit Service Link');
        // Fetch data and populate form
        $.ajax({
            url: `/admin/settings/frontend/footer-links/${id}`,
            method: 'GET',
            success: function(response) {
                $('#footerLinkId').val(response.data.id);
                $('#linkTitle').val(response.data.title);
                $('#linkUrl').val(response.data.url);
                $(`input[name="link_type"][value="${response.data.link_type}"]`).prop('checked', true);
                $('#linkIcon').val(response.data.icon);
                $('#linkTarget').val(response.data.target);
                $('#linkOrder').val(response.data.order);
                $('#linkActive').val(response.data.active);
            }
        });
    }

    $('#footerLinkModal').modal('show');
}

$('#footerLinkForm').on('submit', function(e) {
    e.preventDefault();
    const id = $('#footerLinkId').val();
    const url = id ? `/admin/settings/frontend/footer-links/${id}` : '{{ route("admin.settings.frontend.footer-links.store") }}';
    const method = id ? 'PUT' : 'POST';

    $.ajax({
        url: url,
        method: method,
        data: $(this).serialize(),
        success: function(response) {
            iziToast.success({
                title: 'Success',
                message: response.message,
                position: 'topRight'
            });
            $('#footerLinkModal').modal('hide');
            location.reload();
        },
        error: function(xhr) {
            iziToast.error({
                title: 'Error',
                message: xhr.responseJSON?.message || 'An error occurred',
                position: 'topRight'
            });
        }
    });
});

function editFooterLink(id) {
    // Determine section from current tab
    const activeTab = $('.tab-pane.active').attr('id');
    const section = activeTab === 'quick-links-tab' ? 'quick_links' : 'services';
    openFooterLinkModal(section, id);
}

function deleteFooterLink(id) {
    if (confirm('Are you sure you want to delete this link?')) {
        $.ajax({
            url: `/admin/settings/frontend/footer-links/${id}`,
            method: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });
                location.reload();
            },
            error: function(xhr) {
                iziToast.error({
                    title: 'Error',
                    message: xhr.responseJSON?.message || 'An error occurred',
                    position: 'topRight'
                });
            }
        });
    }
}

// Logo Upload Functions
$('#mainLogoForm, #mobileLogoForm, #footerLogoForm, #faviconForm').on('submit', function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const logoType = $(this).find('input[name="logo_type"]').val();

    $.ajax({
        url: '{{ route("admin.settings.frontend.logo") }}',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            iziToast.success({
                title: 'Success',
                message: response.message,
                position: 'topRight'
            });

            // Update preview
            $(`#${logoType}LogoPreview`).html(`<img src="${response.preview_url}?t=${Date.now()}" alt="${logoType} Logo" class="img-thumbnail" style="max-height: 100px;">`);
        },
        error: function(xhr) {
            iziToast.error({
                title: 'Error',
                message: xhr.responseJSON?.message || 'An error occurred',
                position: 'topRight'
            });
        }
    });
});

function deleteLogo(type) {
    if (confirm('Are you sure you want to delete this logo?')) {
        $.ajax({
            url: '{{ route("admin.settings.frontend.logo.delete") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                logo_type: type
            },
            success: function(response) {
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });
                location.reload();
            },
            error: function(xhr) {
                iziToast.error({
                    title: 'Error',
                    message: xhr.responseJSON?.message || 'An error occurred',
                    position: 'topRight'
                });
            }
        });
    }
}


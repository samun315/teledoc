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

// Event Delegation for Social Media Buttons
$(document).on('click', '#addSocialMediaBtn', function() {
    openSocialMediaModal();
});

$(document).on('click', '.edit-social-media-btn', function() {
    const id = $(this).data('id');
    if (id) {
        openSocialMediaModal(id);
    }
});

$(document).on('click', '.delete-social-media-btn', function() {
    const id = $(this).data('id');
    if (id) {
        deleteSocialMedia(id);
    }
});

// Event Delegation for Footer Link Buttons
$(document).on('click', '#addQuickLinkBtn', function() {
    const section = $(this).data('section');
    openFooterLinkModal(section);
});

$(document).on('click', '#addServiceLinkBtn', function() {
    const section = $(this).data('section');
    openFooterLinkModal(section);
});

$(document).on('click', '.edit-footer-link-btn', function() {
    const id = $(this).data('id');
    const section = $(this).data('section');
    if (id && section) {
        openFooterLinkModal(section, id);
    }
});

$(document).on('click', '.delete-footer-link-btn', function() {
    const id = $(this).data('id');
    if (id) {
        deleteFooterLink(id);
    }
});

// Event Delegation for Logo Delete Buttons
$(document).on('click', '.delete-logo-btn', function() {
    const logoType = $(this).data('logo-type');
    if (logoType) {
        deleteLogo(logoType);
    }
});

// Social Media Functions
function openSocialMediaModal(id = null) {
    // Reset form
    $('#socialMediaForm')[0].reset();
    $('#socialMediaId').val('');
    $('#socialMediaModalTitle').text('Add Social Media Link');
    $('#socialIcon').val('');

    if (id) {
        $('#socialMediaModalTitle').text('Edit Social Media Link');
        // Fetch data and populate form
        $.ajax({
            url: `/admin/settings/frontend/social-media/${id}`,
            method: 'GET',
            success: function(response) {
                if (response.data) {
                    $('#socialMediaId').val(response.data.id);
                    $('#socialPlatform').val(response.data.platform);
                    $('#socialUrl').val(response.data.url);
                    $('#socialIcon').val(response.data.icon_class || '');
                    $('#socialLocation').val(response.data.display_location);
                    $('#socialOrder').val(response.data.order || 0);
                    $('#socialActive').val(response.data.active || 'YES');
                }
            },
            error: function(xhr) {
                iziToast.error({
                    title: 'Error',
                    message: xhr.responseJSON?.message || 'Failed to load social media data',
                    position: 'topRight'
                });
            }
        });
    }

    // Show modal - Bootstrap 5 compatible
    const modalElement = document.getElementById('socialMediaModal');
    if (modalElement) {
        const modal = new bootstrap.Modal(modalElement);
        modal.show();
    } else {
        // Fallback for jQuery/Bootstrap 4
        $('#socialMediaModal').modal('show');
    }
}

// Auto-fill icon on platform change
$(document).on('change', '#socialPlatform', function() {
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

$(document).on('submit', '#socialMediaForm', function(e) {
    e.preventDefault();
    
    const id = $('#socialMediaId').val();
    const url = id ? `/admin/settings/frontend/social-media/${id}` : '{{ route("admin.settings.frontend.social-media.store") }}';
    const method = id ? 'PUT' : 'POST';
    
    // Prepare form data
    let formData = $(this).serialize();
    if (method === 'PUT') {
        formData += '&_method=PUT';
    }

    // Show loading state
    const submitBtn = $(this).find('button[type="submit"]');
    const originalText = submitBtn.html();
    submitBtn.prop('disabled', true).html('<i class="icofont-spinner-alt-4 spin"></i> Saving...');

    $.ajax({
        url: url,
        method: 'POST',
        data: formData,
        success: function(response) {
            if (response.success) {
                iziToast.success({
                    title: 'Success',
                    message: response.message,
                    position: 'topRight'
                });
                
                // Hide modal - Bootstrap 5 compatible
                const modalElement = document.getElementById('socialMediaModal');
                if (modalElement) {
                    const modalInstance = bootstrap.Modal.getInstance(modalElement);
                    if (modalInstance) {
                        modalInstance.hide();
                    } else {
                        $('#socialMediaModal').modal('hide');
                    }
                }
                
                // Reload page after short delay
                setTimeout(function() {
                    location.reload();
                }, 500);
            } else {
                iziToast.error({
                    title: 'Error',
                    message: response.message || 'Failed to save social media link',
                    position: 'topRight'
                });
                submitBtn.prop('disabled', false).html(originalText);
            }
        },
        error: function(xhr) {
            let errorMessage = 'An error occurred';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                const errors = xhr.responseJSON.errors;
                errorMessage = Object.values(errors).flat().join('<br>');
            }
            
            iziToast.error({
                title: 'Error',
                message: errorMessage,
                position: 'topRight'
            });
            submitBtn.prop('disabled', false).html(originalText);
        }
    });
});


function deleteSocialMedia(id) {
    if (!id) {
        iziToast.error({
            title: 'Error',
            message: 'Invalid social media link ID',
            position: 'topRight'
        });
        return;
    }

    if (confirm('Are you sure you want to delete this social media link?')) {
        $.ajax({
            url: `/admin/settings/frontend/social-media/${id}`,
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(response) {
                if (response.success) {
                    iziToast.success({
                        title: 'Success',
                        message: response.message,
                        position: 'topRight'
                    });
                    setTimeout(function() {
                        location.reload();
                    }, 500);
                } else {
                    iziToast.error({
                        title: 'Error',
                        message: response.message || 'Failed to delete social media link',
                        position: 'topRight'
                    });
                }
            },
            error: function(xhr) {
                let errorMessage = 'An error occurred';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }
                iziToast.error({
                    title: 'Error',
                    message: errorMessage,
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


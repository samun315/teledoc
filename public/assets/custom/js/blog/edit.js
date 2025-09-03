// Form elements
let blogForm = $("#blogForm");
let titleInput = $("#title");
let contentInput = $("#content");

let featuredImageInput = $("#featured_image");
let statusSelect = $("#status");
let categorySelect = $("#category_id");
let tagsSelect = $("#tags");

let metaDescriptionInput = $("#meta_description");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/blog/blog";
const BLOG_ID = window.location.pathname.split('/').pop(); // Get blog ID from URL

// Form validation
let validate = blogForm.validate({
    rules: {
        title: "required",
        content: "required",
        status: "required",
    },
    messages: {
        title: "Please enter a title",
        content: "Please enter content",
        status: "Please select a status"
    },
    onsubmit: true,
});

$(document).ready(function() {
    // Image preview functionality
    featuredImageInput.change(function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImg').attr('src', e.target.result);
                $('#imagePreview').show();
            }
            reader.readAsDataURL(file);
        } else {
            $('#imagePreview').hide();
        }
    });

    // Character counters

    metaDescriptionInput.on('input', function() {
        const maxLength = 160;
        const currentLength = $(this).val().length;
        if (currentLength > maxLength) {
            $(this).val($(this).val().substring(0, maxLength));
        }
        updateCharacterCount('#meta_description', currentLength, maxLength);
    });

    // Initialize character counts
    updateCharacterCount('#meta_description', metaDescriptionInput.val().length, 160);
});

// Update character count display
function updateCharacterCount(selector, current, max) {
    const counter = $(selector).siblings('.char-counter');
    if (counter.length === 0) {
        $(selector).after(`<small class="char-counter text-muted"></small>`);
    }
    $(selector).siblings('.char-counter').text(`${current}/${max} characters`);
}

// Form submission
blogForm.submit(function (e) {
    e.preventDefault();

    if (!validate.valid()) return;

    loader(blogForm, true);

    // Setup CSRF token
    setCSRFToken();

    $(".error").remove();

    const formData = new FormData(this);
    formData.append("_method", "PUT");

    $.ajax({
        type: "POST",
        url: `${BASE_URL}/update/${BLOG_ID}`,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function(response) {
            loader(blogForm, false);
            if (response.success) {
                toastr.success('Blog post updated successfully');
                    window.location.href = BASE_URL;
            } else {
                toastr.error(response.message || 'Failed to update blog post');
            }
        },
        error: function(xhr) {
            loader(blogForm, false);
            if (xhr.status === 422) {
                displayValidationErrors(xhr.responseJSON?.errors);
            } else {
                toastr.error(xhr.responseJSON?.message || 'An unexpected error occurred');
            }
        }
    });
});

// Auto-generate slug from title
titleInput.on('blur', function() {
    const title = $(this).val();
    if (title) {
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '')
            .replace(/\s+/g, '-')
            .replace(/-+/g, '-')
            .trim('-');

        // You can add a hidden slug field if needed
        // $('#slug').val(slug);
    }
});



// Form reset functionality
$(".formReset").on("click", function () {
    formReset();
});

function formReset() {
    // Reload the page to reset to original values
    window.location.reload();
}

// Image validation
featuredImageInput.on('change', function() {
    const file = this.files[0];
    if (file) {
        // Check file size (2MB = 2 * 1024 * 1024 bytes)
        if (file.size > 2 * 1024 * 1024) {
            toastr.error('File size must be less than 2MB');
            $(this).val('');
            return;
        }

        // Check file type
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
        if (!allowedTypes.includes(file.type)) {
            toastr.error('Please select a valid image file (JPEG, PNG, JPG, GIF)');
            $(this).val('');
            return;
        }
    }
});

// Delete blog functionality
$('.delete-blog-btn').on('click', function() {
    const blogId = $(this).data('id');
    const blogTitle = $(this).data('title');

    if (confirm(`Are you sure you want to delete "${blogTitle}"?`)) {
        $.ajax({
            type: 'POST',
            url: `${BASE_URL}/${blogId}`,
            data: {
                _method: 'DELETE',
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toastr.success('Blog post deleted successfully');
                window.location.href = BASE_URL;
            },
            error: function(xhr) {
                toastr.error('Failed to delete blog post');
            }
        });
    }
});


function MyUploadAdapter(loader) {
    this.loader = loader;
}

MyUploadAdapter.prototype.upload = function() {
    return this.loader.file.then(file => new Promise((resolve, reject) => {
        const data = new FormData();
        data.append('upload', file);

        fetch(`/store/upload-image`, {
            method: 'POST',
            body: data,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(response => response.json())
        .then(result => {
            resolve({ default: result.url }); // return uploaded file URL
        })
        .catch(err => reject(err));
    }));
};

function MyCustomUploadAdapterPlugin(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
        return new MyUploadAdapter(loader);
    };
}

document.addEventListener("DOMContentLoaded", () => {
    const contentElement = document.querySelector("#content");
    let editorInstance;

    if (contentElement) {
        ClassicEditor.create(contentElement, {
            styleNonce: "{{ $cspNonce }}",
            extraPlugins: [ MyCustomUploadAdapterPlugin ]
        })
            .then((editor) => {
                editorInstance = editor;
            })
            .catch((error) => {
                console.error("Error initializing CKEditor:", error);
            });


    } else {
        console.warn("No element with id '#content' found.");
    }
});

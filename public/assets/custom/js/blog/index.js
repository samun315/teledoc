// Get the current URL of the window
const BASE_URL = window.location.origin + "/blog/blog";

// Delete confirmation functionality
$(document).ready(function() {
    // Delete confirmation - use event delegation for dynamically generated content
    $(document).on('click', '.delete-btn', function() {
        const id = $(this).data('id');
        const title = $(this).data('title');

        $('#blogTitle').text(title);
        $('#deleteForm').attr('action', `${BASE_URL}/delete/${id}`);
        $('#deleteModal').modal('show');
    });
});

// DataTable initialization for blog listing
let table = $("#kt_blog_table").DataTable({
    processing: false,
    serverSide: false,
    columns: [
        {
            data: null,
            orderable: false,
            searchable: false,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
                { data: 1 }, // Featured Image
        { data: 2 }, // Title
        { data: 3 }, // Category
        { data: 4 }, // Status
        { data: 5 }, // Created At
        {
            data: 6, // Action
            orderable: false,
            searchable: false
        }
    ],
    columnDefs: [
        {
            targets: "_all",
            defaultContent: "",
        },
    ],
    order: [[5, 'desc']], // Order by created_at descending
    pageLength: 10,
    responsive: true,
    language: {
        processing: "Loading...",
        emptyTable: "No blog posts found",
        zeroRecords: "No matching records found"
    }
});

// Search functionality is handled by DataTables built-in search

// Handle delete form submission
$('#deleteForm').on('submit', function(e) {
    e.preventDefault();

    const form = $(this);
    const url = form.attr('action');

    $.ajax({
        type: 'POST',
        url: url,
        data: form.serialize(),
        success: function(response) {
            $('#deleteModal').modal('hide');
            toastr.success('Blog post deleted successfully');
            // Reload the page to refresh the data
            window.location.reload();
        },
        error: function(xhr) {
            toastr.error('Failed to delete blog post');
        }
    });
});

// Refresh table on modal close
$('#deleteModal').on('hidden.bs.modal', function () {
    $('#deleteForm')[0].reset();
    $('#blogTitle').text('');
});

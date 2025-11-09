// Select the form element with the id attribute "submitForm"
let selectedForm = $("#submitForm");

let search = $("#search");

// Get the current URL of the window
const BASE_URL = window.location.origin + "/blog/blog-tag";

let validate = selectedForm.validate({
    rules: {
        tag_name: "required",
        status: "required",
    },
    onsubmit: true,
});

$(".formReset").on("click", function () {
    formReset();
});

function formReset() {
    $("#submitForm").trigger("reset");
    $("#kt_status").val("Active").trigger("change");
}

$("#openBlogTagModal").on("click", function () {
    openBlogTagModal();
});

function openBlogTagModal() {
    formReset();

    $("#kt_blog_tag_id").val(null);
    loader(selectedForm, false);

    $("#modalTitle").html("Add Blog Tag");
    $(".btnSubmit").html("Save");
    $("#showModal").modal("show");
}

selectedForm.submit(function (e) {
    e.preventDefault();

    if (!validate.valid()) return;

    loader(selectedForm, true);

    // Setup CSRF token
    setCSRFToken();

    $(".error").remove();

    const formData = new FormData(this);

    const blogTagId = $("#kt_blog_tag_id").val();
    let URL = `${BASE_URL}/store`;

    // Append _method if METHOD is PUT
    if (blogTagId) {
        URL = `${BASE_URL}/update/${blogTagId}`;
        formData.append("_method", "PUT");
    }

    $.ajax({
        type: "POST", // Always use POST for FormData, append _method for PUT
        url: URL,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: handleSuccessWithModal,
        error: handleError,
    });
});

// fetch the data
let table = $("#kt_blog_tag_table").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL,
        data: function (d) {
            d.search = search.val();
        },
    },
    columns: [
        {
            data: "DT_RowIndex",
            name: "DT_RowIndex",
            orderable: false,
            searchable: false,
        },
        {
            data: "tag_name",
            name: "tag_name",
        },
        {
            data: "description",
            name: "description",
        },
        {
            data: "slug",
            name: "slug",
        },
        {
            data: "status",
            render: function (data) {
                if (!data) return "";

                let status = "";

                if (data == "Active") {
                    status = "badge badge-success";
                } else {
                    status = "badge badge-danger";
                }

                return `<p class="${status}">${data}</p>`;
            },
        },
        {
            data: "action",
            name: "action",
        },
    ],
    columnDefs: [
        {
            targets: "_all",
            defaultContent: "",
        },
    ],
});

search.keyup(function () {
    table.draw();
});

//  GET EDIT BLOG TAG INFO DATA
$(document).on("click", ".editBlogTagBtn", function () {
    let blog_tag_id = $(this).attr("data-id");
    getBlogTagInfo(blog_tag_id);
});

function getBlogTagInfo(blog_tag_id) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        type: "GET",
        url: `${BASE_URL}/edit/${blog_tag_id}`,
        dataType: "json",
        success: (response) => {
            loader(selectedForm, false);

            if (response?.success && response?.statusCode === 200) {
                const { blogTagInfo } = response;

                $("#kt_blog_tag_id").val(blogTagInfo?.blog_tag_id);
                $("#kt_tag_name").val(blogTagInfo?.tag_name);
                $("#kt_description").val(blogTagInfo?.description);
                $("#kt_status").val(blogTagInfo?.status).trigger("change");

                $("#modalTitle").html("Edit Blog Tag");
                $(".btnSubmit").html("Update");
                $("#showModal").modal("show");
            } else {
                toastr.error(
                    response?.message || "An unexpected error occurred."
                );
            }
        },
        error: (jqXHR) => {
            loader(selectedForm, false);

            if (jqXHR.status === 422) {
                displayValidationErrors(jqXHR.responseJSON?.errors);
            } else {
                toastr.error(
                    jqXHR.responseJSON?.message ||
                        "An unexpected error occurred."
                );
            }
        },
    });
}

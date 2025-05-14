$(document).ready(function () {
    $("#kt_role_id").select2({
        placeholder: "Select Role",
        allowClear: true,
    });
});

let selectedForm = $("#submitForm");
let selectedPasswordForm = $("#passwordChangeForm");
// Get the current URL of the window
const BASE_URL = window.location.origin + "/users";

let search = $("#search");

let validate = selectedForm.validate({
    rules: {
        name: "required",
    },
    onsubmit: true,
});

let validatePassword = selectedPasswordForm.validate({
    rules: {
        name: "required",
    },
    onsubmit: true,
});

$(".password").show();

$(".formReset").on("click", function () {
    formReset();
});

function formReset() {
    $("#submitForm").trigger("reset");
    $("#passwordChangeForm").trigger("reset");
    $("#kt_role_id").val("").change();
    $("#kt_active").val("YES").change();
}

$("#openUserModal").on("click", function () {
    openModal();
});

function openModal() {
    formReset();
    loader(selectedForm, false);
    $("#kt_user_id").val(null);
    $("#showModal").modal("show");
    $(".modal-title").text("Add New User");
    $(".btnSubmit").text("Add");
    $(".password").show();
    $("#togglePasswordBtn").hide();
}

selectedForm.submit(function (event) {
    event.preventDefault();

    if (!validate.valid()) return;

    loader(selectedForm, true);

    let formData = new FormData($("form#submitForm")[0]);

    // Setup CSRF token
    setCSRFToken();

    $(".error").remove();

    let userId = $("#kt_user_id").val();
    let url = "";
    if (userId) {
        url = BASE_URL + "/update/" + userId;
        formData.append("_method", "PUT");
    } else {
        url = BASE_URL + "/store";
    }

    $.ajax({
        url: url,
        data: formData,
        type: "POST", // Always use POST for FormData, append _method for PUT
        cache: false,
        contentType: false,
        processData: false,
        success: handleSuccessWithModal,
        error: handleError,
    });
});

let table = $("#kt_table_users").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL + "/index",
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
            data: "user_name",
            name: "user_name",
        },
        {
            data: "full_name",
            name: "full_name",
        },
        {
            data: "email",
            name: "email",
        },
        {
            data: "phone",
            name: "phone",
        },
        {
            data: "role_name",
            name: "role_name",
        },
        {
            data: "action",
            name: "action",
        },
    ],
});

search.keyup(function () {
    table.draw();
});

$(document).on("click", ".edit-user, .view-user", function () {
    var user_id = $(this).attr("data-id");
    editUserInfo(user_id);
});


function editUserInfo(userId) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        url: BASE_URL + "/edit/" + userId,
        type: "GET",
        success: function (response) {
            loader(selectedForm, false);
            const data = response.userInfo;
            // console.log(data.item);
            if (response?.success && response?.statusCode === 200 && data) {
                $("#kt_user_id").val(data.id);
                $("#kt_role_id").val(data.role_id).change();
                $("#kt_full_name").val(data.full_name);
                $("#kt_email").val(data.email);
                $("#kt_phone").val(data.phone);
                $("#kt_user_name").val(data.user_name);
                $("#kt_address").val(data.address);
                $("#kt_country").val(data.country);
                $("#kt_nid").val(data.nid);
                $("#kt_diamond_per_usd").val(data.diamond_per_usd);
                $("#kt_active").val(data.active).change();

                $(".password").hide();
                $(".modal-title").text("Edit User");
                $(".btnSubmit").text("Update");
            }
        },
    });
}


$(document).on("click", ".changePasswordBtn", function () {
    var id = $(this).attr("data-id");
    $(".password").show();
    $("#kt_user_id_for_password").val(id);
});

selectedPasswordForm.submit(function (event) {
    event.preventDefault();

    if (!validatePassword.valid()) return;

    loader(selectedPasswordForm, true);

    let passwordData = new FormData($("form#passwordChangeForm")[0]);

    // Setup CSRF token
    setCSRFToken();

    $(".error").remove();

    let userPassId = $("#kt_user_id_for_password").val();
    let url = "";
    if (userPassId) {
        url = BASE_URL + "/reset-password/" + userPassId;
        passwordData.append("_method", "PUT");
    }

    $.ajax({
        url: url,
        data: passwordData,
        type: "POST", // Always use POST for FormData, append _method for PUT
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response?.statusCode === 200 || response?.statusCode === 201) {
                $("#kt_modal_change_password").modal('hide');
                toastr.success(response?.message);
                table.draw();
            }
        },
        error: handleError,
    });
});

// Generic function to toggle password visibility and icon
function togglePasswordVisibility(buttonSelector, fieldSelector, iconSelector) {
    $(buttonSelector).on("click", function () {
        const passwordField = $(fieldSelector);
        const icon = $(iconSelector);

        if (passwordField.attr("type") === "password") {
            passwordField.attr("type", "text");
            icon.removeClass("fas fa-eye").addClass("fa fa-eye-slash");
        } else {
            passwordField.attr("type", "password");
            icon.removeClass("fa fa-eye-slash").addClass("fas fa-eye");
        }
    });
}

// Initial setup of icons
$(".passwordIcon").addClass("fas fa-eye");

// Apply function to each button and field
togglePasswordVisibility(".togglePasswordBtn", ".kt_password", ".passwordIcon");

$(".kt_password").on("keyup",function(){
    if ($(this).val() == "") {
        $(".togglePasswordBtn").hide();
    } else {
        $(".togglePasswordBtn").show();
    }
});


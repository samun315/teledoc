let selectedForm = $("#submitForm");

const BASE_URL = window.location.origin + "/menu/menu-item";

const menuId = $("#kt_menu_id").val();

let validate = selectedForm.validate({
    rules: {
        name: "required",
    },
    onsubmit: true,
});

$(".formReset").on("click", function () {
    window.location.reload();
});

$("#openMenuItemModal").on("click", function () {
    openModal();
});

function openModal() {
    $("#kt_menu_item_id").val(null);
    $("#active").val('YES').trigger('change');
    loader(selectedForm, false);

    $(".menuItemTitle").html("Add Menu Item");
    $(".btnSubmit").html("Save");
    $("#showModal").modal("show");
}

// GET MODULE ITEM NAME USING MODULE ID

$("#kt_module_item_id").empty();
$("#kt_module_item_id").append('<option value="">Select Module Item</option>');

if ($("#hidden_module_item_id").val() == "") {
    $("#kt_module_id").on("change", function () {
        var moduleId = $(this).val();
        getModuleItemIdByModuleId(moduleId);
        getParentIdByModuleId(moduleId);
    });
}

function getModuleItemIdByModuleId(moduleId) {
    if (moduleId) {
        $.ajax({
            url: BASE_URL + "/module-item/" + moduleId,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let moduleItem = response?.data;

                if (
                    response?.success &&
                    response?.statusCode === 200 &&
                    moduleItem
                ) {
                    $("#kt_module_item_id").empty();
                    $("#kt_module_item_id").append(
                        '<option value="">Select Module Item</option>'
                    );

                    $.each(moduleItem, function (key, value) {
                        $("#kt_module_item_id").append(
                            '<option value="' +
                                value?.item_id +
                                '">' +
                                value?.item_name +
                                "</option>"
                        );
                    });

                    if ($("#hidden_module_item_id").val() != "") {
                        $("#kt_module_item_id")
                            .select2()
                            .val($("#hidden_module_item_id").val())
                            .trigger("change.select2");
                    }
                }
            },
        });
    } else {
        $("#kt_module_item_id").empty();
        $("#kt_module_item_id").append(
            '<option value="">Select Module Item</option>'
        );
    }
}

$("#kt_parent_id").empty();
$("#kt_parent_id").append('<option value="">Select Parent</option>');

function getParentIdByModuleId(moduleId) {
    if (moduleId) {
        $.ajax({
            url: BASE_URL + "/get-parent-id/" + moduleId,
            type: "GET",
            dataType: "json",
            success: function (response) {
                let parents = response?.data;

                if (
                    response?.success &&
                    response?.statusCode === 200 &&
                    parents
                ) {
                    $("#kt_parent_id").empty();
                    $("#kt_parent_id").append(
                        '<option value="">Select Parent</option>'
                    );

                    $.each(parents, function (key, value) {
                        $("#kt_parent_id").append(
                            '<option value="' +
                                value?.menu_item_id +
                                '">' +
                                value?.menu_item_name +
                                "</option>"
                        );
                    });

                    if ($("#hidden_parent_id").val() != "") {
                        $("#kt_parent_id")
                            .select2()
                            .val($("#hidden_parent_id").val())
                            .trigger("change.select2");
                    }
                }
            },
        });
    } else {
        $("#kt_parent_id").empty();
        $("#kt_parent_id").append('<option value="">Select Parent</option>');
    }
}

$("#kt_divider_title_name").hide();

$("#kt_type").on("change", function () {
    var type = $(this).val();
    getMenuType(type);
});

function getMenuType(type) {
    if (type === "divider") {
        $(".parentId").hide();
        $(".moduleItemId").hide();
        $(".url").hide();
        $(".iconClass").hide();
        $(".target").hide();
        $(".active").hide();
        $(".name").show();
    } else if (type === "parent") {
        $(".parentId").show();
        $(".url").hide();
        $(".iconClass").show();
        $(".target").hide();
        $(".active").show();
        $(".name").show();
        $(".moduleItemId").hide();
    } else {
        $(".parentId").show();
        $(".url").show();
        $(".iconClass").show();
        $(".target").show();
        $(".active").show();
        $(".name").show();
        $(".moduleItemId").show();
    }
}

selectedForm.submit(function (event) {
    event.preventDefault();

    if (!validate.valid()) return;

    loader(selectedForm, true);

    // Setup CSRF token
    setCSRFToken();

    $(".error").remove();

    const formData = new FormData(this);

    const menuItemId = $("#kt_menu_item_id").val();
    let URL = "";

    // Append _method if METHOD is PUT
    if (menuItemId) {
        URL = BASE_URL + "/update/" + menuItemId;
        formData.append("_method", "PUT");
    } else {
        URL = BASE_URL + "/store";
    }

    $.ajax({
        type: "POST", // Always use POST for FormData, append _method for PUT
        url: URL,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response?.statusCode === 200 || response?.statusCode === 201) {
                toastr.success(response?.message);
                setInterval(function () {
                    window.location.reload();
                }, 500);
            }
        },
        error: handleError,
    });
});

$(".editMenuItem").on("click", function () {
    var menuItemId = $(this).attr("data-edit-id");
    editMenuItemInfo(menuItemId);
});

function editMenuItemInfo(menuItemId) {
    loader(selectedForm, true);
    $(".error").remove();

    $.ajax({
        url: BASE_URL + "/edit/" + menuItemId,
        type: "GET",
        success: function (response) {
            loader(selectedForm, false);
            const data = response.itemInfo;
            // console.log(data.item);
            if (response?.success && response?.statusCode === 200 && data) {
                $("#hidden_module_item_id").val(data.module_item_id);
                $("#hidden_parent_id").val(data.parent_id);
                $("input[name='menu_item_id']").val(data.menu_item_id);
                $("select[name='module_id']")
                    .select2()
                    .val(data.module_id)
                    .trigger("change.select2");
                $("select[name='module_item_id']")
                    .select2()
                    .val(data.module_item_id)
                    .trigger("change.select2");

                getModuleItemIdByModuleId(data.module_id);

                if (
                    data.type === "menu_item" &&
                    (data.parent_id == null || data.parent_id != null) &&
                    data.url == null
                ) {
                    $("select[name='type']").val("parent").change();
                } else {
                    $("select[name='type']").val(data.type).change();
                }

                $("select[name='parent_id']").val(data.parent_id).change();

                getParentIdByModuleId(data.module_id);

                $("input[name='menu_item_name']").val(data.menu_item_name);
                $("input[name='url']").val(data.url);
                $("input[name='icon_class']").val(data.icon_class);
                $("input[name='target']").val(data.target);
                $("select[name='active']").val(data.active).change();
            }

            $(".menuItemTitle").html("Edit Menu Item");
            $(".btnSubmit").html("Update");
        },
    });
}

$(".deleteMenuItem").on("click", function () {
    let menuItemId = $(this).attr("data-delete-id");
    deleteData(menuItemId);
});

function deleteData(menuItemId) {
    Swal.fire({
        html: `Are you want to delete this?`,
        icon: "info",
        buttonsStyling: false,
        showCancelButton: true,
        confirmButtonText: "Yes, do it!",
        cancelButtonText: "Nope, cancel it",
        customClass: {
            confirmButton: "btn btn-primary",
            cancelButton: "btn btn-danger",
        },
    }).then(
        function (e) {
            if (e.value === true) {
                setCSRFToken();
                $.ajax({
                    type: "DELETE",
                    url: BASE_URL + "/destroy/" + menuItemId,
                    dataType: "JSON",
                    success: function (response) {
                        if (response?.statusCode === 200) {
                            toastr.success(response?.message, "Success!");
                            setInterval(function () {
                                window.location.reload();
                            }, 500);
                        } else {
                            toastr.error(
                                "Could not delete parent, need to delete child first.'!"
                            );
                        }
                    },
                    error: function (data) {
                        toastr.error(
                            data?.message || "An unexpected error occurred."
                        );
                    },
                });
            } else {
                e.dismiss;
            }
        },
        function (dismiss) {
            return false;
        }
    );
}

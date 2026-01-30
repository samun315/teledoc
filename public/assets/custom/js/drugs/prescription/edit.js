// Get the current URL of the window
const BASE_URL = window.location.origin + "/drug/prescription";
const ORIGIN_URL = window.location.origin;

let prescription_id;
if (typeof prescriptionData != "undefined") {
    prescription_id = prescriptionData.prescription_id;

    getOldPrescriptionList(prescription_id);
}

// SUBSCRIPTION TYPE AND DETAILS ADD
let selectedSubscriptionTypeId = null;
let selectedTextarea = null;

$(".addMoreBtn").on("click", function name() {

    selectedSubscriptionTypeId = $(this).data("subscription-type-id");
    selectedTextarea = $("#subscription_details_" + selectedSubscriptionTypeId);

    $("#modalTitle").text($(this).data("subscription-type") + " List");
    $("#showSubscriptionModal").modal("show");

    getSubscriptionData(selectedSubscriptionTypeId);

});

function getSubscriptionData(selectedSubscriptionTypeId) {
    $.ajax({
        type: "GET",
        url: `${BASE_URL}/get-subscriptions/` + selectedSubscriptionTypeId,
        dataType: "json",
        success: (response) => {
            if (response?.success && response?.statusCode === 200) {
                const { subscriptions } = response;
                const $subscriptionList = $('#subscriptionList');
                $subscriptionList.empty();

                if (Array.isArray(subscriptions) && subscriptions.length > 0) {
                    subscriptions.forEach(subscription => {
                        const subscriptionItem = `
                        <div class="form-check select-subscription mb-5">
                            <input class="form-check-input" type="checkbox" value="${subscription.subscription_name}" id="subscriptionId${subscription.subscription_id}" />
                            <label class="form-check-label fw-bold subscription-name ms-3" for="subscriptionId">
                                ${subscription.subscription_name}
                            </label>
                        </div>
                        `;
                        $subscriptionList.append(subscriptionItem);
                    });

                    // Reapply search if user already typed something
                    $('#search').trigger('keyup');
                } else {
                    $subscriptionList.html('<p class="text-muted">No subscription found.</p>');
                }
            } else {
                toastr.error(response?.message || "An unexpected error occurred.");
            }
        },
        error: (jqXHR) => {
            if (jqXHR.status === 422) {
                displayValidationErrors(jqXHR.responseJSON?.errors);
            } else {
                toastr.error(jqXHR.responseJSON?.message || "An unexpected error occurred.");
            }
        },
    });
}

// Prevent form submission on Enter inside search box
$('#search').on('keypress', function (e) {
    if (e.which === 13) e.preventDefault();
});

// Live search: filter by name or phone
$('#search').on('keyup', function () {
    const term = $(this).val().toLowerCase().trim();

    $('#subscriptionList .select-subscription').each(function () {
        const name = $(this).find('.subscription-name').text().toLowerCase();

        if (term === '' || name.includes(term)) {
            $(this).removeClass('d-none').addClass('d-flex');
        } else {
            $(this).removeClass('d-flex').addClass('d-none');
        }
    });

    // Check if any patient is visible after filtering
    if ($('#subscriptionList .select-subscription.d-flex').length === 0) {
        // If none visible, show "No patients found"
        if ($('#subscriptionList .no-subscription-message').length === 0) {
            $('#subscriptionList').append('<p class="no-subscription-message text-muted">No subscriptions found.</p>');
        }
    } else {
        // Remove the message if patients are visible
        $('#subscriptionList .no-subscription-message').remove();
    }
});


$(".btnAddSubscription").on("click", function () {
    const selectedNames = [];
    const searchText = $('#search').val().trim().toLowerCase();

    $('#subscriptionList .select-subscription input:checked').each(function () {
        selectedNames.push($(this).closest('.select-subscription').find('.subscription-name').text().trim());
    });

    // Case 1: At least one checkbox selected
    if (selectedNames.length > 0) {
        updateTextarea(selectedNames);
        resetSubscriptionModal();
        $("#showSubscriptionModal").modal("hide");
        return;
    }

    // Case 2: No checkbox selected, check if search matches any existing item
    let matchFound = false;

    $('#subscriptionList .subscription-name').each(function () {
        const existingName = $(this).text().trim().toLowerCase();
        if (existingName === searchText) {
            matchFound = true;
            return false; // break loop
        }
    });

    if (matchFound) {
        // Match found but not checked → don't allow auto-add
        toastr.warning("This item already exists in the list. Please select it instead of creating a new one.");
        return;
    }

    // Case 3: No match found → create new
    if (searchText !== '') {
        $.ajax({
            type: "POST",
            url: `${BASE_URL}/create-subscription/` + selectedSubscriptionTypeId,
            data: {
                subscription_name: searchText,
                _token: $('meta[name="csrf-token"]').attr('content'),
            },
            success: function (response) {
                if (response.success) {
                    selectedNames.push(response.subscription.subscription_name);
                    updateTextarea(selectedNames);
                    resetSubscriptionModal();
                    $("#showSubscriptionModal").modal("hide");
                } else {
                    toastr.error("Failed to create subscription.");
                }
            },
            error: function () {
                toastr.error("Server error occurred.");
            }
        });
        return;
    }

    // Case 4: Empty search, nothing selected
    toastr.warning("Please select at least one item or add new using the search bar!");
});


function resetSubscriptionModal() {
    // Uncheck all checkboxes
    $('#subscriptionList .select-subscription input:checked').prop('checked', false);

    // Clear the search input
    $('#search').val('');

    // Optional: Clear or refresh the search results list
    $('#subscriptionList').find('.subscription-name').removeClass('highlight'); // example

    // Optional: If you want to reload the list dynamically
    // reloadSubscriptionList(); // your custom function (if any)
}


function updateTextarea(names) {
    const existing = selectedTextarea.val();
    const updated = existing ? existing.split('\n') : [];

    names.forEach(name => {
        if (!updated.includes(name)) {
            updated.push(name);
        }
    });

    selectedTextarea.val(updated.join("\n"));
}


// Initialize Select2 with tags and search functionality for Type, Strength, Duration, Advice
function initializeSelect2WithAdd(selectId, apiRoute, fieldName, labelText) {
    const $select = $(selectId);

    // Destroy existing Select2 if already initialized
    if ($select.hasClass("select2-hidden-accessible")) {
        $select.select2('destroy');
    }

    // Store original option texts to check against
    const originalOptionTexts = [];
    $select.find('option').each(function() {
        const optionText = $(this).text().toLowerCase().trim();
        const optionValue = $(this).val();
        if (optionValue && optionText) {
            originalOptionTexts.push(optionText);
        }
    });

    // Initialize Select2 with tags
    $select.select2({
        tags: true,
        allowClear: true,
        placeholder: labelText,
        width: '100%'
    });

    // Handle when user clicks on a new item (tag) in the dropdown
    $select.on('select2:selecting', function(e) {
        const selectedData = e.params.args.data;
        const selectedText = selectedData.text.trim();
        const selectedId = selectedData.id;

        // Check if the selected text already exists in the original options
        const textExists = originalOptionTexts.includes(selectedText.toLowerCase());

        // Check if it's an existing option (ID is numeric, not equal to text)
        const isExistingOption = selectedId && selectedId !== selectedText && !isNaN(selectedId);

        // If it's a new item (text doesn't exist and ID equals text, meaning it's a tag)
        if (!textExists && !isExistingOption && selectedText !== '') {
            // Prevent the default selection
            e.preventDefault();

            // Show confirmation popup
            showAddConfirmation(selectId, apiRoute, fieldName, selectedText, labelText);
        }
    });
}

// Show confirmation popup and create new item
function showAddConfirmation(selectId, apiRoute, fieldName, itemName, labelText) {
    Swal.fire({
        title: `Add new ${labelText}?`,
        text: `Do you want to add "${itemName}" as a new ${labelText.toLowerCase()}?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, Add',
        cancelButtonText: 'Cancel',
        confirmButtonColor: '#198754',
        cancelButtonColor: '#dc3545',
    }).then((result) => {
        if (result.isConfirmed) {
            // User confirmed - create the item
            createNewDropdownItem(selectId, apiRoute, fieldName, itemName, labelText);
        } else {
            // User cancelled - no action, dropdown will remain unchanged
        }
    });
}

// Create new item via AJAX
function createNewDropdownItem(selectId, apiRoute, fieldName, itemName, labelText) {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    const $select = $(selectId);

    // Prepare data based on field name
    const formData = {};
    formData[fieldName] = itemName;
    formData['status'] = 'Active';

    // Special handling for dose - needs drug_type_id
    if (fieldName === 'drug_dose') {
        const drugTypeId = $('#kt_drug_type_id').val();
        if (!drugTypeId) {
            toastr.error('Please select a Type first before adding Dose.');
            $select.select2('close');
            return;
        }
        formData['drug_type_id'] = drugTypeId;
    }

    $.ajax({
        url: ORIGIN_URL + apiRoute,
        type: 'POST',
        data: formData,
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        beforeSend: function() {
            // Show loading
            $select.prop('disabled', true);
        },
        success: function(response) {
            if (response.success && response.statusCode === 201) {
                // Get the new item data from response
                let newId, newText;
                const responseData = response.data || {};

                if (fieldName === 'drug_type') {
                    newId = responseData.drug_type_id;
                    newText = responseData.drug_type || itemName;
                } else if (fieldName === 'drug_strength') {
                    newId = responseData.drug_strength_id;
                    newText = responseData.drug_strength || itemName;
                } else if (fieldName === 'drug_duration') {
                    newId = responseData.drug_duration_id;
                    newText = responseData.drug_duration || itemName;
                } else if (fieldName === 'drug_advice') {
                    newId = responseData.drug_advice_id;
                    newText = responseData.drug_advice || itemName;
                } else if (fieldName === 'drug_dose') {
                    newId = responseData.drug_dose_id;
                    newText = responseData.drug_dose || itemName;
                }

                // Add new option to select
                if (newId) {
                    const newOption = new Option(newText, newId, true, true);
                    $select.append(newOption).trigger('change');
                    toastr.success(`${labelText} added successfully!`);
                } else {
                    toastr.error('Failed to get new item ID from response.');
                }
            } else {
                toastr.error(response.message || 'Failed to add item.');
            }
        },
        error: function(xhr) {
            const errorMsg = xhr.responseJSON?.message || 'Failed to add item.';
            toastr.error(errorMsg);
        },
        complete: function() {
            $select.prop('disabled', false);
        }
    });
}

// DRUG DOSE FETCH

$("#kt_drug_dose_id").empty();

$(document).on('change', '#kt_drug_type_id', function () {
    const drugTypeId = $(this).val();

    // Clear dose dropdown when type changes
    $('#kt_drug_dose_id').val(null).trigger('change');

    if (drugTypeId) {
        getDrugDoseByDrugType(drugTypeId, null);
    } else {
        // Clear dose dropdown if no type selected
        if ($("#kt_drug_dose_id").hasClass("select2-hidden-accessible")) {
            $("#kt_drug_dose_id").select2('destroy');
        }
        $("#kt_drug_dose_id").empty().append('<option value="">Dose</option>');
    }
});

function getDrugDoseByDrugType(drugTypeId, selectedDoseId = null) {
    const $dose = $("#kt_drug_dose_id");

    if (drugTypeId) {
        $.ajax({
            url: BASE_URL + "/get-drug-dose/" + drugTypeId,
            type: "GET",
            success: function (response) {
                let data = response?.doses;

                $dose.empty();
                $dose.append('<option value="">Dose</option>');

                if (response?.success && response?.statusCode === 200 && data) {
                    $.each(data, function (key, value) {
                        $dose.append(
                            '<option value="' +
                            value?.drug_dose_id +
                            '">' +
                            value?.drug_dose +
                            "</option>"
                        );
                    });
                }

                // Reinitialize Select2 with tags functionality for dose (only if type is selected)
                if (drugTypeId) {
                    initializeSelect2WithAdd('#kt_drug_dose_id', '/drug/drug-doses/store', 'drug_dose', 'Dose');
                }

                // ⭐ Select the dose if provided
                if (selectedDoseId) {
                    $dose.val(selectedDoseId).trigger("change");
                } else {
                    $dose.val("").trigger("change");
                }
            },
        });
    } else {
        // Clear dose dropdown if no type selected
        if ($dose.hasClass("select2-hidden-accessible")) {
            $dose.select2('destroy');
        }
        $dose.empty();
        $dose.append('<option value="">Dose</option>');
        $dose.val("").trigger("change");
    }
}


let editingDrugIndex = null;

// Add Drug
$('#btnAddDrug').on('click', function () {
    const drugData = getDrugFormData();
    if (!drugData) return;

    const html = generateDrugCard(drugData, Date.now());
    $('#drugListWrapper').append(html);

    resetDrugForm();
});

// Update Drug
$('#btnUpdateDrug').on('click', function () {
    if (editingDrugIndex === null) {
        toastr.warning("No drug selected for update.");
        return;
    }

    const drugData = getDrugFormData();
    if (!drugData) return;

    const html = generateDrugCard(drugData, editingDrugIndex);
    $(`.drug-item[data-drug-index="${editingDrugIndex}"]`).replaceWith(html);

    editingDrugIndex = null;
    resetDrugForm();
    $('#btnUpdateDrug').removeClass('d-block');
    $('#btnUpdateDrug').addClass('d-none');
    $('#btnAddDrug').removeClass('d-none');
    $('#btnAddDrug').addClass('d-block');
});

// Remove
$(document).on('click', '.remove-drug-btn', function () {
    $(this).closest('.card').remove();
});

// Edit (just load data to form)
$(document).on('click', '.edit-drug-btn', function () {
    const card = $(this).closest('.card');
    editingDrugIndex = card.data('drug-index');

    const typeId = card.find('input[name="drug_type_id[]"]').val();
    const drugId = card.find('input[name="drug_id[]"]').val();
    const strengthId = card.find('input[name="drug_strength_id[]"]').val();
    const doseId = card.find('input[name="drug_dose_id[]"]').val();
    const durationId = card.find('input[name="drug_duration_id[]"]').val();
    const adviceId = card.find('input[name="drug_advice_id[]"]').val();

    // Independent selects
    $('#kt_drug_type_id').val(typeId).trigger('change');
    $('#kt_drug_id').val(drugId).trigger('change');
    $('#kt_drug_strength_id').val(strengthId).trigger('change');
    $('#kt_drug_duration_id').val(durationId).trigger('change');
    $('#kt_drug_advice_id').val(adviceId).trigger('change');

    // 🔥 Dependent dose load + set selected
    getDrugDoseByDrugType(typeId, doseId);

    $('#btnUpdateDrug').removeClass('d-none');
    $('#btnUpdateDrug').addClass('d-block');
    $('#btnAddDrug').removeClass('d-block');
    $('#btnAddDrug').addClass('d-none');
});

// Helper: Get data from form
function getDrugFormData() {
    const drugTypeText = $('#kt_drug_type_id option:selected').text();
    const medicineText = $('#kt_drug_id option:selected').text();
    const strengthText = $('#kt_drug_strength_id option:selected').text();
    const doseText = $('#kt_drug_dose_id option:selected').text();
    const durationText = $('#kt_drug_duration_id option:selected').text();
    const adviceText = $('#kt_drug_advice_id option:selected').text();

    const drugTypeId = $('#kt_drug_type_id').val();
    const drugId = $('#kt_drug_id').val();
    const strengthId = $('#kt_drug_strength_id').val();
    const doseId = $('#kt_drug_dose_id').val();
    const durationId = $('#kt_drug_duration_id').val();
    const adviceId = $('#kt_drug_advice_id').val();

    // Only Medicine field is mandatory
    if (!drugId) {
        toastr.warning("Please select Medicine before adding.");
        return null;
    }

    return { drugTypeText, medicineText, strengthText, doseText, durationText, adviceText, drugTypeId, drugId, strengthId, doseId, durationId, adviceId };
}

// Helper: Generate drug card HTML
function generateDrugCard(data, index) {
    // Build display text with only filled fields
    let displayParts = [];
    if (data.drugTypeText && data.drugTypeId) {
        displayParts.push(`<strong>Form:</strong> ${data.drugTypeText}`);
    }
    if (data.medicineText && data.drugId) {
        displayParts.push(`<strong>Medicine:</strong> ${data.medicineText}`);
    }
    if (data.strengthText && data.strengthId) {
        displayParts.push(`<strong>Strength:</strong> ${data.strengthText}`);
    }
    if (data.doseText && data.doseId) {
        displayParts.push(`<strong>Frequency:</strong> ${data.doseText}`);
    }
    if (data.durationText && data.durationId) {
        displayParts.push(`<strong>Duration:</strong> ${data.durationText}`);
    }
    if (data.adviceText && data.adviceId) {
        displayParts.push(`<strong>Instruction:</strong> ${data.adviceText}`);
    }

    return `
        <div class="card card-body border shadow-sm position-relative drug-item" data-drug-index="${index}">
            <div>
                ${displayParts.join(' | ')}
            </div>
            <div class="position-absolute top-0 end-0 m-2">
                <button type="button" class="btn btn-sm btn-light-danger bg-transparent btn-icon remove-drug-btn"><i class="fas fa-times"></i></button>
                <button type="button" class="btn btn-sm btn-light-primary bg-transparent btn-icon edit-drug-btn"><i class="fas fa-edit"></i></button>
          </div>

            <!-- Hidden inputs -->
            <input type="hidden" name="drug_type_id[]" value="${data.drugTypeId || ''}">
            <input type="hidden" name="drug_id[]" value="${data.drugId}">
            <input type="hidden" name="drug_strength_id[]" value="${data.strengthId || ''}">
            <input type="hidden" name="drug_dose_id[]" value="${data.doseId || ''}">
            <input type="hidden" name="drug_duration_id[]" value="${data.durationId || ''}">
            <input type="hidden" name="drug_advice_id[]" value="${data.adviceId || ''}">
        </div>
    `;
}

// Helper: Reset form
function resetDrugForm() {
    $('#kt_drug_type_id').val('').trigger('change');
    $('#kt_drug_id').val('').trigger('change');
    $('#kt_drug_strength_id').val('').trigger('change');
    $('#kt_drug_dose_id').val('').trigger('change');
    $('#kt_drug_duration_id').val('').trigger('change');
    $('#kt_drug_advice_id').val('').trigger('change');
}

// Initialize flatpickr with today's date as default
const datePicker = $("#kt_prescription_date").flatpickr({
    dateFormat: "Y-m-d",
    defaultDate: "today",
    maxDate: "today",
});

// Make icon open date picker
$("#dateIcon").on("click", function () {
    datePicker.open();
});

// GET OLD PRESCRIPTION LIST
$('#kt_prescription_id').on('change', function () {
    let prescriptionId = $(this).val();
    getOldPrescriptionList(prescriptionId);
});

function getOldPrescriptionList(prescriptionId) {
    $.ajax({
        url: BASE_URL + '/get-old-prescriptions/' + prescriptionId,
        method: 'GET',
        beforeSend: function () {
            $('#drugListWrapper').html('<p class="text-info">Loading prescriptions...</p>');
        },
        success: function (response) {
            const medications = response.prescription || [];

            if (medications.length === 0) {
                $('#drugListWrapper').html('<p class="text-danger">No prescriptions found.</p>');
                return;
            }

            let grouped = {};
            medications.forEach(med => {
                let pid = med.prescription_id;
                if (!grouped[pid]) {
                    grouped[pid] = {
                        prescription_id: pid,
                        drugs: []
                    };
                }
                grouped[pid].drugs.push(med);
            });

            let html = '';
            Object.values(grouped).forEach((prescription) => {
                if (prescription.drugs.length === 0) {
                    html += '<p>No drugs found.</p>';
                } else {
                    prescription.drugs.forEach((drug, dIndex) => {
                        const drugData = {
                            drugTypeText: drug.drug_type ?? '',
                            medicineText: drug.trade_name ?? '',
                            strengthText: drug.drug_strength ?? '',
                            doseText: drug.drug_dose ?? '',
                            durationText: drug.drug_duration ?? '',
                            adviceText: drug.drug_advice ?? '',

                            drugTypeId: drug.drug_type_id ?? '',
                            drugId: drug.drug_id ?? '',
                            strengthId: drug.drug_strength_id ?? '',
                            doseId: drug.drug_dose_id ?? '',
                            durationId: drug.drug_duration_id ?? '',
                            adviceId: drug.drug_advice_id ?? '',
                        };
                        html += generateDrugCard(drugData, dIndex);

                        const date = new Date(drug.prescription_date);
                        const year = date.getFullYear();
                        const month = String(date.getMonth() + 1).padStart(2, '0'); // months are 0-based
                        const day = String(date.getDate()).padStart(2, '0');
                        const formattedDate = `${year}-${month}-${day}`;

                        $("#kt_prescription_date").val(formattedDate);

                    });
                }
            });

            $('#drugListWrapper').html(html);
        },

        error: function () {
            $('#drugListWrapper').html('<p class="text-danger">Error loading prescriptions.</p>');
        }
    });
}

// form submit validation
$('#prescriptionForm').on('submit', function (e) {
    toastr.clear();

    let doctorId = $('#kt_doctor_id').val();
    if (!doctorId) {
        e.preventDefault();
        toastr.error('Please select a doctor before submitting.');
        // focus and open select2 dropdown
        $('#kt_doctor_id').select2('open');
        return false;
    }

    let prescriptionDate = $('#kt_prescription_date').val();
    if (!prescriptionDate) {
        e.preventDefault();
        toastr.error('Please select a prescription date before submitting.');
        $('#kt_prescription_date').focus();
        return false;
    }

});

// Initialize Select2 with add functionality for Type, Strength, Duration, Advice dropdowns
// This will run after page load and Select2 initialization
setTimeout(function() {
    // Initialize Type dropdown
    initializeSelect2WithAdd('#kt_drug_type_id', '/drug/drug-type/store', 'drug_type', 'Type');

    // Initialize Strength dropdown
    initializeSelect2WithAdd('#kt_drug_strength_id', '/drug/drug-strength/store', 'drug_strength', 'Strength');

    // Initialize Duration dropdown
    initializeSelect2WithAdd('#kt_drug_duration_id', '/drug/drug-duration/store', 'drug_duration', 'Duration');

    // Initialize Advice dropdown
    initializeSelect2WithAdd('#kt_drug_advice_id', '/drug/drug-advice/store', 'drug_advice', 'Advice');

    // Note: Dose dropdown will be initialized when Type is selected (handled in getDrugDoseByDrugType)
}, 1000);

// NEW MEDICINE ADD CODE (from index.js)
let selectedForm = $("#submitForm");

let validate = selectedForm.validate({
    rules: {
        name: "required",
    },
    onsubmit: true,
});

$(".formReset").on("click", function () {
    formReset();
});

function formReset() {
    $("#submitForm").trigger("reset");
    $(".status").val("Active").trigger("change");
}

$("#openDrugModal").on("click", function () {
    openDrugModal();
});

function openDrugModal() {
    formReset();

    $("#kt_drug_id").val(null);
    loader(selectedForm, false);

    $("#modalTitle").html("Add Drug");
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

    let URL = `${ORIGIN_URL}/drug/store`;

    $.ajax({
        type: "POST",
        url: URL,
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        success: handleSuccessManual,
        error: handleError,
    });
});

function handleSuccessManual(response) {
    const drug = response.data;

    // Medicine dropdown select2
    const $medicineSelect = $("#kt_drug_id");

    // নতুন option append করব
    let text = `${drug.trade_name} (${drug.generic_name})`;
    let newOption = new Option(text, drug.drug_id, true, true);

    // select2 তে option add + select
    $medicineSelect.append(newOption).trigger('change');

    // Modal hide
    $("#showModal").modal('hide');

    // Loader off
    loader(selectedForm, false);

    // Success message
    toastr.success("Medicine added & selected successfully");
}

// Initialize CKEditor for doctor advice (if not already initialized)
if (typeof ClassicEditor !== 'undefined') {
    ClassicEditor
        .create(document.querySelector('#kt_doctor_advice'), {
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' },
                    { model: 'heading4', view: 'h4', title: 'Heading 4', class: 'ck-heading_heading4' },
                    { model: 'heading5', view: 'h5', title: 'Heading 5', class: 'ck-heading_heading5' },
                    { model: 'heading6', view: 'h6', title: 'Heading 6', class: 'ck-heading_heading6' },
                    { model: 'strong', view: 'strong', title: 'Strong', class: 'ck-heading_strong' },
                    { model: 'label', view: 'label', title: 'Label', class: 'ck-heading_label' },
                ]
            },
            fontFamily: {
                options: ['default', 'Arial', 'Times New Roman']
            },
        })
        .then(editor => {
            window.termsEditor = editor;
        })
        .catch(error => {
            console.error(error);
        });
}


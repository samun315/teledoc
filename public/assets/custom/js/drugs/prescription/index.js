// Get the current URL of the window
const BASE_URL = window.location.origin + "/drug/prescription";
const ORIGIN_URL = window.location.origin;

$(document).ready(function () {

    // Open patient modal
    $('#openPatientModal').on('click', function () {
        $('#patientModal').modal('show');
        getPatientList();
    });

    // Prevent form submission on Enter inside search box
    $('#searchPatient').on('keypress', function (e) {
        if (e.which === 13) e.preventDefault();
    });

    // Live search: filter by name or phone
    $('#searchPatient').on('keyup', function () {
        const term = $(this).val().toLowerCase().trim();

        $('#patientList .select-patient').each(function () {
            const name = $(this).find('.patient-name').text().toLowerCase();
            const phone = $(this).find('small').text().toLowerCase();

            if (term === '' || name.includes(term) || phone.includes(term)) {
                $(this).removeClass('d-none').addClass('d-flex');
            } else {
                $(this).removeClass('d-flex').addClass('d-none');
            }
        });

        // Check if any patient is visible after filtering
        if ($('#patientList .select-patient.d-flex').length === 0) {
            // If none visible, show "No patients found"
            if ($('#patientList .no-patient-message').length === 0) {
                $('#patientList').append('<p class="no-patient-message text-muted">No patients found.</p>');
            }
        } else {
            // Remove the message if patients are visible
            $('#patientList .no-patient-message').remove();
        }
    });


    // Patient selection behavior
    $(document).on('click', '.select-patient', function () {
        $('.select-patient').removeClass('active');
        $('.check-icon').addClass('d-none');
        $(this).addClass('active');
        $(this).find('.check-icon').removeClass('d-none');

        const patientId = $(this).data('patient-id'); // Corrected variable

        // const baseUrl = $('#createPrescription').data('route'); // Get the base URL from data attribute
        const prescriptionRoute = ORIGIN_URL + `/drug/prescription/create/${patientId}`;

        // Set the href dynamically
        $('#createPrescription').attr('href', prescriptionRoute);
    });


    // Reset everything on modal close
    $('#patientModal').on('hidden.bs.modal', function () {
        $('#searchPatient').val('');
        $('.select-patient').removeClass('active d-none').addClass('d-flex');
        $('.check-icon').addClass('d-none');

        // Remove the href from Create Prescription button
        $('#createPrescription').removeAttr('href');
    });

    // Placeholder: create prescription action
    $('#createPrescription').on('click', function () {
        const selectedPatient = $('.select-patient.active');
        if (selectedPatient.length === 0) {
            toastr.error('Please select a patient first!');
            return;
        }
    });

});

function getPatientList() {
    $.ajax({
        type: "GET",
        url: `${BASE_URL}/get-patient`,
        dataType: "json",
        success: (response) => {
            if (response?.success && response?.statusCode === 200) {
                const { patientInfo } = response;
                const $patientList = $('#patientList');
                $patientList.empty();

                if (Array.isArray(patientInfo) && patientInfo.length > 0) {
                    patientInfo.forEach(patient => {
                        const imagePath = patient.photo
                            ? `${ORIGIN_URL}/uploads/patient/${patient.photo}`
                            : `${ORIGIN_URL}/assets/media/avatars/blank.png`;

                        const patientItem = `
                            <div class="select-patient d-flex align-items-center justify-content-between border rounded p-2 mb-2 cursor-pointer" data-patient-id="${patient.patient_id}">
                                <div class="d-flex align-items-center patient-info">
                                    <img src="${imagePath}" class="rounded-circle me-2" width="40" height="40" alt="Patient Avatar">
                                    <div>
                                        <strong class="patient-name">${patient.name}</strong><br>
                                        <small>${patient.phone}</small>
                                    </div>
                                </div>
                                <div class="check-icon d-none text-primary">
                                    <i class="bi bi-check-circle-fill"></i>
                                </div>
                            </div>
                        `;
                        $patientList.append(patientItem);
                    });

                    // Reapply search if user already typed something
                    $('#searchPatient').trigger('keyup');
                } else {
                    $patientList.html('<p class="text-muted">No patients found.</p>');
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


let search = $("#search");

const formatDate = (data) => {
    if (!data) return "";

    const date = new Date(data);
    // Month and day as textual representations
    let monthNames = [
        "Jan",
        "Feb",
        "Mar",
        "Apr",
        "May",
        "Jun",
        "Jul",
        "Aug",
        "Sep",
        "Oct",
        "Nov",
        "Dec",
    ];

    let month = monthNames[date.getMonth()];
    let day = date.getDate().toString().padStart(2, "0");
    let hour = date.getHours().toString().padStart(2, "0");

    let amPm = hour >= 12 ? "PM" : "AM";
    hour = hour % 12 || 12; // Convert 0 to 12 for 12 AM

    let minute = date.getMinutes().toString().padStart(2, "0");
    let second = date.getSeconds().toString().padStart(2, "0");

    return `${day} ${month}, ${date.getFullYear()}`;
};

// fetch the data
let table = $("#kt_prescription_table").DataTable({
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
            data: "created_at",
            render: formatDate,
        },
        {
            data: "prescription_number",
            name: "prescription_number",
        },
        {
            data: "info",
            name: "info",
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


// DRUG DOSE FETCH 

$("#kt_drug_dose_id").empty();

$(document).on('change', '#kt_drug_type_id', function () {
    const drugTypeId = $(this).val() // Corrected variable

    getDrugDoseByDrugType(drugTypeId)

});

function getDrugDoseByDrugType(drugTypeId) {
    if (drugTypeId) {
        $.ajax({
            url: BASE_URL + "/get-drug-dose/" + drugTypeId,
            type: "GET",
            success: function (response) {
                let data = response?.doses;

                if (response?.success && response?.statusCode === 200 && data) {
                    $("#kt_drug_dose_id").empty();
                    $("#kt_drug_dose_id").append(
                        '<option value="">Dose</option>'
                    );

                    $.each(data, function (key, value) {
                        $("#kt_drug_dose_id").append(
                            '<option value="' +
                            value?.drug_dose_id +
                            '">' +
                            value?.drug_dose +
                            "</option>"
                        );
                    });
                }
            },
        });
    } else {
        $("#kt_drug_dose_id").empty();
        $("#kt_drug_dose_id").append(
            '<option value="">Dose</option>'
        );
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

    $('#kt_drug_type_id').val(card.find('input[name="drug_type_id[]"]').val()).trigger('change');
    $('#kt_drug_id').val(card.find('input[name="drug_id[]"]').val()).trigger('change');
    $('#kt_drug_strength_id').val(card.find('input[name="drug_strength_id[]"]').val()).trigger('change');
    $('#kt_drug_dose_id').val(card.find('input[name="drug_dose_id[]"]').val()).trigger('change');
    $('#kt_drug_duration_id').val(card.find('input[name="drug_duration_id[]"]').val()).trigger('change');
    $('#kt_drug_advice_id').val(card.find('input[name="drug_advice_id[]"]').val()).trigger('change');

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

    if (!drugTypeId || !drugId || !strengthId || !doseId || !durationId || !adviceId) {
        toastr.warning("Please fill in all fields before adding.");
        return null;
    }

    return { drugTypeText, medicineText, strengthText, doseText, durationText, adviceText, drugTypeId, drugId, strengthId, doseId, durationId, adviceId };
}

// Helper: Generate drug card HTML
function generateDrugCard(data, index) {
    return `
        <div class="card card-body border shadow-sm position-relative drug-item" data-drug-index="${index}">
            <div>
                <strong>Type:</strong> ${data.drugTypeText} |
                <strong>Medicine:</strong> ${data.medicineText} |
                <strong>Strength:</strong> ${data.strengthText} |
                <strong>Dose:</strong> ${data.doseText} |
                <strong>Duration:</strong> ${data.durationText} |
                <strong>Advice:</strong> ${data.adviceText}
            </div>
            <div class="position-absolute top-0 end-0 m-2">
                <button type="button" class="btn btn-sm btn-light-danger bg-transparent btn-icon remove-drug-btn"><i class="fas fa-times"></i></button>
                <button type="button" class="btn btn-sm btn-light-primary bg-transparent btn-icon edit-drug-btn"><i class="fas fa-edit"></i></button>
          </div>

            <!-- Hidden inputs -->
            <input type="hidden" name="drug_type_id[]" value="${data.drugTypeId}">
            <input type="hidden" name="drug_id[]" value="${data.drugId}">
            <input type="hidden" name="drug_strength_id[]" value="${data.strengthId}">
            <input type="hidden" name="drug_dose_id[]" value="${data.doseId}">
            <input type="hidden" name="drug_duration_id[]" value="${data.durationId}">
            <input type="hidden" name="drug_advice_id[]" value="${data.adviceId}">
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

// Initialize flatpickr with today's date
const datePicker = $("#kt_prescription_date").flatpickr({
    dateFormat: "Y-m-d",
    maxDate: "today",
});

// Make icon open date picker
$("#dateIcon").on("click", function () {
    datePicker.open();
});

// GET SELECTED DOCTOR'S PRESCRIPTION
// $('#kt_doctor_id').on('change', function () {
//     let doctorId = $(this).val();
//     let patientId = $("#kt_patient_id").val();

//     $.ajax({
//         url: BASE_URL + '/get-doctor-prescriptions/' + doctorId + '/' + patientId,
//         method: 'GET',
//         beforeSend: function () {
//             $('#drugListWrapper').html('<p class="text-info">Loading prescriptions...</p>');
//         },
//         success: function (response) {
//             const medications = response.prescription || [];

//             if (medications.length === 0) {
//                 $('#drugListWrapper').html('<p class="text-danger">No prescriptions found.</p>');
//                 return;
//             }

//             let grouped = {};
//             medications.forEach(med => {
//                 let pid = med.prescription_id;
//                 if (!grouped[pid]) {
//                     grouped[pid] = {
//                         prescription_id: pid,
//                         drugs: []
//                     };
//                 }
//                 grouped[pid].drugs.push(med);
//             });

//             let html = '';
//             Object.values(grouped).forEach((prescription) => {
//                 if (prescription.drugs.length === 0) {
//                     html += '<p>No drugs found.</p>';
//                 } else {
//                     prescription.drugs.forEach((drug, dIndex) => {
//                         const drugData = {
//                             drugTypeText: drug.drug_type ?? 'N/A',
//                             medicineText: drug.trade_name ?? 'N/A',
//                             strengthText: drug.drug_strength ?? 'N/A',
//                             doseText: drug.drug_dose ?? 'N/A',
//                             durationText: drug.drug_duration ?? 'N/A',
//                             adviceText: drug.drug_advice ?? 'N/A',

//                             drugTypeId: drug.drug_type_id ?? '',
//                             drugId: drug.drug_id ?? '',
//                             strengthId: drug.drug_strength_id ?? '',
//                             doseId: drug.drug_dose_id ?? '',
//                             durationId: drug.drug_duration_id ?? '',
//                             adviceId: drug.drug_advice_id ?? '',
//                         };
//                         html += generateDrugCard(drugData, dIndex);
//                     });
//                 }
//             });

//             $('#drugListWrapper').html(html);
//         },

//         error: function () {
//             $('#drugListWrapper').html('<p class="text-danger">Error loading prescriptions.</p>');
//         }
//     });
// });

// GET OLD PRESCRIPTION LIST
$('#kt_prescription_id').on('change', function () {
    let prescriptionId = $(this).val();

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
                            drugTypeText: drug.drug_type ?? 'N/A',
                            medicineText: drug.trade_name ?? 'N/A',
                            strengthText: drug.drug_strength ?? 'N/A',
                            doseText: drug.drug_dose ?? 'N/A',
                            durationText: drug.drug_duration ?? 'N/A',
                            adviceText: drug.drug_advice ?? 'N/A',

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
});

// form submit validation
$('#prescriptionForm').on('submit', function (e) {
    toastr.clear();


    if ($('#drugListWrapper .drug-item').length === 0) {
        e.preventDefault();
        toastr.error('Please add at least one drug in prescription before submitting.');
        return false;
    }

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


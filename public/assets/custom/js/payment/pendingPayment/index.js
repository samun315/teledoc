const BASE_URL = window.location.origin + "/payment/pending-payments";
const ORDER_DETAILS_BASE_URL = window.location.origin + "/order/get-order-details";
const PROCESS_PAYMENT_URL = window.location.origin + "/order/process-payment";

let search = $("#search");

// Initialize DataTable
let table = $("#kt_table_pending_payments").DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: BASE_URL + "/",
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
            data: "order_no",
            name: "order_no",
        },
        {
            data: "customer_name",
            name: "customer_name",
        },
        {
            data: "doctor_name",
            name: "doctor_name",
        },
        {
            data: "amount",
            name: "amount",
        },
        {
            data: "status",
            name: "status",
            orderable: false,
        },
        {
            data: "created_at",
            name: "created_at",
        },
        {
            data: "action",
            name: "action",
            orderable: false,
            searchable: false,
        },
    ],
    columnDefs: [
        {
            targets: "_all",
            defaultContent: "",
        },
    ],
    paging: true,
    pageLength: 10,
    lengthMenu: [10, 25, 50, 75, 100, 200],
    dom:
        '<"row"<"col-sm-2"l><"col-sm-10 d-flex justify-content-end"B>>' +
        '<"row"<"col-sm-12"tr>>' +
        '<"row mt-2"<"col-sm-6"i><"col-sm-6 d-flex justify-content-end"p>>',
    buttons: [
        {
            extend: "excelHtml5",
            text: "Excel",
            className: "btn btn-success btn-sm",
            attr: {
                style: "margin-top: 25px;padding: 0 10px; font-size: 12px; line-height: 1; height: 30px;",
            },
            exportOptions: {
                columns: ":not(:first-child):not(:last-child)",
            },
        },
        {
            extend: "pdfHtml5",
            text: "PDF",
            className: "btn btn-danger btn-sm",
            attr: {
                style: "margin-top: 25px;padding: 0 10px; font-size: 12px; line-height: 1; height: 30px;",
            },
            exportOptions: {
                columns: ":not(:first-child):not(:last-child)",
            },
        },
    ],
});

// Trigger table redraw on search
search.keyup(function () {
    table.draw();
});

// Handle Make Payment button click
$(document).on("click", ".make-payment-btn", function () {
    let orderId = $(this).attr("data-order-id");
    let paymentId = $(this).attr("data-payment-id");
    
    if (!orderId) {
        toastr.error("Order ID is missing.");
        return;
    }

    // Reset form
    $("#kt_payment_form")[0].reset();
    $("#payment_order_id").val(orderId);
    $("#payment_payment_id").val(paymentId);
    $("#payment_discount").val(0);
    
    // Show loading state
    $("#kt_payment_submit").attr("data-kt-indicator", "on");
    
    // Fetch order details
    $.ajax({
        url: ORDER_DETAILS_BASE_URL + "/" + orderId,
        type: "GET",
        success: function (response) {
            $("#kt_payment_submit").removeAttr("data-kt-indicator");
            
            if (response?.success && response?.data) {
                let orderData = response.data;
                
                $("#payment_order_no").val(orderData.order_no || "");
                $("#payment_amount").val(orderData.total_amount || orderData.subtotal || 0);
                $("#payment_discount").val(orderData.discount || 0);
                
                // Calculate final amount
                calculateFinalAmount();
                
                // Show modal
                $("#kt_payment_modal").modal("show");
            } else {
                toastr.error(response?.message || "Failed to fetch order details.");
            }
        },
        error: function (xhr) {
            $("#kt_payment_submit").removeAttr("data-kt-indicator");
            let errorMessage = "Failed to fetch order details.";
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            toastr.error(errorMessage);
        },
    });
});

// Calculate final amount when discount changes
$(document).on("input", "#payment_discount", function () {
    calculateFinalAmount();
});

function calculateFinalAmount() {
    let amount = parseFloat($("#payment_amount").val()) || 0;
    let discount = parseFloat($("#payment_discount").val()) || 0;
    
    if (discount > amount) {
        toastr.warning("Discount cannot exceed the amount.");
        $("#payment_discount").val(amount);
        discount = amount;
    }
    
    let finalAmount = amount - discount;
    $("#payment_final_amount").val(finalAmount.toFixed(2));
}

// Handle payment form submission
$("#kt_payment_form").on("submit", function (e) {
    e.preventDefault();
    
    let orderId = $("#payment_order_id").val();
    let paymentMethod = $("#payment_method").val();
    let amount = parseFloat($("#payment_amount").val()) || 0;
    let discount = parseFloat($("#payment_discount").val()) || 0;
    let finalAmount = parseFloat($("#payment_final_amount").val()) || 0;
    let transactionId = $("#payment_transaction_id").val();
    
    // Validation
    if (!paymentMethod) {
        toastr.error("Please select a payment method.");
        return;
    }
    
    if (discount > amount) {
        toastr.error("Discount cannot exceed the amount.");
        return;
    }
    
    // Show loading state
    $("#kt_payment_submit").attr("data-kt-indicator", "on");
    
    // Setup CSRF token
    setCSRFToken();
    
    // Submit payment
    $.ajax({
        url: PROCESS_PAYMENT_URL,
        type: "POST",
        data: {
            order_id: orderId,
            payment_method: paymentMethod,
            amount: amount,
            discount: discount,
            final_amount: finalAmount,
            transaction_id: transactionId,
        },
        success: function (response) {
            $("#kt_payment_submit").removeAttr("data-kt-indicator");
            
            if (response?.success) {
                toastr.success(response?.message || "Payment processed successfully!");
                $("#kt_payment_modal").modal("hide");
                table.draw();
            } else {
                toastr.error(response?.message || "Failed to process payment.");
            }
        },
        error: function (xhr) {
            $("#kt_payment_submit").removeAttr("data-kt-indicator");
            let errorMessage = "Failed to process payment.";
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            toastr.error(errorMessage);
        },
    });
});

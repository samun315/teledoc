<!--begin::Make Payment Modal-->
<div class="modal fade" id="kt_payment_modal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">Make Payment</h2>
                <button type="button" class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <form id="kt_payment_form">
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <input type="hidden" id="payment_order_id" name="order_id">
                    <input type="hidden" id="payment_payment_id" name="payment_id">
                    
                    <div class="mb-7">
                        <label class="form-label fw-semibold">Order No</label>
                        <input type="text" class="form-control form-control-solid" id="payment_order_no" readonly>
                    </div>

                    <div class="mb-7">
                        <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                        <select class="form-select form-select-solid" id="payment_method" name="payment_method" required>
                            <option value="">Select Payment Method</option>
                            <option value="BKASH">bKash</option>
                            <option value="NAGAD">Nagad</option>
                            <option value="ROCKET">Rocket</option>
                            <option value="CARD">Card</option>
                            <option value="CASH">Cash</option>
                        </select>
                    </div>

                    <div class="mb-7">
                        <label class="form-label fw-semibold">Amount (BDT)</label>
                        <input type="text" class="form-control form-control-solid" id="payment_amount" name="amount" readonly>
                    </div>

                    <div class="mb-7">
                        <label class="form-label fw-semibold">Discount (BDT)</label>
                        <input type="number" class="form-control form-control-solid" id="payment_discount" name="discount" value="0" min="0" step="0.01">
                    </div>

                    <div class="mb-7">
                        <label class="form-label fw-semibold">Final Amount (BDT)</label>
                        <input type="text" class="form-control form-control-solid fw-bold text-primary" id="payment_final_amount" readonly>
                    </div>

                    <div class="mb-7">
                        <label class="form-label fw-semibold">Transaction ID (Optional)</label>
                        <input type="text" class="form-control form-control-solid" id="payment_transaction_id" name="transaction_id" placeholder="Enter transaction ID">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="kt_payment_submit">
                        <span class="indicator-label">Process Payment</span>
                        <span class="indicator-progress">Please wait...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Make Payment Modal-->

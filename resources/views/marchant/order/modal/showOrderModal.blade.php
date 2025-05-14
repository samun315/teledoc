<div class="modal fade" tabindex="-1" id="showModal" data-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Show Order Balance Details</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2 formReset" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="fas fa-times"></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                <div class="col-md-12">
                    <table class="table border border-2 table-row-dashed table-row-gray-300">
                        <tr class="highlight text-white">
                            <th class="ps-2">FIELD</th>
                            <th>INFORMATION</th>
                        </tr>
                        <tr>
                            <td class="ps-2">Amount</td>
                            <td>TK <span class="bd_amount"></span> <span class="kt_currency"></span></td>
                        </tr>
                        <tr>
                            <td class="ps-2">Gateway</td>
                            <td class="gateway_name_column"></td>
                        </tr>
                        <tr>
                            <td class="ps-2">Currency</td>
                            <td>
                                Rate : 💎 1 IMO Diamond = <span class="rate-box"></span> <span
                                    class="kt_currency"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-2">Amount <span class="kt_currency"></span> to IMO Diamond</td>
                            <td>
                                Amount <span class="kt_currency">BDT</span> <span class="bd_amount"></span>
                                TK = 💎 <span class="diamond_amount"></span> IMO Diamond
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-2">Status</td>
                            <td class="kt_status">
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-2">Date Time</td>
                            <td class="kt_date_time">
                            </td>
                        </tr>
                        <tr class="highlight text-white">
                            <th class="ps-2" colspan="2">Uploaded Attachment</th>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <img id="uploaded_photo" src="" alt="Image Preview">
                            </td>
                        </tr>
                    </table>
                </div>
                <!--end::VIEW DATA-->
            </div>
        </div>
    </div>
</div>

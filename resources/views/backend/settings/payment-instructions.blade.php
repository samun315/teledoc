@extends('master')

@section('title', 'Payment Instructions Page')

@section('page_css')
    <link rel="stylesheet" href="{{ asset('assets/plugins/custom/summernote/summernote-bs4.css') }}">
@endsection

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card mb-5">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <h1 class="mb-0">Payment Instructions Page</h1>
                </div>
                <p class="text-muted mb-0 mt-2 small">
                    Manage the public <a href="{{ url('/payment-instructions') }}" target="_blank" rel="noopener">/payment-instructions</a> page (hero, payment modes accordion, terms accordion, and quick summary).
                </p>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#pi-tab-payment-instructions" role="tab" data-pi-tab="payment-instructions">
                            <i class="icofont-info-circle"></i> Payment instructions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pi-tab-payment-modes" role="tab" data-pi-tab="payment-modes">
                            <i class="icofont-wallet"></i> Payment modes
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pi-tab-terms-conditions" role="tab" data-pi-tab="terms-conditions">
                            <i class="icofont-file-text"></i> Terms &amp; Conditions
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#pi-tab-quick-summary" role="tab" data-pi-tab="quick-summary">
                            <i class="icofont-list"></i> Quick Summary
                        </a>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="pi-tab-payment-instructions" role="tabpanel">
                        <p class="text-muted small mb-4">
                            This tab matches the former <a href="{{ route('admin.settings.payment-instruction-hero.index') }}">admin/settings/payment-instruction-hero</a> screen (hero banner, title, and description).
                        </p>
                        @include('backend.settings.partials.payment-instructions-hero-tab')
                    </div>

                    <div class="tab-pane fade" id="pi-tab-payment-modes" role="tabpanel">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                            <p class="text-muted small mb-0">
                                Manage payment methods shown in the public page accordion. If the list is empty, the legacy default layout is used.
                            </p>
                            <button type="button" class="btn btn-sm btn-primary" id="btnPaymentModeAdd">
                                <i class="icofont-plus"></i> Add new
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-row-bordered table-hover align-middle gy-3 text-center">
                                <thead>
                                    <tr class="fw-semibold text-muted">
                                        <th class="w-50px text-center">#</th>
                                        <th class="w-80px text-center">Image</th>
                                        <th class="text-center">Title</th>
                                        <th class="w-80px text-center">Sort</th>
                                        <th class="w-90px text-center">Active</th>
                                        <th class="w-120px text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentModesTableBody">
                                    @foreach($paymentModes as $mode)
                                        <tr data-mode-id="{{ $mode->id }}">
                                            <td class="text-center">{{ $mode->id }}</td>
                                            <td class="text-center">
                                                @if($mode->image)
                                                    <img src="{{ asset('storage/'.$mode->image) }}" alt="" class="rounded" style="width:48px;height:48px;object-fit:cover;">
                                                @else
                                                    <span class="text-muted small">—</span>
                                                @endif
                                            </td>
                                            <td class="text-center">{{ $mode->title }}</td>
                                            <td class="text-center">{{ $mode->sort_order }}</td>
                                            <td class="text-center">
                                                @if($mode->is_active)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center align-items-center flex-wrap">
                                                    <button type="button" class="btn btn-sm btn-light-primary btn-payment-mode-edit" data-id="{{ $mode->id }}" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light-danger btn-payment-mode-delete delete-btn" data-id="{{ $mode->id }}" data-title="{{ e($mode->title) }}" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($paymentModes->isEmpty())
                            <p class="text-muted small mb-0" id="paymentModesEmptyHint">No payment modes yet. Click <strong>Add new</strong> to create one.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="pi-tab-terms-conditions" role="tabpanel">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                            <p class="text-muted small mb-0">
                                Manage accordion items for <strong>Payment Terms &amp; Conditions</strong> (title, description, icon). The page intro and Quick Summary are unchanged. If the list is empty, the legacy default terms block is shown.
                            </p>
                            <button type="button" class="btn btn-sm btn-primary" id="btnPaymentTermAdd">
                                <i class="icofont-plus"></i> Add new
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-row-bordered table-hover align-middle gy-3 text-center">
                                <thead>
                                    <tr class="fw-semibold text-muted">
                                        <th class="w-50px text-center">#</th>
                                        <th class="w-80px text-center">Icon</th>
                                        <th class="text-center">Title</th>
                                        <th class="w-90px text-center">Color</th>
                                        <th class="w-80px text-center">Sort</th>
                                        <th class="w-90px text-center">Active</th>
                                        <th class="w-120px text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="paymentTermItemsTableBody">
                                    @foreach($paymentTermItems as $termItem)
                                        <tr data-term-id="{{ $termItem->id }}">
                                            <td class="text-center">{{ $termItem->id }}</td>
                                            <td class="text-center">
                                                <span class="pt-icon pt-icon-{{ $termItem->icon_color }} d-inline-flex align-items-center justify-content-center" style="width:40px;height:40px;border-radius:10px;">
                                                    <i class="{{ $termItem->icon }}"></i>
                                                </span>
                                            </td>
                                            <td class="text-center">{{ $termItem->title }}</td>
                                            <td class="text-center text-capitalize">{{ $termItem->icon_color }}</td>
                                            <td class="text-center">{{ $termItem->sort_order }}</td>
                                            <td class="text-center">
                                                @if($termItem->is_active)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center align-items-center flex-wrap">
                                                    <button type="button" class="btn btn-sm btn-light-primary btn-payment-term-edit" data-id="{{ $termItem->id }}" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light-danger btn-payment-term-delete delete-btn" data-id="{{ $termItem->id }}" data-title="{{ e($termItem->title) }}" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($paymentTermItems->isEmpty())
                            <p class="text-muted small mb-0" id="paymentTermItemsEmptyHint">No term items yet. Click <strong>Add new</strong> to create one.</p>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="pi-tab-quick-summary" role="tabpanel">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-4">
                            <p class="text-muted small mb-0">
                                Manage the numbered <strong>Quick Summary</strong> list (below Terms &amp; Conditions on the public page). If empty, the default list is shown.
                            </p>
                            <button type="button" class="btn btn-sm btn-primary" id="btnQuickSummaryAdd">
                                <i class="icofont-plus"></i> Add new
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-row-bordered table-hover align-middle gy-3 text-center">
                                <thead>
                                    <tr class="fw-semibold text-muted">
                                        <th class="w-50px text-center">#</th>
                                        <th class="w-90px text-center">Badge</th>
                                        <th class="text-center">Line text</th>
                                        <th class="w-80px text-center">Sort</th>
                                        <th class="w-90px text-center">Active</th>
                                        <th class="w-120px text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="quickSummaryTableBody">
                                    @foreach($paymentQuickSummaryItems as $row)
                                        <tr data-qs-id="{{ $row->id }}">
                                            <td class="text-center">{{ $row->id }}</td>
                                            <td class="text-center">
                                                <span class="pt-num pt-num-{{ $row->badge_variant }} d-inline-flex align-items-center justify-content-center" style="width:32px;height:32px;font-size:0.8rem;">{{ $row->badge_variant }}</span>
                                            </td>
                                            <td class="text-start">{{ $row->line_text }}</td>
                                            <td class="text-center">{{ $row->sort_order }}</td>
                                            <td class="text-center">
                                                @if($row->is_active)
                                                    <span class="badge bg-success">Yes</span>
                                                @else
                                                    <span class="badge bg-secondary">No</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex gap-2 justify-content-center align-items-center flex-wrap">
                                                    <button type="button" class="btn btn-sm btn-light-primary btn-quick-summary-edit" data-id="{{ $row->id }}" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-light-danger btn-quick-summary-delete delete-btn" data-id="{{ $row->id }}" data-title="{{ e(Str::limit($row->line_text, 80)) }}" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @if($paymentQuickSummaryItems->isEmpty())
                            <p class="text-muted small mb-0" id="quickSummaryEmptyHint">No lines yet. Click <strong>Add new</strong> to create one.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentModeModal" tabindex="-1" aria-labelledby="paymentModeModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentModeModalTitle">Add payment mode</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="pm_edit_id" value="">

                    <div class="mb-4">
                        <label class="form-label required" for="pm_title">Title</label>
                        <input type="text" class="form-control" id="pm_title" maxlength="255" required placeholder="e.g. bKash">
                    </div>

                    <div class="mb-4">
                        <label class="form-label" for="pm_image">Image</label>
                        <input type="file" class="form-control" id="pm_image" name="image" accept="image/*">
                        <div class="form-text">Optional. Shown in the left column on the public page. Max 2MB.</div>
                        <div id="pm_image_current_wrap" class="mt-2" style="display:none;">
                            <span class="form-label d-block small">Current image</span>
                            <img id="pm_image_current" src="" alt="" class="img-fluid rounded border" style="max-height:100px;">
                            <div class="form-check mt-2">
                                <input class="form-check-input" type="checkbox" id="pm_remove_image" value="1">
                                <label class="form-check-label" for="pm_remove_image">Remove current image</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label required" for="pm_account_details">Account details</label>
                        <textarea id="pm_account_details" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="mb-4">
                        <label class="form-label required" for="pm_instruction">Instruction</label>
                        <textarea id="pm_instruction" class="form-control" rows="4"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="pm_sort_order">Sort order</label>
                            <input type="number" class="form-control" id="pm_sort_order" min="0" max="65535" value="0">
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pm_is_active" checked>
                                <label class="form-check-label" for="pm_is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="pm_save_btn">
                        <i class="icofont-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="paymentTermItemModal" tabindex="-1" aria-labelledby="paymentTermItemModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentTermItemModalTitle">Add term item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="pt_edit_id" value="">

                    <div class="mb-4">
                        <label class="form-label required" for="pt_title">Title</label>
                        <input type="text" class="form-control" id="pt_title" maxlength="255" required placeholder="Accordion heading">
                    </div>

                    <div class="row">
                        <div class="col-md-7 mb-4">
                            <label class="form-label required" for="pt_icon">Icon class</label>
                            <input type="text" class="form-control" id="pt_icon" maxlength="120" required placeholder="icofont-clock-time">
                            <div class="form-text">IcoFont class name (e.g. <code>icofont-shield</code>).</div>
                        </div>
                        <div class="col-md-5 mb-4">
                            <label class="form-label required" for="pt_icon_color">Icon color</label>
                            <select class="form-select" id="pt_icon_color" required>
                                <option value="blue">Blue</option>
                                <option value="green">Green</option>
                                <option value="orange">Orange</option>
                                <option value="red">Red</option>
                                <option value="purple">Purple</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label required" for="pt_description">Description</label>
                        <textarea id="pt_description" class="form-control" rows="6"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="pt_sort_order">Sort order</label>
                            <input type="number" class="form-control" id="pt_sort_order" min="0" max="65535" value="0">
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pt_is_active" checked>
                                <label class="form-check-label" for="pt_is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="pt_save_btn">
                        <i class="icofont-save"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="quickSummaryItemModal" tabindex="-1" aria-labelledby="quickSummaryItemModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="quickSummaryItemModalTitle">Add quick summary line</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="pqs_edit_id" value="">
                    <div class="mb-3">
                        <label class="form-label required" for="pqs_line_text">Line text</label>
                        <textarea class="form-control" id="pqs_line_text" rows="3" maxlength="500" required placeholder="Summary bullet text"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required" for="pqs_badge_variant">Badge color (1–5)</label>
                        <select class="form-select" id="pqs_badge_variant" required>
                            <option value="1">1 — Blue</option>
                            <option value="2">2 — Green</option>
                            <option value="3">3 — Orange</option>
                            <option value="4">4 — Red</option>
                            <option value="5">5 — Purple</option>
                        </select>
                        <div class="form-text">Circle color on the public page. Row numbers 1,2,3… follow list order.</div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="pqs_sort_order">Sort order</label>
                            <input type="number" class="form-control" id="pqs_sort_order" min="0" max="65535" value="0">
                        </div>
                        <div class="col-md-6 mb-3 d-flex align-items-end">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="pqs_is_active" checked>
                                <label class="form-check-label" for="pqs_is_active">Active</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="pqs_save_btn"><i class="icofont-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('page_script')
<script src="{{ asset('assets/plugins/custom/summernote/summernote-bs4.js') }}"></script>
<script nonce="{{ $cspNonce ?? '' }}">
$(function () {
    var tabMap = {
        'payment-instructions': 'a[data-bs-toggle="tab"][href="#pi-tab-payment-instructions"]',
        'payment-modes': 'a[data-bs-toggle="tab"][href="#pi-tab-payment-modes"]',
        'terms-conditions': 'a[data-bs-toggle="tab"][href="#pi-tab-terms-conditions"]',
        'quick-summary': 'a[data-bs-toggle="tab"][href="#pi-tab-quick-summary"]'
    };
    var storageKey = 'paymentInstructionsSettingsActiveTab';
    var q = new URLSearchParams(window.location.search).get('tab');
    if (q && tabMap[q]) {
        $(tabMap[q]).tab('show');
    } else {
        var saved = localStorage.getItem(storageKey);
        if (saved && $(saved).length) {
            $('a[data-bs-toggle="tab"][href="' + saved + '"]').tab('show');
        }
    }
    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        localStorage.setItem(storageKey, $(e.target).attr('href'));
    });

    function getCurrentPiTabKey() {
        var k = $('a[data-bs-toggle="tab"].nav-link.active').attr('data-pi-tab');
        if (k && tabMap[k]) return k;
        return 'payment-instructions';
    }
    function reloadStayOnTab() {
        window.location.href = window.location.pathname + '?tab=' + encodeURIComponent(getCurrentPiTabKey());
    }

    $('#description').summernote({
        height: 280,
        callbacks: {
            onImageUpload: function (files) { sendFileToSummernote(files[0], '#description'); }
        }
    });

    $('#banner_image').on('change', function (e) {
        var file = e.target.files && e.target.files[0];
        if (!file) {
            $('#bannerPreviewWrap').hide();
            return;
        }
        var reader = new FileReader();
        reader.onload = function (ev) {
            $('#bannerPreviewImg').attr('src', ev.target.result);
            $('#bannerPreviewWrap').show();
        };
        reader.readAsDataURL(file);
    });

    $('#paymentInstructionHeroForm').on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.set('description', $('#description').summernote('code'));
        $.ajax({
            url: "{{ route('admin.settings.payment-instruction-hero.update') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2000, showConfirmButton: false });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message });
                }
            },
            error: function (xhr) {
                var msg = (xhr.responseJSON && xhr.responseJSON.message) ? xhr.responseJSON.message : 'Request failed';
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            }
        });
    });

    var pmBaseUrl = "{{ url('/admin/settings/payment-modes') }}";
    var pmStoreUrl = "{{ route('admin.settings.payment-modes.store') }}";
    var pmPending = null;

    function destroyPmEditors() {
        if ($('#pm_account_details').length && $('#pm_account_details').next('.note-editor').length) {
            try { $('#pm_account_details').summernote('destroy'); } catch (e) {}
        }
        if ($('#pm_instruction').length && $('#pm_instruction').next('.note-editor').length) {
            try { $('#pm_instruction').summernote('destroy'); } catch (e) {}
        }
    }

    function initPmEditors() {
        $('#pm_account_details').summernote({
            height: 220,
            callbacks: {
                onImageUpload: function (files) { sendFileToSummernote(files[0], '#pm_account_details'); }
            }
        });
        $('#pm_instruction').summernote({
            height: 220,
            callbacks: {
                onImageUpload: function (files) { sendFileToSummernote(files[0], '#pm_instruction'); }
            }
        });
    }

    $('#paymentModeModal').on('hidden.bs.modal', function () {
        destroyPmEditors();
    });

    $('#paymentModeModal').on('shown.bs.modal', function () {
        initPmEditors();
        if (pmPending) {
            $('#pm_account_details').summernote('code', pmPending.account_details || '<p><br></p>');
            $('#pm_instruction').summernote('code', pmPending.instruction || '<p><br></p>');
            pmPending = null;
        }
    });

    $('#btnPaymentModeAdd').on('click', function () {
        $('#paymentModeModalTitle').text('Add payment mode');
        $('#pm_edit_id').val('');
        $('#pm_title').val('');
        $('#pm_image').val('');
        $('#pm_sort_order').val(0);
        $('#pm_is_active').prop('checked', true);
        $('#pm_remove_image').prop('checked', false);
        $('#pm_image_current_wrap').hide();
        pmPending = { account_details: '<p><br></p>', instruction: '<p><br></p>' };
        $('#paymentModeModal').modal('show');
    });

    $(document).on('click', '.btn-payment-mode-edit', function () {
        var id = $(this).data('id');
        $.get(pmBaseUrl + '/' + id, function (res) {
            if (!res.payment_mode) return;
            var m = res.payment_mode;
            $('#pm_edit_id').val(m.id);
            $('#pm_title').val(m.title);
            $('#pm_sort_order').val(m.sort_order);
            $('#pm_is_active').prop('checked', !!m.is_active);
            $('#pm_remove_image').prop('checked', false);
            $('#pm_image').val('');
            if (m.image_url) {
                $('#pm_image_current').attr('src', m.image_url);
                $('#pm_image_current_wrap').show();
            } else {
                $('#pm_image_current_wrap').hide();
            }
            pmPending = { account_details: m.account_details, instruction: m.instruction };
            $('#paymentModeModalTitle').text('Edit payment mode');
            $('#paymentModeModal').modal('show');
        });
    });

    $('#pm_save_btn').on('click', function () {
        var id = $('#pm_edit_id').val();
        var fd = new FormData();
        fd.append('_token', '{{ csrf_token() }}');
        fd.append('title', $('#pm_title').val() || '');
        fd.append('account_details', $('#pm_account_details').summernote('code'));
        fd.append('instruction', $('#pm_instruction').summernote('code'));
        fd.append('sort_order', $('#pm_sort_order').val() || '0');
        fd.append('is_active', $('#pm_is_active').is(':checked') ? '1' : '0');
        var imgFile = document.getElementById('pm_image').files[0];
        if (imgFile) {
            fd.append('image', imgFile);
        }
        var url = pmStoreUrl;
        if (id) {
            url = pmBaseUrl + '/' + id + '/update';
            if ($('#pm_remove_image').is(':checked')) {
                fd.append('remove_image', '1');
            }
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    $('#paymentModeModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Saved', text: response.message, timer: 1600, showConfirmButton: false }).then(function () { reloadStayOnTab(); });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Failed' });
                }
            },
            error: function (xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Request failed';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = JSON.stringify(xhr.responseJSON.errors);
                }
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            }
        });
    });

    $(document).on('click', '.btn-payment-mode-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this payment mode?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (!result.isConfirmed) return;
            $.ajax({
                url: pmBaseUrl + '/' + id,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({ icon: 'success', title: 'Deleted', timer: 1400, showConfirmButton: false }).then(function () { reloadStayOnTab(); });
                    }
                },
                error: function (xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: (xhr.responseJSON && xhr.responseJSON.message) || 'Failed' });
                }
            });
        });
    });

    var ptBaseUrl = "{{ url('/admin/settings/payment-term-items') }}";
    var ptStoreUrl = "{{ route('admin.settings.payment-term-items.store') }}";
    var ptPending = null;

    function destroyPtEditor() {
        if ($('#pt_description').length && $('#pt_description').next('.note-editor').length) {
            try { $('#pt_description').summernote('destroy'); } catch (e) {}
        }
    }

    function initPtEditor() {
        $('#pt_description').summernote({
            height: 280,
            callbacks: {
                onImageUpload: function (files) { sendFileToSummernote(files[0], '#pt_description'); }
            }
        });
    }

    $('#paymentTermItemModal').on('hidden.bs.modal', function () {
        destroyPtEditor();
    });

    $('#paymentTermItemModal').on('shown.bs.modal', function () {
        initPtEditor();
        if (ptPending) {
            $('#pt_description').summernote('code', ptPending.description || '<p><br></p>');
            ptPending = null;
        }
    });

    $('#btnPaymentTermAdd').on('click', function () {
        $('#paymentTermItemModalTitle').text('Add term item');
        $('#pt_edit_id').val('');
        $('#pt_title').val('');
        $('#pt_icon').val('icofont-clock-time');
        $('#pt_icon_color').val('blue');
        $('#pt_sort_order').val(0);
        $('#pt_is_active').prop('checked', true);
        ptPending = { description: '<p><br></p>' };
        $('#paymentTermItemModal').modal('show');
    });

    $(document).on('click', '.btn-payment-term-edit', function () {
        var id = $(this).data('id');
        $.get(ptBaseUrl + '/' + id, function (res) {
            if (!res.payment_term_item) return;
            var m = res.payment_term_item;
            $('#pt_edit_id').val(m.id);
            $('#pt_title').val(m.title);
            $('#pt_icon').val(m.icon);
            $('#pt_icon_color').val(m.icon_color);
            $('#pt_sort_order').val(m.sort_order);
            $('#pt_is_active').prop('checked', !!m.is_active);
            ptPending = { description: m.description };
            $('#paymentTermItemModalTitle').text('Edit term item');
            $('#paymentTermItemModal').modal('show');
        });
    });

    $('#pt_save_btn').on('click', function () {
        var id = $('#pt_edit_id').val();
        var fd = new FormData();
        fd.append('_token', '{{ csrf_token() }}');
        fd.append('title', $('#pt_title').val() || '');
        fd.append('icon', ($('#pt_icon').val() || '').trim());
        fd.append('icon_color', $('#pt_icon_color').val() || 'blue');
        fd.append('description', $('#pt_description').summernote('code'));
        fd.append('sort_order', $('#pt_sort_order').val() || '0');
        fd.append('is_active', $('#pt_is_active').is(':checked') ? '1' : '0');
        var url = ptStoreUrl;
        if (id) {
            url = ptBaseUrl + '/' + id + '/update';
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    $('#paymentTermItemModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Saved', text: response.message, timer: 1600, showConfirmButton: false }).then(function () { reloadStayOnTab(); });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Failed' });
                }
            },
            error: function (xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Request failed';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = JSON.stringify(xhr.responseJSON.errors);
                }
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            }
        });
    });

    $(document).on('click', '.btn-payment-term-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this term item?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (!result.isConfirmed) return;
            $.ajax({
                url: ptBaseUrl + '/' + id,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({ icon: 'success', title: 'Deleted', timer: 1400, showConfirmButton: false }).then(function () { reloadStayOnTab(); });
                    }
                },
                error: function (xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: (xhr.responseJSON && xhr.responseJSON.message) || 'Failed' });
                }
            });
        });
    });

    var pqsBaseUrl = "{{ url('/admin/settings/payment-quick-summary-items') }}";
    var pqsStoreUrl = "{{ route('admin.settings.payment-quick-summary-items.store') }}";

    $('#btnQuickSummaryAdd').on('click', function () {
        $('#quickSummaryItemModalTitle').text('Add quick summary line');
        $('#pqs_edit_id').val('');
        $('#pqs_line_text').val('');
        $('#pqs_badge_variant').val('1');
        $('#pqs_sort_order').val(0);
        $('#pqs_is_active').prop('checked', true);
        $('#quickSummaryItemModal').modal('show');
    });

    $(document).on('click', '.btn-quick-summary-edit', function () {
        var id = $(this).data('id');
        $.get(pqsBaseUrl + '/' + id, function (res) {
            if (!res.payment_quick_summary_item) return;
            var m = res.payment_quick_summary_item;
            $('#pqs_edit_id').val(m.id);
            $('#pqs_line_text').val(m.line_text);
            $('#pqs_badge_variant').val(String(m.badge_variant));
            $('#pqs_sort_order').val(m.sort_order);
            $('#pqs_is_active').prop('checked', !!m.is_active);
            $('#quickSummaryItemModalTitle').text('Edit quick summary line');
            $('#quickSummaryItemModal').modal('show');
        });
    });

    $('#pqs_save_btn').on('click', function () {
        var id = $('#pqs_edit_id').val();
        var fd = new FormData();
        fd.append('_token', '{{ csrf_token() }}');
        fd.append('line_text', $('#pqs_line_text').val() || '');
        fd.append('badge_variant', $('#pqs_badge_variant').val() || '1');
        fd.append('sort_order', $('#pqs_sort_order').val() || '0');
        fd.append('is_active', $('#pqs_is_active').is(':checked') ? '1' : '0');
        var url = pqsStoreUrl;
        if (id) {
            url = pqsBaseUrl + '/' + id + '/update';
        }
        $.ajax({
            url: url,
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
                if (response.success) {
                    $('#quickSummaryItemModal').modal('hide');
                    Swal.fire({ icon: 'success', title: 'Saved', text: response.message, timer: 1600, showConfirmButton: false }).then(function () { reloadStayOnTab(); });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: response.message || 'Failed' });
                }
            },
            error: function (xhr) {
                var msg = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'Request failed';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    msg = JSON.stringify(xhr.responseJSON.errors);
                }
                Swal.fire({ icon: 'error', title: 'Error', text: msg });
            }
        });
    });

    $(document).on('click', '.btn-quick-summary-delete', function () {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Delete this line?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then(function (result) {
            if (!result.isConfirmed) return;
            $.ajax({
                url: pqsBaseUrl + '/' + id,
                type: 'POST',
                data: { _token: '{{ csrf_token() }}', _method: 'DELETE' },
                success: function (response) {
                    if (response.success) {
                        Swal.fire({ icon: 'success', title: 'Deleted', timer: 1400, showConfirmButton: false }).then(function () { reloadStayOnTab(); });
                    }
                },
                error: function (xhr) {
                    Swal.fire({ icon: 'error', title: 'Error', text: (xhr.responseJSON && xhr.responseJSON.message) || 'Failed' });
                }
            });
        });
    });

    function sendFileToSummernote(file, editorSelector) {
        var data = new FormData();
        data.append('file', file);
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });
        $.ajax({
            data: data,
            type: 'POST',
            url: "{{ route('admin.summernote.uploadImage') . '?_token=' . csrf_token() }}",
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $(editorSelector).summernote('editor.insertImage', data.url);
            }
        });
    }
});
</script>
@endsection

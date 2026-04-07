{{-- Hero / intro block: same fields as legacy admin/settings/payment-instruction-hero --}}
<form id="paymentInstructionHeroForm" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-8">
            <div class="mb-5">
                <label for="title" class="form-label required">Title</label>
                <input type="text"
                       class="form-control"
                       id="title"
                       name="title"
                       value="{{ old('title', $hero->title ?? '') }}"
                       required>
            </div>

            <div class="mb-5">
                <label for="description" class="form-label required">Description</label>
                <textarea class="form-control"
                          id="description"
                          name="description"
                          rows="8"
                          required>{{ old('description', $hero->description ?? '') }}</textarea>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="mb-5">
                <label for="banner_image" class="form-label">Banner image</label>
                <input type="file"
                       class="form-control"
                       id="banner_image"
                       name="banner_image"
                       accept="image/*">
                <div class="form-text">Optional. Max 2MB. Replaces the default hero image.</div>

                @if(!empty($hero->banner_image))
                    <div class="mt-3">
                        <span class="form-label d-block">Current banner</span>
                        <img src="{{ asset('storage/'.$hero->banner_image) }}"
                             alt="Current banner"
                             class="img-fluid rounded border"
                             style="max-height: 180px;">
                    </div>
                @endif

                <div id="bannerPreviewWrap" class="mt-3" style="display: none;">
                    <span class="form-label d-block">New preview</span>
                    <img id="bannerPreviewImg" src="" alt="" class="img-fluid rounded border" style="max-height: 180px;">
                </div>
            </div>

            <div class="mb-5">
                <label for="status" class="form-label required">Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="Active" {{ ($hero->status ?? '') === 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ ($hero->status ?? '') === 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <div class="form-text">Inactive shows built-in default text on the public page.</div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2 mt-2">
        <button type="submit" class="btn btn-primary">
            <i class="icofont-save"></i> Save payment instructions
        </button>
    </div>
</form>

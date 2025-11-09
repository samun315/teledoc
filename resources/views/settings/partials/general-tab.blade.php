<form id="generalSettingsForm">
    @csrf
    <div class="row">
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label required">Site Name</label>
                <input type="text" class="form-control" name="site_name"
                       value="{{ $settings['site_name'] ?? 'Medsev' }}" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Site Tagline</label>
                <input type="text" class="form-control" name="site_tagline"
                       value="{{ $settings['site_tagline'] ?? 'Healthcare Clinic & Doctor' }}">
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label required">Copyright Text</label>
                <textarea class="form-control" name="copyright_text" rows="2" required>{{ $settings['copyright_text'] ?? '© Medsev 2025. All rights reserved.' }}</textarea>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Meta Description</label>
                <textarea class="form-control" name="meta_description" rows="3">{{ $settings['meta_description'] ?? '' }}</textarea>
                <small class="text-muted">SEO meta description for your website</small>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Meta Keywords</label>
                <input type="text" class="form-control" name="meta_keywords"
                       value="{{ $settings['meta_keywords'] ?? '' }}">
                <small class="text-muted">Comma-separated keywords</small>
            </div>
        </div>

        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Google Analytics Code</label>
                <textarea class="form-control" name="google_analytics" rows="3">{{ $settings['google_analytics'] ?? '' }}</textarea>
                <small class="text-muted">Paste your Google Analytics tracking code here</small>
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                <i class="icofont-save"></i> Save General Settings
            </button>
        </div>
    </div>
</form>


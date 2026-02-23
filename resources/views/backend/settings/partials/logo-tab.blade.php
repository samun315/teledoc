<div class="row">
    <!-- Main Logo -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Main Logo (Header)</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    @if(isset($logos['main']))
                        <img src="{{ asset($logos['main']->file_path) }}" alt="Main Logo"
                             class="img-thumbnail" id="mainLogoPreview" style="max-height: 100px;">
                    @else
                        <div class="border p-5 text-muted" id="mainLogoPreview">
                            No logo uploaded
                        </div>
                    @endif
                </div>
                <form id="mainLogoForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="logo_type" value="main">
                    <div class="mb-3">
                        <label class="form-label">Choose File</label>
                        <input type="file" class="form-control" name="logo_file"
                               accept="image/png,image/jpg,image/jpeg,image/svg+xml">
                        <small class="text-muted">Recommended: 200x50px, PNG/JPG/SVG (Max 2MB)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alt Text</label>
                        <input type="text" class="form-control" name="alt_text"
                               value="{{ $logos['main']->alt_text ?? 'Site Logo' }}">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="icofont-upload"></i> Upload
                    </button>
                    @if(isset($logos['main']))
                    <button type="button" class="btn btn-danger btn-sm delete-logo-btn" data-logo-type="main">
                        <i class="icofont-trash"></i> Remove
                    </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Mobile Logo -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Mobile Logo</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    @if(isset($logos['mobile']))
                        <img src="{{ asset($logos['mobile']->file_path) }}" alt="Mobile Logo"
                             class="img-thumbnail" id="mobileLogoPreview" style="max-height: 80px;">
                    @else
                        <div class="border p-5 text-muted" id="mobileLogoPreview">
                            No logo uploaded
                        </div>
                    @endif
                </div>
                <form id="mobileLogoForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="logo_type" value="mobile">
                    <div class="mb-3">
                        <label class="form-label">Choose File</label>
                        <input type="file" class="form-control" name="logo_file"
                               accept="image/png,image/jpg,image/jpeg,image/svg+xml">
                        <small class="text-muted">Recommended: 150x40px, PNG/JPG/SVG (Max 2MB)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alt Text</label>
                        <input type="text" class="form-control" name="alt_text"
                               value="{{ $logos['mobile']->alt_text ?? 'Mobile Logo' }}">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="icofont-upload"></i> Upload
                    </button>
                    @if(isset($logos['mobile']))
                    <button type="button" class="btn btn-danger btn-sm delete-logo-btn" data-logo-type="mobile">
                        <i class="icofont-trash"></i> Remove
                    </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Footer Logo -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Footer Logo (Optional)</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    @if(isset($logos['footer']))
                        <img src="{{ asset($logos['footer']->file_path) }}" alt="Footer Logo"
                             class="img-thumbnail" id="footerLogoPreview" style="max-height: 100px;">
                    @else
                        <div class="border p-5 text-muted" id="footerLogoPreview">
                            No logo uploaded
                        </div>
                    @endif
                </div>
                <form id="footerLogoForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="logo_type" value="footer">
                    <div class="mb-3">
                        <label class="form-label">Choose File</label>
                        <input type="file" class="form-control" name="logo_file"
                               accept="image/png,image/jpg,image/jpeg,image/svg+xml">
                        <small class="text-muted">Recommended: 200x50px, PNG/JPG/SVG (Max 2MB)</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alt Text</label>
                        <input type="text" class="form-control" name="alt_text"
                               value="{{ $logos['footer']->alt_text ?? 'Footer Logo' }}">
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="icofont-upload"></i> Upload
                    </button>
                    @if(isset($logos['footer']))
                    <button type="button" class="btn btn-danger btn-sm delete-logo-btn" data-logo-type="footer">
                        <i class="icofont-trash"></i> Remove
                    </button>
                    @endif
                </form>
            </div>
        </div>
    </div>

    <!-- Favicon -->
    <div class="col-md-6">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Favicon</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    @if(isset($logos['favicon']))
                        <img src="{{ asset($logos['favicon']->file_path) }}" alt="Favicon"
                             class="img-thumbnail" id="faviconPreview" style="max-height: 50px;">
                    @else
                        <div class="border p-4 text-muted" id="faviconPreview">
                            No favicon uploaded
                        </div>
                    @endif
                </div>
                <form id="faviconForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="logo_type" value="favicon">
                    <div class="mb-3">
                        <label class="form-label">Choose File</label>
                        <input type="file" class="form-control" name="logo_file"
                               accept="image/x-icon,image/png">
                        <small class="text-muted">Recommended: 32x32px or 16x16px, ICO/PNG (Max 100KB)</small>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="icofont-upload"></i> Upload
                    </button>
                    @if(isset($logos['favicon']))
                    <button type="button" class="btn btn-danger btn-sm delete-logo-btn" data-logo-type="favicon">
                        <i class="icofont-trash"></i> Remove
                    </button>
                    @endif
                </form>
            </div>
        </div>
    </div>
</div>


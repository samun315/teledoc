<form id="contactSettingsForm">
    @csrf
    <div class="row">
        <!-- Email Addresses -->
        <div class="col-md-12">
            <h5 class="mb-3">Email Addresses</h5>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label required">Primary Email</label>
                <input type="email" class="form-control" name="contact_email_1"
                       value="{{ $settings['contact_email_1'] ?? 'hello@example.com' }}" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="mb-3">
                <label class="form-label">Secondary Email</label>
                <input type="email" class="form-control" name="contact_email_2"
                       value="{{ $settings['contact_email_2'] ?? '' }}">
            </div>
        </div>

        <!-- Phone Numbers -->
        <div class="col-md-12 mt-3">
            <h5 class="mb-3">Phone Numbers</h5>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label required">Primary Phone</label>
                <input type="text" class="form-control" name="contact_phone_1"
                       value="{{ $settings['contact_phone_1'] ?? '+07 554 332 322' }}" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Secondary Phone</label>
                <input type="text" class="form-control" name="contact_phone_2"
                       value="{{ $settings['contact_phone_2'] ?? '' }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">WhatsApp Number</label>
                <input type="text" class="form-control" name="contact_whatsapp"
                       value="{{ $settings['contact_whatsapp'] ?? '' }}">
            </div>
        </div>

        <!-- Address -->
        <div class="col-md-12 mt-3">
            <h5 class="mb-3">Address</h5>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label required">Address Line 1</label>
                <input type="text" class="form-control" name="contact_address_1"
                       value="{{ $settings['contact_address_1'] ?? '210-27 Quadra, Market Street' }}" required>
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Address Line 2</label>
                <input type="text" class="form-control" name="contact_address_2"
                       value="{{ $settings['contact_address_2'] ?? '' }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">City</label>
                <input type="text" class="form-control" name="contact_city"
                       value="{{ $settings['contact_city'] ?? 'Victoria' }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">State/Province</label>
                <input type="text" class="form-control" name="contact_state"
                       value="{{ $settings['contact_state'] ?? '' }}">
            </div>
        </div>
        <div class="col-md-4">
            <div class="mb-3">
                <label class="form-label">Postal Code</label>
                <input type="text" class="form-control" name="contact_postal_code"
                       value="{{ $settings['contact_postal_code'] ?? '' }}">
            </div>
        </div>
        <div class="col-md-12">
            <div class="mb-3">
                <label class="form-label">Country</label>
                <input type="text" class="form-control" name="contact_country"
                       value="{{ $settings['contact_country'] ?? 'Canada' }}">
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-primary">
                <i class="icofont-save"></i> Save Contact Settings
            </button>
        </div>
    </div>
</form>


<!-- Social Media Modal -->
<div class="modal fade" id="socialMediaModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="socialMediaModalTitle">Add Social Media Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="socialMediaForm">
                @csrf
                <input type="hidden" id="socialMediaId" name="id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Platform</label>
                        <select class="form-control" name="platform" id="socialPlatform" required>
                            <option value="">Select Platform</option>
                            <option value="facebook">Facebook</option>
                            <option value="twitter">Twitter</option>
                            <option value="instagram">Instagram</option>
                            <option value="linkedin">LinkedIn</option>
                            <option value="youtube">YouTube</option>
                            <option value="pinterest">Pinterest</option>
                            <option value="tiktok">TikTok</option>
                            <option value="whatsapp">WhatsApp</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">URL</label>
                        <input type="url" class="form-control" name="url" id="socialUrl"
                               placeholder="https://facebook.com/yourpage" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon Class (auto-filled)</label>
                        <input type="text" class="form-control" name="icon_class" id="socialIcon"
                               placeholder="icofont-facebook" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">Display Location</label>
                        <select class="form-control" name="display_location" id="socialLocation" required>
                            <option value="header">Header Only</option>
                            <option value="footer">Footer Only</option>
                            <option value="both" selected>Both</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Order</label>
                                <input type="number" class="form-control" name="order" id="socialOrder"
                                       value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <select class="form-control" name="active" id="socialActive" required>
                                    <option value="YES">Active</option>
                                    <option value="NO">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


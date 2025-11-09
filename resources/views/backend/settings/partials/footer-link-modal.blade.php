<!-- Footer Link Modal -->
<div class="modal fade" id="footerLinkModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="footerLinkModalTitle">Add Footer Link</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="footerLinkForm">
                @csrf
                <input type="hidden" id="footerLinkId" name="id">
                <input type="hidden" id="footerLinkSection" name="section">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label required">Title</label>
                        <input type="text" class="form-control" name="title" id="linkTitle"
                               placeholder="About Us" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Link Type</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="link_type"
                                   id="linkTypeInternal" value="internal" checked>
                            <label class="form-check-label" for="linkTypeInternal">
                                Internal Route
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="link_type"
                                   id="linkTypeExternal" value="external">
                            <label class="form-check-label" for="linkTypeExternal">
                                External URL
                            </label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label required">URL/Route</label>
                        <input type="text" class="form-control" name="url" id="linkUrl"
                               placeholder="/about or https://example.com" required>
                        <small class="text-muted">Internal: /about, External: https://example.com</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Icon Class (optional)</label>
                        <input type="text" class="form-control" name="icon" id="linkIcon"
                               placeholder="icofont-home">
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Target</label>
                                <select class="form-control" name="target" id="linkTarget">
                                    <option value="_self">Same Tab</option>
                                    <option value="_blank">New Tab</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label">Order</label>
                                <input type="number" class="form-control" name="order" id="linkOrder"
                                       value="0" min="0">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <select class="form-control" name="active" id="linkActive" required>
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


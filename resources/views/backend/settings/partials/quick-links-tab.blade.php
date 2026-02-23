<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-success mb-3" id="addQuickLinkBtn" data-section="quick_links" data-action="add">
            <i class="icofont-plus"></i> Add Quick Link
        </button>
    </div>

    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="quickLinksTable">
                <thead>
                    <tr>
                        <th width="25%">Title</th>
                        <th width="35%">URL</th>
                        <th width="12%">Type</th>
                        <th width="10%">Target</th>
                        <th width="10%">Status</th>
                        <th width="8%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($footerLinks->where('section', 'quick_links') as $link)
                    <tr data-id="{{ $link->id }}">
                        <td>{{ $link->title }}</td>
                        <td>{{ Str::limit($link->url, 50) }}</td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst($link->link_type) }}</span>
                        </td>
                        <td>{{ $link->target }}</td>
                        <td>
                            <span class="badge badge-{{ $link->active == 'YES' ? 'success' : 'danger' }}">
                                {{ $link->active }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary edit-footer-link-btn" data-id="{{ $link->id }}" data-section="quick_links" data-action="edit" title="Edit">
                                <i class="fas fa-edit text-white"></i>
                            </button>
                            <button class="btn btn-sm btn-danger delete-footer-link-btn" data-id="{{ $link->id }}" data-action="delete" title="Delete">
                                <i class="fas fa-trash text-white"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No quick links added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


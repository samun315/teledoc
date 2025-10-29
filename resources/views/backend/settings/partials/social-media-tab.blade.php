<div class="row">
    <div class="col-md-12">
        <button type="button" class="btn btn-success mb-3" onclick="openSocialMediaModal()">
            <i class="icofont-plus"></i> Add Social Media Link
        </button>
    </div>

    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="socialMediaTable">
                <thead>
                    <tr>
                        <th width="20%">Platform</th>
                        <th width="35%">URL</th>
                        <th width="15%">Icon</th>
                        <th width="15%">Location</th>
                        <th width="8%">Status</th>
                        <th width="7%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($socialMediaLinks as $link)
                    <tr data-id="{{ $link->id }}">
                        <td>{{ ucfirst($link->platform) }}</td>
                        <td><a href="{{ $link->url }}" target="_blank">{{ Str::limit($link->url, 50) }}</a></td>
                        <td><i class="{{ $link->icon_class }}"></i> {{ $link->icon_class }}</td>
                        <td>
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $link->display_location)) }}</span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $link->active == 'YES' ? 'success' : 'danger' }}">
                                {{ $link->active }}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="editSocialMedia({{ $link->id }})">
                                <i class="icofont-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger" onclick="deleteSocialMedia({{ $link->id }})">
                                <i class="icofont-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No social media links added yet</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


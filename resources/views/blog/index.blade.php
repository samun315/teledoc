@extends('master')

@section('title', 'Blog Posts')

@section('content')
    <x-toolbar-component title="Blog Posts" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Blog', 'url' => 'javascript:void(0)'],
        ['label' => 'Blog Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Blog Posts', 'active' => true],
    ]" actionIcon="fas fa-plus-circle" actionLabel="Add New Post" actionUrl="{{ route('blog.blog.create') }}" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">

                <!--begin::Header-->
                <div class="card-header border-0 pt-5">
                    <!-- Search is handled by DataTables built-in search -->
                </div>
                <!--end::Header-->

                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <!--begin::Table-->
                    <div class="table-responsive">
                        <table class="table table-row-dashed table-row-gray-300 align-middle gs-0 gy-4"
                            id="kt_blog_table">
                            <!--begin::Table head-->
                            <thead>
                                <!--begin::Table row-->
                                <tr class="text-start text-muted text-uppercase fw-bolder fs-7 gs-0">
                                    <th>#</th>
                                    <th>Featured Image</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="text-gray-600 fw-semibold">
                                @forelse($blogs as $blog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                                                                <td>
                                            @if($blog->banner_image)
                                                <img src="{{ asset('storage/' . $blog->banner_image) }}"
                                                     alt="{{ $blog->title }}"
                                                     class="w-50px h-50px rounded object-fit-cover">
                                            @else
                                                <div class="w-50px h-50px bg-light rounded d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex flex-column">
                                                <span class="text-dark fw-bold fs-6">{{ $blog->title }}</span>
                                                <span class="text-muted fs-7">{{ Str::limit($blog->content, 100) }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            @if($blog->category)
                                                <span class="badge badge-light-primary">{{ $blog->category->category_name }}</span>
                                            @else
                                                <span class="text-muted">No Category</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($blog->status === 'Published')
                                                <span class="badge badge-light-success">Published</span>
                                            @elseif($blog->status === 'Scheduled')
                                                <span class="badge badge-light-info">Scheduled</span>
                                            @else
                                                <span class="badge badge-light-warning">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $blog->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('blog.blog.edit', $blog->blog_id) }}"
                                                   class="btn btn-sm btn-light-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button"
                                                        class="btn btn-sm btn-light-danger delete-btn"
                                                        data-id="{{ $blog->blog_id }}"
                                                        data-title="{{ $blog->title }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-inbox fa-2x mb-2"></i>
                                            <p>No blog posts found</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>
                    <!--end::Table-->

                    <!--begin::Pagination-->
                    @if($blogs->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $blogs->links() }}
                        </div>
                    @endif
                    <!--end::Pagination-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete "<span id="blogTitle"></span>"?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_script')
    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/blog/index.js') }}" {{ Sri::html('assets/custom/js/blog/index.js') }}>
    </script>
    <!--end::Page Custom Stylesheets(used by this page)-->
@endsection

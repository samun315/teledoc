@extends('master')

@section('title', 'Create Blog Post')

@section('content')
    <x-toolbar-component title="Create Blog Post" :breadcrumbs="[
        ['label' => 'Home', 'url' => route('dashboard')],
        ['label' => 'Blog', 'url' => 'javascript:void(0)'],
        ['label' => 'Blog Management', 'url' => 'javascript:void(0)'],
        ['label' => 'Blog Posts', 'url' => route('blog.blog.index')],
        ['label' => 'Create Blog Post', 'active' => true],
    ]" actionIcon="fas fa-arrow-left" actionLabel="Back to List" actionUrl="{{ route('blog.blog.index') }}" />

    <div class="post d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div id="kt_content_container" class="container-fluid">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-body py-4">
                    @include('message')

                    <form id="blogForm" action="{{ route('blog.blog.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-lg-8">
                                <!-- Title -->
                                <div class="mb-5">
                                    <label for="title" class="form-label required">Title</label>
                                    <input type="text"
                                           class="form-control @error('title') is-invalid @enderror"
                                           id="title"
                                           name="title"
                                           value="{{ old('title') }}"
                                           placeholder="Enter blog title"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div class="mb-5">
                                    <label for="content" class="form-label required">Content</label>
                                    <textarea class="form-control @error('content') is-invalid @enderror"
                                              id="content"
                                              name="content"
                                              rows="15"
                                              placeholder="Write your blog content here..."
                                              required>{{ old('content') }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>


                            </div>

                            <!-- Right Column -->
                            <div class="col-lg-4">
                                <!-- Featured Image -->
                                <div class="mb-5">
                                    <label for="featured_image" class="form-label">Featured Image</label>
                                    <div class="image-input-wrapper">
                                        <input type="file"
                                               class="form-control @error('featured_image') is-invalid @enderror"
                                               id="featured_image"
                                               name="featured_image"
                                               accept="image/*">
                                        <div class="form-text">Max size: 2MB. Formats: JPEG, PNG, JPG, GIF</div>
                                        @error('featured_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div id="imagePreview" class="mt-2" style="display: none;">
                                        <img id="previewImg" src="" alt="Preview" class="img-fluid rounded" style="max-height: 200px;">
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mb-5">
                                    <label for="status" class="form-label required">Status</label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status"
                                            required>
                                        <option value="">Select Status</option>
                                        <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>Published</option>
                                        <option value="Scheduled" {{ old('status') == 'Scheduled' ? 'selected' : '' }}>Scheduled</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div class="mb-5">
                                    <label for="category_id" class="form-label required">Category</label>
                                    <select class="form-select @error('category_id') is-invalid @enderror"
                                            id="category_id"
                                            name="category_id"
                                            required>
                                        <option value="">Select Category</option>
                                        @foreach($categories ?? [] as $category)
                                            <option value="{{ $category->blog_category_id }}" {{ old('category_id') == $category->blog_category_id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tags -->
                                <div class="mb-5">
                                    <label for="tags" class="form-label">Tags</label>
                                    <select class="form-select @error('tags') is-invalid @enderror"
                                            id="tags"
                                            name="tags[]"
                                            multiple>
                                        @foreach($tags ?? [] as $tag)
                                            <option value="{{ $tag->blog_tag_id }}" {{ in_array($tag->blog_tag_id, old('tags', [])) ? 'selected' : '' }}>
                                                {{ $tag->tag_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tags')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Hold Ctrl/Cmd to select multiple tags</div>
                                </div>



                                <!-- Meta Description -->
                                <div class="mb-5">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control @error('meta_description') is-invalid @enderror"
                                              id="meta_description"
                                              name="meta_description"
                                              rows="3"
                                              placeholder="SEO meta description">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Maximum 160 characters</div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-end gap-2 mt-5">
                            <a href="{{ route('blog.blog.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Blog Post
                            </button>
                        </div>
                    </form>
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Container-->
    </div>

@endsection

@section('page_script')
    <!-- begin::Page Custom Stylesheets(used by this page) -->
    <script src="{{ asset('assets/custom/js/blog/create.js') }}" {{ Sri::html('assets/custom/js/blog/create.js') }}>
    </script>
    <!--end::Page Custom Stylesheets(used by this page)-->
@endsection

@extends('frontend.master')

@section('title', ($siteSettings['site_name'] ?? 'TeleDoc') . ' - Blog')
@section('meta_description', 'Read the latest healthcare tips, news, and updates from TeleDoc Athful.')

@section('content')
    <!-- Page Title -->
    <div class="page-title-area page-title-four">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="page-title-item">
                    <h2>Our Latest Blogs</h2>
                    <ul>
                        <li>
                            <a href="{{ route('home') }}">Home</a>
                        </li>
                        <li>
                            <i class="icofont-simple-right"></i>
                        </li>
                        <li>Blogs</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Page Title -->

    <!-- Blog -->
    <section class="blog-area-two pt-100">
        <div class="container">
            <div class="row justify-content-center">
                @forelse($blogs as $index => $blog)
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ .3 + ($index % 3) * 0.2 }}s">
                    <div class="blog-item">
                        <div class="blog-top">
                            <a href="{{ route('blog-details', $blog->slug) }}">
                                <img src="{{ $blog->banner_image ? asset('storage/' . $blog->banner_image) : asset('assets/img/home-one/11.jpg') }}" alt="{{ $blog->title }}">
                            </a>
                        </div>
                        <div class="blog-bottom">
                            <h3>
                                <a href="{{ route('blog-details', $blog->slug) }}">
                                    {{ $blog->title }}
                                </a>
                            </h3>
                            <p>{{ Str::limit(strip_tags($blog->content), 100, '....') }}</p>
                            <ul>
                                <li>
                                    <a href="{{ route('blog-details', $blog->slug) }}">
                                        Read More
                                        <i class="icofont-long-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <i class="icofont-calendar"></i>
                                    {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No blog posts available at the moment.</p>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($blogs->hasPages())
            <div class="row">
                <div class="col-12">
                    <div class="pagination-area d-flex justify-content-center mt-4">
                        {{ $blogs->links() }}
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- End Blog -->
@endsection

@section('page_script')
@endsection

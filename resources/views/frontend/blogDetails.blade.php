@extends('frontend.master')
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

    <!-- Blog Details -->
    <div class="blog-details-area pt-100">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="blog-details-item">
                        <div class="blog-details-img">
                            <img src="{{ $blog->banner_image ? asset('storage/' . $blog->banner_image) : asset('assets/img/blog/2.jpg') }}" alt="{{ $blog->title }}">
                            <h2>{{ $blog->title }}</h2>
                            <ul>
                                <li>
                                    <a href="javascript:void(0)">
                                        <i class="icofont-businessman"></i>
                                    Admin
                                    </a>
                                </li>
                                <li>
                                    <i class="icofont-calendar"></i>
                                    {{ $blog->published_at ? $blog->published_at->format('M d, Y') : $blog->created_at->format('M d, Y') }}
                                </li>
                            </ul>
                            <div>{!! $blog->content !!}</div>
                        </div>
                        <div class="blog-details-previous">
                            <div class="prev-next">
                                <ul>
                                    <li>
                                        @if($previousBlog)
                                            <a href="{{ route('blog-details', $previousBlog->slug) }}">Previous</a>
                                        @else
                                            <a href="javascript:void(0)" style="pointer-events: none; opacity: 0.5;">Previous</a>
                                        @endif
                                    </li>
                                    <li>
                                        @if($nextBlog)
                                            <a href="{{ route('blog-details', $nextBlog->slug) }}">Next</a>
                                        @else
                                            <a href="javascript:void(0)" style="pointer-events: none; opacity: 0.5;">Next</a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="blog-details-item">
                        <div class="blog-details-search">
                            <form>
                                <input type="text" class="form-control" placeholder="Search">
                                <button type="submit" class="btn blog-details-btn">
                                    <i class="icofont-search-1"></i>
                                </button>
                            </form>
                        </div>
                        <div class="blog-details-recent">
                            <h3>Recent Blogs</h3>
                            <ul>
                                @forelse($recentBlogs as $recentBlog)
                                <li>
                                    <img src="{{ $recentBlog->banner_image ? asset('storage/' . $recentBlog->banner_image) : asset('assets/img/blog/3.jpg') }}" alt="Recent">
                                    <a href="{{ route('blog-details', $recentBlog->slug) }}">{{ Str::limit($recentBlog->title, 50) }}</a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i class="icofont-businessman"></i>
                                            Admin
                                            </a>
                                        </li>
                                        <li>
                                            <i class="icofont-calendar"></i>
                                            {{ $recentBlog->published_at ? $recentBlog->published_at->format('M d, Y') : $recentBlog->created_at->format('M d, Y') }}
                                        </li>
                                    </ul>
                                </li>
                                @empty
                                <li>
                                    <p class="text-muted">No recent blogs available</p>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="blog-details-category">
                            <h3>Category</h3>
                            <ul>
                                @forelse($categories as $category)
                                <li>
                                    <a href="javascript:void(0)">{{ $category->category_name }}</a>
                                </li>
                                @empty
                                <li>
                                    <a href="javascript:void(0)">No categories available</a>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                        <div class="blog-details-tags">
                            <h3>Tags</h3>
                            <ul>
                                @forelse($blog->tags as $tag)
                                <li>
                                    <a href="javascript:void(0)">{{ $tag->tag_name }}</a>
                                </li>
                                @empty
                                <li>
                                    <a href="javascript:void(0)">No tags</a>
                                </li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Details -->

    <!-- Blog -->
    <section class="blog-area-two">
        <div class="container">
            <div class="section-title">
                <h2>Our Latest Blogs</h2>
            </div>
            <div class="row justify-content-center">
                @forelse($recentBlogs as $index => $latestBlog)
                <div class="col-sm-6 col-lg-4 wow fadeInUp" data-wow-delay="{{ .3 + ($index * 0.2) }}s">
                    <div class="blog-item">
                        <div class="blog-top">
                            <a href="{{ route('blog-details', $latestBlog->slug) }}">
                                <img src="{{ $latestBlog->banner_image ? asset('storage/' . $latestBlog->banner_image) : asset('assets/img/home-one/11.jpg') }}" alt="{{ $latestBlog->title }}">
                            </a>
                        </div>
                        <div class="blog-bottom">
                            <h3>
                                <a href="{{ route('blog-details', $latestBlog->slug) }}">
                                    {{ $latestBlog->title }}
                                </a>
                            </h3>
                            <p>{{ Str::limit(strip_tags($latestBlog->content), 100, '....') }}</p>
                            <ul>
                                <li>
                                    <a href="{{ route('blog-details', $latestBlog->slug) }}">
                                        Read More
                                        <i class="icofont-long-arrow-right"></i>
                                    </a>
                                </li>
                                <li>
                                    <i class="icofont-calendar"></i>
                                    {{ $latestBlog->published_at ? $latestBlog->published_at->format('M d, Y') : $latestBlog->created_at->format('M d, Y') }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No recent blogs available</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- End Blog -->

@endsection

@section('page_script')
@endsection

<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogCategory;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function homePage(){
        //dd('test');
        return view('frontend.home');
    }

    function homePage2(){
        //dd('test');
        return view('frontend.welcomePage2');
    }

    function contactUs(){
        return view('frontend.contactUs');
    }

    function about(){
        return view('frontend.about');
    }

    function blog(){
        // Fetch active blog posts with relationships
        $blogs = Blog::with(['category', 'tags'])
            ->where('status', 'Published')
            ->latest('published_at')
            ->paginate(9);

        return view('frontend.blog', compact('blogs'));
    }

    function blogDetails($slug){
        // Fetch blog post by slug with relationships
        $blog = Blog::with(['category', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'Published')
            ->firstOrFail(); // Returns 404 if not found

        // Recent blogs (3 latest, excluding current)
        $recentBlogs = Blog::where('status', 'Published')
            ->where('blog_id', '!=', $blog->blog_id)
            ->latest('created_at')
            ->take(3)
            ->get();

        // All categories
        $categories = BlogCategory::where('status', 'Active')
            ->get();

        return view('frontend.blogDetails', compact('blog', 'recentBlogs', 'categories'));
    }
}

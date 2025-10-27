<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Blog\Blog;
use App\Models\Blog\BlogCategory;
use App\Models\Slider\Slider;
use App\Models\Service\Service;
use App\Models\Speciality\Speciality;
use App\Models\Testimonial\Testimonial;
use App\Models\Faq\Faq;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    function homePage(){
        // Fetch active sliders for home page
        $sliders = Slider::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        // Fetch 3 latest published blogs for home page
        $latestBlogs = Blog::where('status', 'Published')
            ->latest('published_at')
            ->take(3)
            ->get();
        // Fetch all active services
        $services = Service::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        return view('frontend.home', compact('sliders', 'latestBlogs', 'services'));
    }

    function homePage2(){
        //dd('test');
        return view('frontend.welcomePage2');
    }

    function contactUs(){
        return view('frontend.contactUs');
    }

    function about(){
        // Fetch 3 latest published blogs for home page
        $latestBlogs = Blog::where('status', 'Published')
            ->latest('published_at')
            ->take(3)
            ->get();
        // Fetch all active services
        $services = Service::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
        // Fetch all active specialities
        $specialities = Speciality::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();
        // Fetch all active testimonials
        $testimonials = Testimonial::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        return view('frontend.about', compact('latestBlogs', 'services', 'specialities', 'testimonials'));
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

    public function service(){
        // Fetch all active services
        $services = Service::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        return view('frontend.service', compact('services'));
    }

    public function serviceDetails($id){
        // Fetch service by ID
        $service = Service::where('service_id', $id)
            ->where('status', 'Active')
            ->firstOrFail(); // Returns 404 if not found

        // Fetch 3 latest blogs
        $latestBlogs = Blog::where('status', 'Published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.serviceDetails', compact('service', 'latestBlogs'));
    }

    public function faqs(){
        // Fetch all active FAQs
        $faqs = Faq::where('status', 'Active')
            ->orderBy('order', 'asc')
            ->get();

        return view('frontend.faq', compact('faqs'));
    }

    public function doctors(){
        return view('frontend.doctors');
    }

    public function doctorDetails($id){
        return view('frontend.doctorDetails');
    }
}

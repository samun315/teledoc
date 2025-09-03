<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogRequest;
use App\Services\Blog\BlogService;
use App\Services\Blog\BlogCategoryService;
use App\Services\Blog\BlogTagService;
use App\Models\Blog\BlogCategory;
use App\Models\Blog\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    protected $blogService;
    protected $categoryService;
    protected $tagService;

    public function __construct(BlogService $blogService, BlogCategoryService $categoryService, BlogTagService $tagService)
    {
        $this->blogService = $blogService;
        $this->categoryService = $categoryService;
        $this->tagService = $tagService;
    }

    public function index()
    {
        $blogs = $this->blogService->getAllBlogs();
        return view('blog.index', compact('blogs'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', 'Active')->get();
        $tags = BlogTag::where('status', 'Active')->get();
        return view('blog.create', compact('categories', 'tags'));
    }

    public function store(BlogRequest $request)
    {
        try {
            $test = $this->blogService->createBlog($request->validated());
            //dd($test);
            //return redirect()->route('blog.blog.index')->with('success', 'Blog post created successfully');
            return sendSuccessResponse(201, 'Blog post created successfully.');
        } catch (\Exception $e) {
            //dd($e);
            //return back()->withInput()->with('error', 'Failed to create blog post: ' . $e->getMessage());
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit($blog_id)
    {
        try {
            $blog = $this->blogService->getBlogById($blog_id);
            $categories = BlogCategory::where('status', 'Active')->get();
            $tags = BlogTag::where('status', 'Active')->get();
            return view('blog.edit', compact('blog', 'categories', 'tags'));
        } catch (\Exception $e) {
            return redirect()->route('blog.blog.index')->with('error', 'Blog post not found');
        }
    }

    public function update(BlogRequest $request, $blog_id)
    {
        try {
            $this->blogService->updateBlog($blog_id, $request->validated());
            return sendSuccessResponse(201, 'Blog post created successfully.');
        } catch (\Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function destroy($blog_id)
    {
        try {
            $this->blogService->deleteBlog($blog_id);
            return redirect()->route('blog.blog.index')->with('success', 'Blog post deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('blog.blog.index')->with('error', 'Failed to delete blog post: ' . $e->getMessage());
        }
    }
}

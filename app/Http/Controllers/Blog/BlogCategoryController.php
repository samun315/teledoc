<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogCategoryRequest;
use App\Services\Blog\BlogCategoryService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogCategoryController extends Controller
{
    public function __construct(protected BlogCategoryService $blogCategoryService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->blogCategoryService->getBlogCategoryList($request);
        }

        return view('blog.category.index');
    }

    public function store(BlogCategoryRequest $request): JsonResponse
    {
        try {

            $this->blogCategoryService->createBlogCategory($request->fields());
            return sendSuccessResponse(201, 'Blog Category created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $blogCategoryId): JsonResponse
    {
        $data = $this->blogCategoryService->getBlogCategoryById($blogCategoryId);
        return sendSuccessResponse(200, '', 'blogCategoryInfo', $data);
    }

    public function update(BlogCategoryRequest $request, int $blogCategoryId): JsonResponse
    {
        try {

            $this->blogCategoryService->updateBlogCategory($request->fields(), $blogCategoryId);
            return sendSuccessResponse(201, 'Blog Category updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}

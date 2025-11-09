<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\BlogTagRequest;
use App\Services\Blog\BlogTagService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogTagController extends Controller
{
    public function __construct(protected BlogTagService $blogTagService) {}

    public function index(Request $request): View|JsonResponse
    {
        if ($request->ajax()) {
            return $this->blogTagService->getBlogTagList($request);
        }

        return view('blog.tag.index');
    }

    public function store(BlogTagRequest $request): JsonResponse
    {
        try {

            $this->blogTagService->createBlogTag($request->fields());
            return sendSuccessResponse(201, 'Blog Tag created successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }

    public function edit(int $blogTagId): JsonResponse
    {
        $data = $this->blogTagService->getBlogTagById($blogTagId);
        return sendSuccessResponse(200, '', 'blogTagInfo', $data);
    }

    public function update(BlogTagRequest $request, int $blogTagId): JsonResponse
    {
        try {

            $this->blogTagService->updateBlogTag($request->fields(), $blogTagId);
            return sendSuccessResponse(201, 'Blog Tag updated successfully.');
        } catch (Exception $e) {
            return sendErrorResponse('Internal Server Error: ', $e->getMessage());
        }
    }
}

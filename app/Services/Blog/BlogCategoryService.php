<?php

namespace App\Services\Blog;

use App\Models\Blog\BlogCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BlogCategoryService
{
    public function getBlogCategoryList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = BlogCategory::query()->select('blog_category_id', 'category_name', 'description', 'slug', 'status')->latest();

        if ($searchKeyword) {
            $query->where('category_name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('description', 'like', '%' . $searchKeyword . '%')
                ->orWhere('status', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->blog_category_id . '" class="btn btn-bg-info text-white btn-sm editBlogCategoryBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createBlogCategory(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $blogCategory = BlogCategory::query()->create($data);
            DB::commit();

            return $blogCategory;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getBlogCategoryById(int $blogCategoryId): Model|Builder
    {
        return BlogCategory::find($blogCategoryId);
    }

    public function updateBlogCategory(array $updateData, int $blogCategoryId): int
    {
        $blogCategory = $this->getBlogCategoryById($blogCategoryId);

        return $blogCategory->update($updateData);
    }
}

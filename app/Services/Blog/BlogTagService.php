<?php

namespace App\Services\Blog;

use App\Models\Blog\BlogTag;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BlogTagService
{
    public function getBlogTagList(Request $request): JsonResponse|Model|Builder
    {
        $searchKeyword = $request->input('search');

        $query = BlogTag::query()->select('blog_tag_id', 'tag_name', 'description', 'slug', 'status')->latest();

        if ($searchKeyword) {
            $query->where('tag_name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('description', 'like', '%' . $searchKeyword . '%')
                ->orWhere('status', 'like', '%' . $searchKeyword . '%');
        }

        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {

                $editBtn = '<button data-id="' . $row?->blog_tag_id . '" class="btn btn-bg-info text-white btn-sm editBlogTagBtn" data-bs-toggle="modal" data-bs-target="#showModal"><i class="fas fa-edit text-white"></i> Edit</button>';

                $button = '<div class="btn-group" role="group" aria-label="Basic example">
                            ' . $editBtn . '
                            </div>';
                return $button;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function createBlogTag(array $data): Model|Builder|bool
    {
        DB::beginTransaction();
        try {

            $blogTag = BlogTag::query()->create($data);
            DB::commit();

            return $blogTag;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function getBlogTagById(int $blogTagId): Model|Builder
    {
        return BlogTag::find($blogTagId);
    }

    public function updateBlogTag(array $updateData, int $blogTagId): int
    {
        $blogTag = $this->getBlogTagById($blogTagId);

        return $blogTag->update($updateData);
    }
}

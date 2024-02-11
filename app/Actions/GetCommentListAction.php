<?php

namespace App\Actions;

use App\Models\Comment;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetCommentListAction
{
    public function execute(
        ?int $parentId = null,
        ?string $column = 'created_at',
        string $order = 'asc'
    ): LengthAwarePaginator {
        return Comment::with(['text', 'media'])
            ->when(
                $parentId,
                function (Builder $q, int $parentId) {
                    $q->where('parent_id', '=', $parentId);
                },
                function (Builder $q) {
                    $q->whereNull('parent_id');
                }
            )
            ->orderBy($column, $order)
            ->paginate(25);
    }
}

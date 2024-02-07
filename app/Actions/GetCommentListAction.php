<?php

namespace App\Actions;

use App\Models\Comment;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetCommentListAction
{
    public function execute(
        ?int $parentId = null,
        ?string $column = null,
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
            ->when(
                $column,
                function (Builder $q, string $column) use ($order): void {
                    $q->orderBy($column, $order);
                },
                function (Builder $q) use ($order): void {
                    $q->orderBy('created_at', $order);
                },
            )
            ->paginate(25);
    }
}

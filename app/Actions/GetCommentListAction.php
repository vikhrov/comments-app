<?php

namespace App\Actions;

use App\Models\Comment;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetCommentListAction
{
    public function execute(
        ?string $order = 'desc',
        ?int $parentId = null,
        ?string $column = 'created_at',
    ): LengthAwarePaginator {
//        dd($order,$parentId,$column);
        return Comment::with(['text', 'media'])
            ->where('parent_id', '=', $parentId)
            ->orderBy($column, $order)
            ->paginate(25);
    }
}

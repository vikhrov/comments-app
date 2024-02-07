<?php

namespace App\Http\Controllers;

use App\Actions\CreateCommentAction;
use App\Actions\GetCommentListAction;
use App\Exceptions\EntityCreateException;
use App\Http\Requests\CommentValidationRequest;
use App\Http\Requests\GetCommentListRequest;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{

    public function index(GetCommentListRequest $request, GetCommentListAction $action): View
    {
//        $sortDirection = $request->input('sort_direction', 'created_at|desc');
//        list($sortField, $sortDirection) = explode('|', $sortDirection);

//        $comments = $action->execute(column: $sortField, order: $sortDirection);
        $comments = $action->execute(column: $request->getColumn(), order: $request->getDirection());

        return view('welcome', compact('comments',));
    }

    public function create(Request $request): View
    {
        $parentId = $request->input('parent_id');
        $parentComment = Comment::find($parentId);

        return view ('comments.create', compact('parentComment'));
    }

    public function store(CommentValidationRequest $request, CreateCommentAction $action): RedirectResponse
    {
        try {
            $action->execute($request->getData());
        } catch (EntityCreateException) {
            return back()->withErrors([
                    'body' => 'Fail to create comment. Something went wrong'
                ]);
        }

        return redirect(route('comments.index'));
    }

//    public function getReplies(int $parentId): View
//    {
//        $replies = Comment::with(['text', 'media'])
//            ->where('parent_id', $parentId)
//            ->orderBy('created_at', 'desc')
//            ->get();
//
//        return view('comments.replies', compact('replies'));
//    }

    public function getReplies(int $parentId): View
    {
        $replies = Comment::with(['text', 'media'])
            ->where('parent_id', $parentId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('comments.replies', compact('replies'));
    }
}

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
        $comments = $action->execute(order: $request->getOrder(), column: $request->getColumn());
        $comments->appends(['column' => $request->getColumn(), 'direction' => $request->getOrder()]);

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

    public function getReplies(int $parentId, GetCommentListAction $action): View
    {
        $replies = $action->execute(parentId: $parentId);

        return view('comments.replies', compact('replies',));
    }
}

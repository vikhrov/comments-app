<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Text;;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{

    public function index(Request $request)
    {
        $sortDirection = $request->input('sort_direction', 'created_at|desc');
        list($sortField, $sortDirection) = explode('|', $sortDirection);

        $comments = Comment::with(['text'])
            ->where('parent_id', null)
            ->orderBy($sortField, $sortDirection)
            ->paginate(25);

        return view('welcome', compact('comments'));
    }

    public function create(Request $request)
    {
        $parentId = $request->input('parent_id');
        $parentComment = Comment::find($parentId);

        $comment = new Comment;
        return view ('comments.create', compact('comment', 'parentComment'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'user_name' => 'required|string|min:2|max:256',
            'email' => 'required|email|string|max:256',
            'home_page' => 'nullable|string|url|max:256',
            'text' => 'required|string|min:2|max:2000',
            'parent_id' => 'nullable|numeric',
            'captcha' => 'required|captcha',
        ]);

        $parentId = $request->input('parent_id');

// TODO: add DB::transaction
        try {
            DB::transaction(function () use ($request, $parentId) {
                $comment = Comment::create([
                    'user_name' => $request->input('user_name'),
                    'email' => $request->input('email'),
                    'home_page' => $request->input('home_page'),
                    'parent_id' => $parentId,
                ]);

                Text::create([
                    'text' => $request->input('text'),
                    'comment_id' => $comment->id,
                ]);
            });

        } catch (\Throwable $e) {
            $e->getMessage();
            dd($e);
        }

        return redirect(route('comments.index'));
    }

    public function getReplies($parentId)
    {
        $replies = Comment::with(['text'])->where('parent_id', $parentId)->get();

        return view('comments.replies', compact('replies'));
    }


}

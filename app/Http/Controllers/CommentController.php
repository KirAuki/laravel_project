<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function store(Article $article) {
        $comment = new Comment;
        $comment->desc = request() -> get("comment");
        $comment->author_id = Auth::id();
        $comment->article_id = $article->id;
        $comment->save();
        return view("articles.article", compact("article"));
    }

    public function update(Article $article, Comment $comment) {
        $article = Article::find($comment->article_id);
        $comment->author_id = 1;
        $comment->desc = request() -> get("desc");
        $comment->save();
        return view("articles.article", compact("article"));
    }

    public function edit(Article $article, Comment $comment) {
        Gate::authorize('comment', $comment);
        return view('articles.edit_comment', compact('comment'));
    }

    public function destroy(Article $article, Comment $comment) {
        Gate::authorize('comment', $comment);
        $comment->delete();
        return view("articles.article", compact("article"));
    }
}

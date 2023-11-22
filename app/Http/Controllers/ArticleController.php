<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Jobs\ArticleMailJob;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::simplePaginate(10);
        return view('articles.articles_main', ['articles' => $articles]);
    }

    public function store()
    {
        request() -> validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);

        $article = new Article;
        $article->title = request()->title;
        $article->desc = request()->desc;
        $article->author_id = 1;
        $article->save();
        ArticleMailJob::dispatch($article);

        return redirect()->route('articles');
    }

    public function show(Article $article)
    {
        return view("articles.article", compact("article"));
    }

    public function edit(Article $article)
    {
        Gate::authorize('update', [self::class, $article]);
        return view("articles.edit", compact("article"));
    }

    public function update(Article $article)
    {
        request() -> validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);
        $article->title = request() -> get('title', '');
        $article->desc = request() -> get('desc', '');
        $article->author_id = 1;
        $article->save();
        return redirect()->route('articles');
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', [self::class, $article]);
        
        $article->delete();

        return redirect()->route('articles');
    }
}
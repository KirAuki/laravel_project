<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Comment;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::simplePaginate(10);
        return view('articles.articles_main', ['articles' => $articles]);
    }

    public function store()
    {
        $data = request() -> validate([
            'title' => 'required|string|max:255',
            'desc' => 'required|string',
        ]);

        Article::create($data);

        return redirect()->route('articles');
    }

    public function show(Article $article)
    {
        return view("articles.article", compact("article"));
    }

    public function edit(Article $article)
    {
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
        $article->save();
        return redirect()->route('articles');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return redirect()->route('articles');
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Jobs\ArticleMailJob;
use App\Events\EventNewComment;

class ArticleController extends Controller
{
    public function index()
    {
        $page = isset($_GET['page']) ? $_GET['page']: 0;
        $articles = Cache::remember('articles'.$page, 3000, function(){
            return Article::latest()->paginate(5);
        });
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
        $res = $article->save();
        if ($res){
            ArticleMailJob::dispatch($article);
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }            
        }

        return redirect()->route('articles');
    }

    public function show(Article $article)
    {
        if (isset($_GET['notify'])){
            auth()->user()->notifications->where('id', $_GET['notify'])->first()->markAsRead();
        }
        $page = isset($_GET['page']) ? ($_GET['page']) : 0;
        $comments = Cache::rememberForever($article->id.'/comments'.$page,function()use($article){
            return Comment::where('article_id', $article->id)
                            ->where('accept', 1)
                            ->latest()->paginate(2);
        });
        
        return view('articles.article', ['article'=>$article, 'comments'=>$comments]);
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
        $article->author_id = Auth::id();
        $res = $article->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article->id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        return redirect()->route('articles');
    }

    public function destroy(Article $article)
    {
        Gate::authorize('delete', [self::class, $article]);
        
        $res = $article->delete();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article->id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'articles*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }

        return redirect()->route('articles');
    }
}
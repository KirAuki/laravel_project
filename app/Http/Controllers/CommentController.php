<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NotifyNewComment;
use App\Mail\AdminComment;
use App\Events\EventNewComment;


class CommentController extends Controller
{
    public function index(){
        Gate::authorize('admincomment');
        $page = isset($_GET['page']) ? $_GET['page']: 0;
        $data = Cache::rememberForever('comments'.$page, function (){
            $comments = Comment::latest()->paginate(10);
            $articles = Article::all();
            return [
                'comments'=>$comments,
                'articles'=>$articles,
            ];
        });  
        return view('comments.index', ['comments'=>$data['comments'], 'articles'=>$data['articles']]);
    }

    public function accept(Comment $comment){
        Gate::authorize('admincomment');
        $comment = Comment::findOrFail($comment->id);
        $article = Article::findOrFail($comment->article_id);
        $comment->accept = true;
        $res = $comment->save();
        if ($res) {
            EventNewComment::dispatch($article);
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article->id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }  
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }  
        }
        return redirect()->route('comments');
    }

    public function reject(Comment $comment){
        Gate::authorize('admincomment');
        $comment = Comment::findOrFail($comment->id);
        $comment->accept = false;
        $res = $comment->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$comment->article_id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        return redirect()->route('comments');
    }

    public function store(Article $article) {
        $article = Article::findOrFail($article->id);
        $users = User::where('id', '!=', auth()->id())->get();
        $comment = new Comment;
        $comment->desc = request() -> get("comment");
        $comment->author_id = Auth::id();
        $comment->article_id = $article->id;
        $res = $comment->save();
        if ($res) {

            Mail::to('kirill.akulov.04@mail.ru')->send(new AdminComment($article->title, $comment->desc));
            Notification::send($users, new NotifyNewComment($article));
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        return redirect()->route("articles.show", ['article'=>$article, 'res'=>$res]);
        
    }

    public function update(Article $article, Comment $comment) {
        $article = Article::find($comment->article_id);
        $comment->author_id = Auth::id();
        $comment->desc = request() -> get("desc");
        $res = $comment->save();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$request->article_id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        return redirect()->route("articles.show", compact("article"));
    }

    public function edit(Article $article, Comment $comment) {
        Gate::authorize('comment', $comment);
        return view('comments.edit_comment', compact('comment'));
    }

    public function destroy(Comment $comment) {
        Gate::authorize('comment', $comment);
        $article = Article::find($comment->article_id);
        $res = $comment->delete();
        if ($res){
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>$article_id.'/comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
            $keys = DB::table('cache')->whereRaw('`key` GLOB :key', [':key'=>'comments*[0-9]'])->get();
            foreach($keys as $key){
                Cache::forget($key->key);
            }
        }
        return redirect()->route("articles.show", compact("article"));
    }
}

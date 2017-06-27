<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Post;

class PostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(request $request)
    {
        $userId = Auth::id();
        $post = new Post;
        $post->body = $request->text;
        if (!isset($request->section))
        {
            $post->section_id = $request->section_id;
        } else {
            $post->section_id = $request->section;
        }
        $post->user_id = $userId;
        $post->save();
        return 'Done';
    }

    public function delete(request $request)
    {
        $post = Post::find($request->id)
        if ($post->user_id == $userId)
        {
            Post::where('id', $request->id)->delete();
        }
        return $request->all();
    }

    public function update(request $request)
    {
        $userId = Auth::id();
        $post = Post::find($request->id);
        if ($post->user_id == $userId)
        {
            $post->body = $request->value;
            $post->user_id = $userId;
            $post->save();
        }
        return $request->all();
    }

    public function search(request $request)
    {
        $term = $request->term;
        $posts = Post::where('body','LIKE','%'.$term.'%')->get();
        if (count($posts) == 0)
        {
            $searchResult[] = 'No Item Found';
        }else{
            foreach ($posts as $key => $value) {
                $searchResult[] = $value->body;
            }
        }

        return $searchResult;
    }

    public function upload(request $request)
    {
        return view('home');
    }
}

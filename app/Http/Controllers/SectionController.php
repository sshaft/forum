<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Section;
use App\Section_role;

class SectionController extends Controller
{
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
            $post->section_id = 0;
        } else {
            $post->section_id = $request->section;
        }
        $post->user_id = $userId;
        $post->save();
        return 'Done';
    }

    public function delete(request $request)
    {
        Post::where('id', $request->id)->delete();
        return $request->all();
    }

    public function update(request $request)
    {
        $userId = Auth::id();
        $post = Post::find($request->id);
        $post->body = $request->value;
        $post->user_id = $userId;
        $post->save();
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

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Section;
use App\Section_role;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;;
use App\Post;
use App\User;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create(request $request)
    {
        $userId = Auth::id();
        $section = new Section;
        $section->name = $request->name;
        $section->ID_owner = $userId;
        $section->save();
        $role = new Section_role;
        $role->section_id = $section->id;
        $role->user_id = $userId;
        $role->role_level = 0;
        $role->save();
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

    }

    public function index($id)
    {
      $a = false;
      $idu = Auth::user()->id;
      $role = DB::table('section_roles')
                        ->where('section_id', '=', $id)
                        ->where('user_id', '=', $idu)
                        ->get();
      foreach ($role as $rol) {
        $posts = DB::table('posts')
                          ->join('users', 'posts.user_id', '=', 'users.id')
                          ->where('posts.section_id', '=', $id)
                          ->select('posts.*', 'users.name')
                          ->orderBy('created_at', 'desc')
                          ->get();
        $sections = DB::table('sections')
                          ->join('section_roles', 'section_roles.section_id', '=', 'sections.id')
                          ->where('section_roles.user_id', '=', $idu)
                          ->select('sections.*')
                          ->orderBy('created_at', 'desc')
                          ->get();
        return view('section', compact('posts', 'sections', 'id'));
      }
    return redirect('home');
    }

}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;;
use App\Post;
use App\User;


class PageController extends Controller
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

    public function index()
    {
      $posts = DB::table('posts')
                        ->join('users', 'posts.user_id', '=', 'users.id')
                        ->select('posts.*', 'users.name')
                        ->get();
      $sections = DB::table('sections')
                        ->where('ID_owner', '=', Auth::user()->id)
                        ->select('sections.*')
                        ->get();
      return view('home', compact('posts', 'sections'));
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $posts = DB::table('posts')
                        ->where('user_id', '=', $id)
                        ->select('posts.*')
                        ->get();
        $filename = 'public/' . $id . '.jpeg';
        $url = Storage::url($filename);
        return view('profile', compact('posts', 'url'));
    }
}

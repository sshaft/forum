<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
                        ->select('posts.*', 'users.id', 'users.name')
                        ->get();
      $sections = DB::table('sections')->get();
      return view('home', compact('posts', 'sections'));
    }

    public function profile()
    {
      $posts = DB::table('posts')
                        ->where('user_id', '=', Auth::user()->id)
                        ->select('posts.*')
                        ->get();
        return view('profile', compact('posts'));
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
      $id = Auth::user()->id;
      $user = User::find($id);
      $url = '/storage/users/' . $id . '.jpeg';
      //return $url;
      return view('settings', compact('user', 'url'));
    }
}

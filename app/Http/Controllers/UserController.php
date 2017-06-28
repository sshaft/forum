<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
        $url = 'storage/users/' . $id . '.jpeg';
        return view('settings', compact('user', 'url'));
    }

    public function name(request $request){
        $userId = Auth::id();
        $user = User::find($userId);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();
        return $request->all();
    }

    public function password(){
        return view('auth.changepassword');
    }

    public function changepassword(request $request){
        $user = User::find(Auth::user()->id);
        if(Hash::check($request->password_old, $user['password'])){

            $user->password = bcrypt($request->password_new);
            $user->save();
            return redirect('/settings');
        }else{
          return back()->with('error', 'Password NOT Changed!');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Post;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function profile(request $request)
    {
        $request->file('image');
        if ($request->hasFile('image')) {
            $request->file('image');
            //return $request->image->path();
            //return $request->image->extension();
            $userId = Auth::id();
            $id = $userId . ".jpeg";
            $request->image->storeAs('public/users', $id);
            return $request->all();
            //return Storage::putFile('public', $request->file('image'));
        }else{
            return 'No file Selected';
        }
    }

    public function add(request $request)
    {
        //
    }

    public function delete(request $request)
    {
        $userId = Auth::id();
        $p = Post::find($request->id_image);
        if($p->user_id == $userId)
        {
            if(Storage::delete('/public/posts/' . $request->id_image . '.jpeg')){
                return 'Deleted';
            }return 'error2';
        }else{
            return 'error';
        }
        //return $request->id_image;
    }

    public function posts(request $request)
    {
        /*$request->file('image');
        if ($request->hasFile('image')) {
            $request->file('image');
            $id = $request->post_id . ".jpeg";
            $request->image->storeAs('public/posts', $id);
            return $request->all();
        }else{
            return 'No file Selected';
        }*/
        return $request;
    }

    public function show()
    {
        //return Storage::files('public');
        /*if(Storage::delete('public/image.jpeg')){
            return 'Deleted';
        }*/
        //return Storage::makeDirectory('public/make');
        /*if(Storage::deleteDirectory('public/make')){
            return 'Deleted';
        }*/
        //$url = Storage::url('filename.jpeg');
        //return "<img src='" . $url . "' />";
        //Storage::size('public/filename.jpeg');
        //Storage::lastModiefied('public/filename.jpeg');
        //Storage::copy('public/filename.jpeg', 'filename.jpeg');
        //Storage::move('public/filename.jpeg', 'filename.jpeg');
    }
}

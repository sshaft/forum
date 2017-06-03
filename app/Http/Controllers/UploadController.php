<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function upload(request $request)
    {
        $request->file('image');
        if ($request->hasFile('image')) {
            $request->file('image');
            //return $request->image->path();
            //return $request->image->extension();
            return $request->image->storeAs('public', 'filename.jpeg');
            //return Storage::putFile('public', $request->file('image'));
        }else{
            return 'No file Selected';
        }
    }
    public function show()
    {
        //return Storage::files('public');
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

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
            return Storage::putFile('public', $request->file('image'));
        }else{
            return 'No file Selected';
        }
    }
}

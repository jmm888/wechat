<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
   public function upload()
   {
       return view('wechat.upload');
   }
   public function upload_do(Request $request)
   {
       $images=request()->file('images');
       // dd($images);
       $name='images';
       if(request()->hasFile($name) && request()->file($name)->isValid()){
           $photo = request()->file($name)->store('');
           dd($photo);
       }
   }
}

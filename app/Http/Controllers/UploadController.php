<?php

namespace App\Http\Controllers;

use Illuminate\Http\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use URL;

class UploadController extends Controller
{
    public function profile()
    {
        return 'this is a test';
    }

    // if(Input::file())
     //    {
     //        $is_propic = true;
     //        $image = Input::file('pic');
     //        if(!isset($image)){
     //         $is_propic = false;
     //         $image = Input::file('cover');
     //        }
     //     //    $filename  = time() . '.' . $image->getClientOriginalExtension();
     //     //    $path = 'uploads';
     //    	// $image->move($path, $filename);//sucessfully moves file to public...
     //     $name = $image->store('imgs','s3');
     //    	$user = Auth::user();
     //    	if($is_propic)$user->propic = Storage::disk('s3')->url($name);
     //      else $user->cover = Storage::disk('s3')->url($name);
     //    	$user->save();
     //     }
}

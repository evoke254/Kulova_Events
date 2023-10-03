<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadImagesController extends Controller
{

    public function upload(Request $request){
//This function bypasses

        $token = $request->session()->token();
        $gb_token = csrf_token();

        if ($token == $gb_token){
            $baseUrl = url('/');
            $path = $request->file('file')->store('images/tinyUpload', 'public');
            return response()->json([
                'location' => $baseUrl.'/storage/'.$path
            ]);

        }

    }

}

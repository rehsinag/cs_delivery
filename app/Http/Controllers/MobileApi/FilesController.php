<?php

namespace App\Http\Controllers\MobileApi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class FilesController extends Controller
{
    public function upload(Request $request)
    {
//        mail('gabdullayev@crystalspring.kz', 'test', 'test', '');
        var_dump($request->all());
        $data = Input::all();
        file_put_contents('test111.txt', print_r($data, true), FILE_APPEND);
        var_dump(Input::all());
    }
}

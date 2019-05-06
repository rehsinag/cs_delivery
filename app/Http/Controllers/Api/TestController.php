<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestController extends Controller
{
    public function index()
    {
        echo 'test';

//        \Config::set('auth.providers.users.model', \App\DeliveryUser::class);
//        $user = JWTAuth::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEsImlzcyI6Imh0dHA6Ly9kZWxpdmVyeS5sb2NhbC9zcGQvYXBpL2F1dGgvbG9naW4iLCJpYXQiOjE1NTcxMzg0NjEsImV4cCI6MTU1NzE0MjA2MSwibmJmIjoxNTU3MTM4NDYxLCJqdGkiOiJzaFhVS1NOME9NdVV6MnFoIn0.q0xlXjLXWmgoDMljlOmFTaZeYI7e1SxvGVput2_XaqY')->authenticate();
//        var_dump($user->lastName);
    }
}

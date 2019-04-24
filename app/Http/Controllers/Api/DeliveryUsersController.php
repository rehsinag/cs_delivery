<?php

namespace App\Http\Controllers\Api;

use App\DeliveryUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DeliveryUsersController extends Controller
{
    public function login()
    {
        $login = Input::get('login');
        $password = Input::get('password');

        if($login && $password)
        {
            $deliveryUser = DeliveryUser::where('login', $login)->first();

            if($deliveryUser)
            {
                if(password_verify($password, $deliveryUser->password))
                {
                    echo 'good!';
                }
                else
                {
                    echo 'nope!';
                }
            }
            else
            {
                var_dump(123);
            }
        }
        else
        {
            var_dump(456);
        }
    }
}

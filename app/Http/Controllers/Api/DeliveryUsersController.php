<?php

namespace App\Http\Controllers\Api;

use App\DeliveryUser;
use App\UserByBranch;
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
                    return response()->json([
                        'success' => true,
                        'message' => [
                            'branchId' => $deliveryUser->branchId
                        ]
                    ]);
                }
                else
                {
                    return 'false';
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

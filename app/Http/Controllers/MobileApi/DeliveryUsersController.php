<?php

namespace App\Http\Controllers\MobileApi;

use App\DeliveryUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Facades\JWTAuth;

class DeliveryUsersController extends Controller
{
    public function login(Request $request)
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
                    $token = JWTAuth::fromUser($deliveryUser);
                    return response()->json([
                        'login' => $deliveryUser->login,
                        'token' => $token,
                        'display_name' => $deliveryUser->lastName . ' ' . $deliveryUser->firstName
                    ]);
                }
                else
                {
                    return response()->json([
                        'error_code' => '-100',
                        'error_message' => 'Не правильный логин или пароль.'
                    ])->setStatusCode(401);
                }
            }
            else
            {
                return response()->json([
                    'error_code' => '-100',
                    'error_message' => 'Не правильный логин или пароль.'
                ])->setStatusCode(401);
            }
        }
        else
        {
            return response()->json([
                'error_code' => '-103',
                'error_message' => 'Заполните имя и пароль пользователя.'
            ])->setStatusCode(401);
        }
    }

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response('', 200);
    }

    public function changePassword(Request $request)
    {
        $oldPassword = Input::get('old_password');
        $newPassword = Input::get('new_password');
        $confirmPassword = Input::get('confirm_password');
        \Config::set('auth.providers.users.model', \App\DeliveryUser::class);

        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404)->setStatusCode(401);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());
        }

        if(!$oldPassword)
        {
            return response()->json([
                'error_code' => '-106',
                'error_message' => 'Старый пароль пустой.'
            ])->setStatusCode(411);
        }
        if(!$newPassword)
        {
            return response()->json([
                'error_code' => '-106',
                'error_message' => 'Пароль должен быть больше 8 символов'
            ])->setStatusCode(411);
        }
        if($newPassword && strlen($newPassword) < 8)
        {
            return response()->json([
                'error_code' => '-106',
                'error_message' => 'Пароль должен быть больше 8 символов'
            ])->setStatusCode(411);
        }
        if($newPassword != $confirmPassword)
        {
            return response()->json([
                'error_code' => '-107',
                'error_message' => 'Подтверждение пароля не совпадает'
            ])->setStatusCode(412);
        }
        if(!password_verify($oldPassword, $user->password))
        {
            return response()->json([
                'error_code' => '-108',
                'error_message' => 'Не прошла валидация старого пароля'
            ])->setStatusCode(412);
        }

        $user->password = bcrypt($newPassword);
        if($user->save())
        {
            return response()->json([
                'message' => 'Пароль успешно изменен',
            ])->setStatusCode(200);
        }
    }
}

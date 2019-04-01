<?php

namespace App\Http\Controllers\Web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class AdminUsersController extends Controller
{
    public function index()
    {
        return view('adminUsers.index');
    }

    public function pList()
    {
        $params = Input::all();

        $adminUsers = User::all();

//        if(count($adminUsers))
//        {
//            foreach ($deliveryUsers as $deliveryUser)
//            {
//                $deliveryUser->init();
//            }
//        }

        return view('adminUsers.list', [
            'adminUsers' => $adminUsers
        ]);
    }

    public function editForm()
    {
        $adminUserId = Input::get('adminUserId');

        $adminUser = new User();
        if($adminUserId)
        {
            $adminUser = User::find($adminUserId);
        }

//        $deliveryCompanies = DeliveryCompany::getCollection(['actual' => 1])->get();
//
//        $branches = Branch::getCollection(['actual' => 1])->get();

        return view('adminUsers.edit', [
            'adminUser' => $adminUser,
//            'deliveryCompanies' => $deliveryCompanies,
//            'branches' => $branches
        ]);
    }

    public function submitForm()
    {
        $adminUserData = Input::all();

        $successMessage = $adminUserData['id'] ? 'Данные пользователя были успешно обновлены.' : 'Пользователь был успешно добавлен.';

        $adminUser = new User();

        $adminUser->setDataFromArray($adminUserData);

        $errors = $adminUser->validateData();

        if(!$errors)
        {
            if($adminUser->submitData())
            {
                return response()->json([
                    'success' => true,
                    'message' => $successMessage
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => $errors[0]
            ]);
        }
    }

    public function delete()
    {
        $adminUserId = Input::get('adminUserId');

        if($adminUserId)
        {
            $adminUser = User::find($adminUserId);
            if($adminUser)
            {
//                $deliveryUser->status = Status::DELETED;

                if($adminUser->delete())
                {
                    return response()->json([
                        'success' => true,
                        'message' => 'Пользователь был успешно удален.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка! Произошла ошибка при удалении пользователя.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка! Не найден пользователь с указанным идентификатором.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка! Не передан идентификатор пользователя.'
            ]);
        }
    }
}

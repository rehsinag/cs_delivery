<?php

namespace App\Http\Controllers\Web;

use App\Branch;
use App\BranchCatalog;
use App\DeliveryCompany;
use App\DeliveryUser;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DeliveryUsersController extends Controller
{
    public function index()
    {
        return view('deliveryUsers.index');
    }

    public function pList()
    {
        $params = Input::all();

        $deliveryUsers = DeliveryUser::getCollection($params)->get();

        if(count($deliveryUsers))
        {
            foreach ($deliveryUsers as $deliveryUser)
            {
                $deliveryUser->init();
            }
        }

        return view('deliveryUsers.list', [
            'deliveryUsers' => $deliveryUsers
        ]);
    }

    public function editForm()
    {
        $deliveryUserId = Input::get('deliveryUserId');

        $deliveryUser = new DeliveryUser();
        if($deliveryUserId)
        {
            $deliveryUser = DeliveryUser::find($deliveryUserId);
        }

        $deliveryCompanies = DeliveryCompany::getCollection(['actual' => 1])->get();

        $branches = BranchCatalog::getCollection(['actual' => 1])->get();

        return view('deliveryUsers.edit', [
            'deliveryUser' => $deliveryUser,
            'deliveryCompanies' => $deliveryCompanies,
            'branches' => $branches
        ]);
    }

    public function submitForm()
    {
        $deliveryUserData = Input::all();

        $successMessage = $deliveryUserData['id'] ? 'Данные курьера были успешно обновлены.' : 'Курьер был успешно добавлен.';

        $deliveryUser = new DeliveryUser();

        $deliveryUser->setDataFromArray($deliveryUserData);

        $errors = $deliveryUser->validateData();

        if(!$errors)
        {
            if($deliveryUser->submitData())
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
        $deliveryUserId = Input::get('deliveryUserId');

        if($deliveryUserId)
        {
            $deliveryUser = DeliveryUser::find($deliveryUserId);
            if($deliveryUser)
            {
                $deliveryUser->status = Status::DELETED;

                if($deliveryUser->save())
                {
                    return response()->json([
                        'success' => true,
                        'message' => 'Курьер был успешно удален.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка! Произошла ошибка при удалении курьера.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка! Не найден курьер с указанным идентификатором.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка! Не передан идентификатор курьера.'
            ]);
        }
    }
}

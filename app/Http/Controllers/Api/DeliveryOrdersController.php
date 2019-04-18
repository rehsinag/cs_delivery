<?php

namespace App\Http\Controllers\Api;

use App\DeliveryOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DeliveryOrdersController extends Controller
{
    public function index()
    {
        return response()->json([
            'status' => 200,
            'data' => [
                'message' => 'Hello, World!'
            ]
        ]);
    }

    public function submitForm()
    {
        $deliveryOrderData = Input::all();

        $successMessage = isset($deliveryOrderData['id']) ? 'Данные заявки были успешно обновлены.' : 'Заявка была успешно добавлена.';

        $deliveryOrder = new DeliveryOrder();

        $deliveryOrder->setDataFromArray($deliveryOrderData);

        $errors = $deliveryOrder->validateData();

        if(!$errors)
        {
            if($deliveryOrder->submitData())
            {
                return response()->json([
                    'success' => true,
                    'status' => 200,
                    'message' => $successMessage
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => $errors[0]
            ]);
        }
    }
}

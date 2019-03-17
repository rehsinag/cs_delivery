<?php

namespace App\Http\Controllers\Web;

use App\DeliveryCompany;
use App\Status;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DeliveryCompaniesController extends Controller
{
    public function index()
    {
        return view('deliveryCompanies.index');
    }

    public function pList()
    {
        $params = Input::all();

        $deliveryCompanies = DeliveryCompany::getCollection($params)->get();

        return view('deliveryCompanies.list', [
            'deliveryCompanies' => $deliveryCompanies
        ]);
    }

    public function editForm()
    {
        $deliveryCompanyId = Input::get('deliveryCompanyId');

        $deliveryCompany = new DeliveryCompany();
        if($deliveryCompanyId)
        {
            $deliveryCompany = DeliveryCompany::find($deliveryCompanyId);
        }

        return view('deliveryCompanies.edit', [
            'deliveryCompany' => $deliveryCompany,
        ]);
    }

    public function submitForm()
    {
        $deliveryCompanyData = Input::all();

        $successMessage = $deliveryCompanyData['id'] ? 'Курьерская компания была успешно обновлена.' : 'Курьерская компания была успешно добавлена.';

        $deliveryCompany = new DeliveryCompany();

        $deliveryCompany->setDataFromArray($deliveryCompanyData);

        $errors = $deliveryCompany->validateData();

        if(!$errors)
        {
            if($deliveryCompany->submitData())
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
        $deliveryCompanyId = Input::get('deliveryCompanyId');

        if($deliveryCompanyId)
        {
            $deliveryCompany = DeliveryCompany::find($deliveryCompanyId);
            if($deliveryCompany)
            {
                $deliveryCompany->status = Status::DELETED;

                if($deliveryCompany->save())
                {
                    return response()->json([
                        'success' => true,
                        'message' => 'Курьерская компания была успешно удалена.'
                    ]);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'message' => 'Ошибка! Произошла ошибка при удалении курьерской компании.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Ошибка! Не найдена курьерская компания с указанным идентификатором.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => 'Ошибка! Не передан идентификатор курьерской компании.'
            ]);
        }
    }
}

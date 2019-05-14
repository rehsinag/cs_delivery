<?php

namespace App\Http\Controllers\MobileApi;

use App\CityCatalog;
use App\CountyCatalog;
use App\DeliveryOrder;
use App\DeliveryUserComment;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Tymon\JWTAuth\Facades\JWTAuth;

class DeliveryOrdersController extends Controller
{
    public function list1()
    {
        $status = Input::get('status');

        if($status)
        {
            $statusCode = 0;
            switch ($status)
            {
                case 'PROCESS':
                    $statusCode = Status::PROCESS;
                    break;
                case 'DELIVERED':
                    $statusCode = Status::DELIVERED;
                    break;
                default:
                    break;
            }

            $deliveryOrders = DeliveryOrder::getCollection(['status' => $statusCode])->get();

            if(count($deliveryOrders))
            {
                $data = [];

                foreach ($deliveryOrders as $deliveryOrder)
                {
                    $deliveryOrder->initProduct();
                    $deliveryOrder->initCity();
                    $deliveryOrder->initCounty();

                    $data[] = [
                        'id' => $deliveryOrder->id,
                        'insert_date' => Carbon::parse($deliveryOrder->created_at)->format('d.m.Y H:i'),
                        'status_changed_date' => '',
                        'request_id' => strval($deliveryOrder->requestId),
                        'last_name' => $deliveryOrder->lastName,
                        'first_name' => $deliveryOrder->firstName,
                        'middle_name' => $deliveryOrder->middleName,
                        'iin' => $deliveryOrder->iin,
                        'phone' => $deliveryOrder->phone,
                        'county' => $deliveryOrder->countyObj->displayName,
                        'county_code' => $deliveryOrder->countyObj->code,
                        'city' => $deliveryOrder->cityObj->displayName,
                        'city_code' => $deliveryOrder->cityObj->code,
                        'street' => $deliveryOrder->street,
                        'house' => $deliveryOrder->house,
                        'apartment' => $deliveryOrder->apartment,
                        'product_type' => $deliveryOrder->productObj->code,
                        'product_name' => $deliveryOrder->productObj->displayName,
                        'status' => Status::code($deliveryOrder->status)->slug,
                        'sid' => [],
                        'delivery_date' => '',
                        'manager_comment' => ($deliveryOrder->comments) ? $deliveryOrder->comments : "",
                        'check_visual' => '',
                        'delivery_time' => '',
                    ];
                }

                return response()->json($data)->setStatusCode(200);
            }
            else
            {
                return '[]';
            }
        }
        else
        {
            return response()->json([
                'error_code' => '-200',
                'error_message' => 'Произошла ошибка во время получения заявок'
            ])->setStatusCode(400);
        }
    }

    public function item()
    {
        $id = Input::get('id');

        if($id)
        {
            $deliveryOrder = DeliveryOrder::find($id);

            if($deliveryOrder)
            {
                $deliveryOrder->initProduct();
                $deliveryOrder->initCity();
                $deliveryOrder->initCounty();

                return response()->json([
                    'id' => $deliveryOrder->id,
                    'insert_date' => Carbon::parse($deliveryOrder->created_at)->format('d.m.Y H:i'),
                    'status_changed_date' => '',
                    'request_id' => strval($deliveryOrder->requestId),
                    'last_name' => $deliveryOrder->lastName,
                    'first_name' => $deliveryOrder->firstName,
                    'middle_name' => $deliveryOrder->middleName,
                    'iin' => $deliveryOrder->iin,
                    'phone' => $deliveryOrder->phone,
                    'county' => $deliveryOrder->countyObj->displayName,
                    'county_code' => $deliveryOrder->countyObj->code,
                    'city' => $deliveryOrder->cityObj->displayName,
                    'city_code' => $deliveryOrder->cityObj->code,
                    'street' => $deliveryOrder->street,
                    'house' => $deliveryOrder->house,
                    'apartment' => $deliveryOrder->apartment,
                    'product_type' => $deliveryOrder->productObj->code,
                    'product_name' => $deliveryOrder->productObj->displayName,
                    'status' => Status::code($deliveryOrder->status)->slug,
                    'sid' => [],
                    'delivery_date' => '',
                    'manager_comment' => ($deliveryOrder->comments) ? $deliveryOrder->comments : "",
                    'check_visual' => '',
                    'delivery_time' => '',
                ])->setStatusCode(200);
            }
        }
    }

    public function address()
    {
        $requestId = Input::get('request_id');
        $county = Input::get('county');
        $region = Input::get('region');
        $city = Input::get('city');
        $street = Input::get('street');
        $house = Input::get('house');
        $apartment = Input::get('apartment');

        if($requestId)
        {
            $deliveryOrder = DeliveryOrder::getCollection(['requestIdIn' => $requestId])->first();

            if($deliveryOrder)
            {
                $deliveryOrder->county = ($county) ? $county : $deliveryOrder->county;
                $deliveryOrder->region = ($region) ? $region : $deliveryOrder->region;
                $deliveryOrder->city = ($city) ? $city : $deliveryOrder->city;
                $deliveryOrder->street = ($street) ? $street : $deliveryOrder->street;
                $deliveryOrder->house = ($house) ? $house : $deliveryOrder->house;
                $deliveryOrder->apartment = ($apartment) ? $apartment : $deliveryOrder->apartment;

                if($deliveryOrder->save())
                {
                    return response()->json([
                        'message' => 'Успешно'
                    ])->setStatusCode(200);
                }
            }
            else
            {
                return response()->json([
                    'error_code' => '-109',
                    'error_message' => 'Не найдена заявка с таким номером'
                ])->setStatusCode(401);
            }
        }
        else
        {
            return response()->json([
                'error_code' => '-109',
                'error_message' => 'Не найдена заявка с таким номером'
            ])->setStatusCode(401);
        }
    }

    public function comments()
    {
        $requestId = Input::get('request_id');

        if($requestId)
        {
            $deliveryUserComments = DeliveryUserComment::getCollection(['requestIdIn' => $requestId, 'orderBy' => 'created_at'])->get();

            if(count($deliveryUserComments))
            {
                $output = [];

                foreach ($deliveryUserComments as $deliveryUserComment)
                {
                    $deliveryUserComment->initDeliveryUser();

                    $output[] = [
                        'create_date' => Carbon::parse($deliveryUserComment->created_at)->format('d.m.Y H:i:s'),
                        'request_id' => strval($deliveryUserComment->requestId),
                        'owner' => strtoupper($deliveryUserComment->deliveryUser->login),
                        'text' => $deliveryUserComment->text
                    ];
                }

                return response()->json($output)->setStatusCode(200);
            }
            else
            {
                return '[]';
            }
        }
        else
        {
            return '[]';
        }
    }

    public function comment()
    {
        $requestId = Input::get('request_id');
        $text = (Input::get('text')) ? Input::get('text') : "";

        if($requestId)
        {
            $deliveryOrder = DeliveryOrder::getCollection(['requestIdIn' => $requestId])->first();

            if($deliveryOrder)
            {
                \Config::set('auth.providers.users.model', \App\DeliveryUser::class);
                $user = JWTAuth::parseToken()->authenticate();

                $deliveryUserComment = new DeliveryUserComment();
                $deliveryUserComment->requestId = $requestId;
                $deliveryUserComment->deliveryUserId = $user->id;
                $deliveryUserComment->text = $text;

                if($deliveryUserComment->save())
                {
                    $deliveryUserComments = DeliveryUserComment::getCollection(['requestIdIn' => $requestId, 'orderBy' => 'created_at'])->get();

                    if(count($deliveryUserComments))
                    {
                        $output = [];

                        foreach ($deliveryUserComments as $deliveryUserComment)
                        {
                            $deliveryUserComment->initDeliveryUser();

                            $output[] = [
                                'create_date' => Carbon::parse($deliveryUserComment->created_at)->format('d.m.Y H:i:s'),
                                'request_id' => strval($deliveryUserComment->requestId),
                                'owner' => strtoupper($deliveryUserComment->deliveryUser->login),
                                'text' => $deliveryUserComment->text
                            ];
                        }

                        return response()->json($output)->setStatusCode(200);
                    }
                }
            }
            else
            {
                return response()->json([
                    'error_code' => '-109',
                    'error_message' => 'Не найдена заявка с таким номером'
                ])->setStatusCode(401);
            }
        }
        else
        {
            return response()->json([
                'error_code' => '-109',
                'error_message' => 'Не найдена заявка с таким номером'
            ])->setStatusCode(401);
        }
    }

    public function status()
    {
        $requestId = Input::get('request_id');
        $status = Input::get('status');

        if($requestId)
        {
            $deliveryOrder = DeliveryOrder::getCollection(['requestIdIn' => $requestId])->first();

            if($deliveryOrder)
            {
                $statusCode = 0;
                switch ($status)
                {
                    case 'PROCESS':
                        $statusCode = Status::PROCESS;
                        break;
                    case 'DELIVERED':
                        $statusCode = Status::DELIVERED;
                        break;
                    default:
                        break;
                }

                $deliveryOrder->status = $statusCode;

                if($deliveryOrder->save())
                {
                    return response()->json([
                        'item_key' => 500
                    ])->setStatusCode(200);
                }
            }
            else
            {
                return response()->json([
                    'error_code' => '-109',
                    'error_message' => 'Не найдена заявка с таким номером'
                ])->setStatusCode(503);
            }
        }
        else
        {
            return response()->json([
                'error_code' => '-109',
                'error_message' => 'Не найдена заявка с таким номером'
            ])->setStatusCode(503);
        }
    }

    public function counties()
    {
        $cityCode = Input::get('city_code');

        if($cityCode)
        {
            $city = CityCatalog::where('code', $cityCode)->first();

            if($city)
            {
                $counties = CountyCatalog::where('cityId', $city->id)->get();
                if(count($counties))
                {
                    $data = [];

                    foreach ($counties as $county)
                    {
                        $data[] = [
                            'code' => $county->code,
                            'name' => $county->displayName
                        ];
                    }

                    return response()->json($data)->setStatusCode(200);
                }
                else
                {
                    return '[]';
                }
            }
            else
            {
                return '[]';
            }
        }
        else
        {
            return '[]';
        }
    }
}

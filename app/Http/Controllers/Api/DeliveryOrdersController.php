<?php

namespace App\Http\Controllers\Api;

use App\DeliveryOrder;
use App\DeliveryOrderHistory;
use App\DeliveryOrderStatus;
use App\DeliveryUser;
use App\SpringDocStatus;
use App\Status;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
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

    public function create()
    {
        $deliveryOrderData = Input::all();

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
                    'message' => 'Заявка была успешно добавлена.'
                ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => $errors[0]
            ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function queueStatusComplete()
    {
        $orderID = Input::get('requestId');

        if($orderID)
        {
            $order = DeliveryOrder::where('requestId', $orderID)->first();

            if($order)
            {
                $order->sicStatus = 'A';

                if($order->save())
                {
                    return response()->json([
                        'success' => true,
                        'status' => 200,
                        'message' => 'Статус SIC был успешно изменен.'
                    ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Не найдена заявка с указанным идентификатором.'
                ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Не передан идентификатор заявки.'
            ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function getFiles()
    {
        $orderID = Input::get('requestId');

        if($orderID)
        {
            $order = DeliveryOrder::where('requestId', $orderID)->first();

            if($order)
            {
                $files = $order->getMedia('orderClientDocs');

                if(count($files))
                {
                    $output = [];
                    foreach ($files as $file)
                    {
//                        $path = public_path($file->getUrl());
                        $path = storage_path('clientDocs/' . $file->id . '/' . $file->file_name);
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
//                        $base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
                        $base64 = base64_encode($data);
                        $output[] = [
                            'type' => $file->getCustomProperty('type'),
                            'filename' => $file->file_name,
                            'mime' => $file->mime_type,
                            'content' => $base64
                        ];
                    }

                    return response()->json([
                        'success' => true,
                        'status' => 200,
                        'message' => [
                            'files' => $output
                        ]
                    ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
                }
                else
                {
                    return response()->json([
                        'success' => false,
                        'status' => 400,
                        'message' => 'Не найдены файлы заявки.'
                    ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Не найдена заявка с указанным идентификатором.'
                ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Не передан идентификатор заявки.'
            ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }

    }

    public function answerFile()
    {
        $data = Input::all();

        $test_array = array (
            'RqUID' => rand(1, 99999),
            'RqTm' => Carbon::now()->toDateTimeString(),
            'Data' => array (
                'orderNumber' => $data['requestId'],
//                'courierComments' => '0',
                'courierName' => '',
            ),
        );

        $order = DeliveryOrder::where('requestId', $data['requestId'])->first();

        $test_array['Data']['deliveryStatus'] = Status::code($order->status)->slug;

        $deliveryUser = DeliveryUser::find($order->deliveryUserId)->first();

        if($deliveryUser)
        {
            $test_array['Data']['courierName'] = $deliveryUser->lastName . ' ' . $deliveryUser->firstName . ' ' . $deliveryUser->middleName;
        }

        if(isset($data['photoSid']) && $data['photoSid'])
            $test_array['Data']['clientPhotoSid'] = $data['photoSid'];

        if(isset($data['passportSid']) && $data['passportSid'])
            $test_array['Data']['clientPassportSid'] = $data['passportSid'];

        if(isset($data['otherDocSid']) && $data['otherDocSid'])
            $test_array['Data']['clientOtherDocSid'] = $data['otherDocSid'];

        $xml = new \SimpleXMLElement('<DeliveryStatus/>');
        $xml->addAttribute('encoding', 'UTF-8');

        return $this->array_to_xml($test_array, $xml)->asXML();
    }

    public function bankStatus()
    {
        $requestId = Input::get('requestId');
        $comments = Input::get('comments');
        $status = Input::get('status');

        $deliveryOrder = DeliveryOrder::where('requestId', $requestId)->first();

        if($deliveryOrder && $status == SpringDocStatus::ACCEPT)
        {
            if($comments)
                $deliveryOrder->comments = $comments;
            if($status)
                $deliveryOrder->springDocStatus = $status;

            $deliveryOrder->save();

            $historyOrder = new DeliveryOrderHistory();
            $historyOrder->firstName = $deliveryOrder->firstName;
            $historyOrder->lastName = $deliveryOrder->lastName;
            $historyOrder->middleName = $deliveryOrder->middleName;
            $historyOrder->iin = $deliveryOrder->iin;
            $historyOrder->phone = $deliveryOrder->phone;
            $historyOrder->requestId = $deliveryOrder->requestId;
            $historyOrder->productId = $deliveryOrder->productId;
            $historyOrder->branchId = $deliveryOrder->branchId;
            $historyOrder->eventId = 0;
            $historyOrder->deliveryUserId = $deliveryOrder->deliveryUserId;
            $historyOrder->city = $deliveryOrder->city;
            $historyOrder->county = $deliveryOrder->county;
            $historyOrder->street = $deliveryOrder->street;
            $historyOrder->house = $deliveryOrder->house;
            $historyOrder->apartment = $deliveryOrder->apartment;
            $historyOrder->historyDate = Carbon::now()->toDateString();
            $historyOrder->deliveryDate = $deliveryOrder->deliveryDate;
            $historyOrder->statusDate = $deliveryOrder->statusDate;
            $historyOrder->comments = $deliveryOrder->comments;
            $historyOrder->status = $deliveryOrder->status;
            $historyOrder->sicStatus = $deliveryOrder->sicStatus;
            $historyOrder->springDocStatus = $deliveryOrder->springDocStatus;
            $historyOrder->save();

            $deliveryOrder->delete();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Успешно выполнено'
            ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }

        if($deliveryOrder && $status == SpringDocStatus::REWORK)
        {
            if($comments)
                $deliveryOrder->comments = $comments;
            if($status)
                $deliveryOrder->springDocStatus = $status;

            $deliveryOrder->save();

//            DB::insert('INSERT INTO deliveryOrdersHistory SELECT * FROM deliveryOrders WHERE requestId = ?', [$requestId]);
//
//            $deliveryOrder->delete();

            $historyOrder = new DeliveryOrderHistory();
            $historyOrder->firstName = $deliveryOrder->firstName;
            $historyOrder->lastName = $deliveryOrder->lastName;
            $historyOrder->middleName = $deliveryOrder->middleName;
            $historyOrder->iin = $deliveryOrder->iin;
            $historyOrder->phone = $deliveryOrder->phone;
            $historyOrder->requestId = $deliveryOrder->requestId;
            $historyOrder->productId = $deliveryOrder->productId;
            $historyOrder->branchId = $deliveryOrder->branchId;
            $historyOrder->eventId = 0;
            $historyOrder->deliveryUserId = $deliveryOrder->deliveryUserId;
            $historyOrder->city = $deliveryOrder->city;
            $historyOrder->county = $deliveryOrder->county;
            $historyOrder->street = $deliveryOrder->street;
            $historyOrder->house = $deliveryOrder->house;
            $historyOrder->apartment = $deliveryOrder->apartment;
            $historyOrder->historyDate = Carbon::now()->toDateString();
            $historyOrder->deliveryDate = $deliveryOrder->deliveryDate;
            $historyOrder->statusDate = $deliveryOrder->statusDate;
            $historyOrder->comments = $deliveryOrder->comments;
            $historyOrder->status = $deliveryOrder->status;
            $historyOrder->sicStatus = $deliveryOrder->sicStatus;
            $historyOrder->springDocStatus = $deliveryOrder->springDocStatus;
            $historyOrder->save();

            $deliveryOrder->delete();

            $historyOrder = DeliveryOrderHistory::where('requestId', $requestId)->first();
//            $historyOrder->historyDate = Carbon::now()->toDateString();
//            $historyOrder->save();
//
//            DB::insert('INSERT INTO deliveryOrders SELECT * FROM deliveryOrdersHistory WHERE requestId = ?', [$requestId]);

            $newDeliveryOrder = new DeliveryOrder();
            $newDeliveryOrder->firstName = $historyOrder->firstName;
            $newDeliveryOrder->lastName = $historyOrder->lastName;
            $newDeliveryOrder->middleName = $historyOrder->middleName;
            $newDeliveryOrder->iin = $historyOrder->iin;
            $newDeliveryOrder->phone = $historyOrder->phone;
            $newDeliveryOrder->requestId = $historyOrder->requestId;
            $newDeliveryOrder->productId = $historyOrder->productId;
            $newDeliveryOrder->branchId = $historyOrder->branchId;
            $newDeliveryOrder->city = $historyOrder->city;
            $newDeliveryOrder->county = $historyOrder->county;
            $newDeliveryOrder->street = $historyOrder->street;
            $newDeliveryOrder->house = $historyOrder->house;
            $newDeliveryOrder->apartment = $historyOrder->apartment;
            $newDeliveryOrder->deliveryDate = $historyOrder->deliveryDate;
            $newDeliveryOrder->comments = $historyOrder->comments;

//            $newDeliveryOrder = DeliveryOrder::where('requestId', $requestId)->first();
            $newDeliveryOrder->eventId = 0;
            $newDeliveryOrder->status = Status::REAPPLICATION;
            $newDeliveryOrder->springDocStatus = null;
            $newDeliveryOrder->sicStatus = 'N';
            $newDeliveryOrder->statusDate = null;
            $newDeliveryOrder->created_at = Carbon::now()->format('Y-m-d H:i:s');
            $newDeliveryOrder->updated_at = Carbon::now()->format('Y-m-d H:i:s');
            $newDeliveryOrder->save();

            return response()->json([
                'success' => true,
                'status' => 200,
                'message' => 'Успешно выполнено'
            ], 200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
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

    public function setSDStatusReceived()
    {
        $orderID = Input::get('orderID');

        if($orderID)
        {
            $order = DeliveryOrder::find($orderID);

            if($order)
            {
                $order->springDocStatus = DeliveryOrderStatus::RECEIVED;

                if($order->save())
                {
                    return response()->json([
                        'success' => false,
                        'status' => 200,
                        'message' => 'Статус заявки была успешно обновлена.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'status' => 500,
                    'message' => 'Не найдена заявка с указанным идентификатором.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Не передан идентификатор заявки.'
            ]);
        }
    }

    public function setSDStatusVerified()
    {
        $orderID = Input::get('orderID');

        if($orderID)
        {
            $order = DeliveryOrder::find($orderID);

            if($order)
            {
                $order->springDocStatus = DeliveryOrderStatus::VERIFIED;

                if($order->save())
                {
                    return response()->json([
                        'success' => false,
                        'status' => 200,
                        'message' => 'Статус заявки была успешно обновлена.'
                    ]);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'status' => 500,
                    'message' => 'Не найдена заявка с указанным идентификатором.'
                ]);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'status' => 500,
                'message' => 'Не передан идентификатор заявки.'
            ]);
        }
    }

    public function uploadFiles()
    {
        $orderID = Input::get('orderID');
        $data = Input::all();

        if($orderID)
        {
            $order = DeliveryOrder::find($orderID);

            if($order)
            {
                if(isset($data['fileIDCardA']))
                {
                    $order->addMediaFromRequest('fileIDCardA')->withCustomProperties(['type' => 'idCardA'])->toMediaLibrary('orderClientDocs');
                }

                if(isset($data['fileIDCardB']))
                {
                    $order->addMediaFromRequest('fileIDCardB')->withCustomProperties(['type' => 'idCardB'])->toMediaLibrary('orderClientDocs');
                }

                if(isset($data['fileClientPhotoA']))
                {
                    $order->addMediaFromRequest('fileClientPhotoA')->withCustomProperties(['type' => 'clientPhotoA'])->toMediaLibrary('orderClientDocs');
                }

                if(isset($data['fileClientPhotoB']))
                {
                    $order->addMediaFromRequest('fileClientPhotoB')->withCustomProperties(['type' => 'clientPhotoB'])->toMediaLibrary('orderClientDocs');
                }

                if($order->save())
                {
                    return response()->json([
                        'success' => false,
                        'status' => 200,
                        'message' => 'Файлы были успешно загружены.'
                    ], 200);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Не найдена заявка с указанным идентификатором.'
                ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Не передан идентификатор заявки.'
            ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function changeComment()
    {
        $orderID = Input::get('orderID');
        $comment = Input::get('text');

        if($orderID)
        {
            $order = DeliveryOrder::find($orderID);

            if($order)
            {
                $order->comments = trim($comment);

                if($order->save())
                {
                    return response()->json([
                        'success' => true,
                        'status' => 200,
                        'message' => 'Комментарий были успешно добавлены.'
                    ], 200);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Не найдена заявка с указанным идентификатором.'
                ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Не передан идентификатор заявки.'
            ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }

    public function changeStatus()
    {
        $orderID = Input::get('orderID');
        $status = Input::get('status');

        if($orderID)
        {
            $order = DeliveryOrder::find($orderID);

            if($order)
            {
                $order->status = $status;
                $order->delivered_at = Carbon::now();

                if($order->save())
                {
                    return response()->json([
                        'success' => true,
                        'status' => 200,
                        'message' => 'Статус был успешно изменен.'
                    ], 200);
                }
            }
            else
            {
                return response()->json([
                    'success' => false,
                    'status' => 400,
                    'message' => 'Не найдена заявка с указанным идентификатором.'
                ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
            }
        }
        else
        {
            return response()->json([
                'success' => false,
                'status' => 400,
                'message' => 'Не передан идентификатор заявки.'
            ], 400, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
        }
    }


    function array_to_xml(array $arr, \SimpleXMLElement $xml)
    {
        foreach ($arr as $k => $v) {
            is_array($v)
                ? $this->array_to_xml($v, $xml->addChild($k))
                : $xml->addChild($k, $v);
        }
        return $xml;
    }


}

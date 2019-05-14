<?php

namespace App\Http\Controllers\MobileApi;

use App\DeliveryOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;

class FilesController extends Controller
{
    public function upload(Request $request)
    {
        $data = Input::all();
        file_put_contents('test111.txt', print_r($data, true), FILE_APPEND);
        $requestID = Input::get('pReqId');
        $data = Input::all();

        if($requestID)
        {
            $deliveryOrder = DeliveryOrder::getCollection(['requestIdIn' => $requestID])->first();

            if($deliveryOrder)
            {
                if (isset($data['pDocType']) && $data['pDocType'] == 001)
                {
                    if(isset($data['files']))
                    {
                        $deliveryOrder->addMediaFromRequest('files')->withCustomProperties(['type' => 'DOC_TYPE_CLIENT'])->toMediaLibrary('orderClientDocs');
                    }
                }
                if (isset($data['pDocType']) && $data['pDocType'] == 002)
                {
                    if(isset($data['files']))
                    {
                        $deliveryOrder->addMediaFromRequest('files')->withCustomProperties(['type' => 'DOC_TYPE_ID'])->toMediaLibrary('orderClientDocs');
                    }
                }
                if (isset($data['pDocType']) && $data['pDocType'] == 003)
                {
                    if(isset($data['files']))
                    {
                        $deliveryOrder->addMediaFromRequest('files')->withCustomProperties(['type' => 'DOC_TYPE_A4'])->toMediaLibrary('orderClientDocs');
                    }
                }
//                if(isset($data['fileIDCardA']))
//                {
//                    $order->addMediaFromRequest('fileIDCardA')->withCustomProperties(['type' => 'idCardA'])->toMediaLibrary('orderClientDocs');
//                }

//                if(isset($data['fileIDCardB']))
//                {
//                    $order->addMediaFromRequest('fileIDCardB')->withCustomProperties(['type' => 'idCardB'])->toMediaLibrary('orderClientDocs');
//                }
//
//                if(isset($data['fileClientPhotoA']))
//                {
//                    $order->addMediaFromRequest('fileClientPhotoA')->withCustomProperties(['type' => 'clientPhotoA'])->toMediaLibrary('orderClientDocs');
//                }
//
//                if(isset($data['fileClientPhotoB']))
//                {
//                    $order->addMediaFromRequest('fileClientPhotoB')->withCustomProperties(['type' => 'clientPhotoB'])->toMediaLibrary('orderClientDocs');
//                }

                if($deliveryOrder->save())
                {
                    return response()->json([
                        'error' => '',
                        'sid' => '',
                        'files' => [
                            "filename" => "",
                            "filehref" => "",
                            "filesize" => 101036,
                            "autor" => "",
                            "upload_date" => "14.05.2019 18:53:25",
                            "is_delete" => false,
                            "mime_type" => "image/jpeg"
                        ]
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
        die;
//        mail('gabdullayev@crystalspring.kz', 'test', 'test', '');
        var_dump($request->all());
        $data = Input::all();
        file_put_contents('test111.txt', print_r($data, true), FILE_APPEND);
        var_dump(Input::all());
    }
}

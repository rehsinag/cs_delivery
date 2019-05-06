<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMedia;

class DeliveryOrder extends Model implements HasMedia
{
    use HasMediaTrait;

    protected $table = 'deliveryOrders';

    public static function getCollection($params=null)
    {
        $ret = self::select('deliveryOrders.*');

        if(isset($params['branchId']) && $params['branchId'])
            $ret->where('branchId', $params['branchId']);

        return $ret;
    }

    public function initCity()
    {
        $this->cityObj = CityCatalog::find($this->city);
    }

    public function initCounty()
    {
        $this->countyObj = CountyCatalog::find($this->county);
    }

    public function setDataFromArray($data)
    {
        if(isset($data['requestId']) && trim($data['requestId']))
            $this->requestId = trim($data['requestId']);
        if(isset($data['eventId']) && trim($data['eventId']))
            $this->eventId = trim($data['eventId']);
        if(isset($data['productId']) && trim($data['productId']))
            $this->productId = trim($data['productId']);
        if(isset($data['deliveryUserId']) && trim($data['deliveryUserId']))
            $this->deliveryUserId = trim($data['deliveryUserId']);
        if(isset($data['branchId']) && trim($data['branchId']))
            $this->branchId = trim($data['branchId']);

        if(isset($data['firstName']) && trim($data['firstName']))
            $this->firstName = trim($data['firstName']);
        if(isset($data['lastName']) && trim($data['lastName']))
            $this->lastName = trim($data['lastName']);
        if(isset($data['middleName']) && trim($data['middleName']))
            $this->middleName = trim($data['middleName']);
        if(isset($data['iin']) && trim($data['iin']))
            $this->iin = trim($data['iin']);
        if(isset($data['phone']) && trim($data['phone']))
            $this->phone = trim($data['phone']);

        if(isset($data['city']) && trim($data['city']))
            $this->city = trim($data['city']);
        if(isset($data['county']) && trim($data['county']))
            $this->county = trim($data['county']);
        if(isset($data['region']) && trim($data['region']))
            $this->region = trim($data['region']);
        if(isset($data['street']) && trim($data['street']))
            $this->street = trim($data['street']);
        if(isset($data['house']) && trim($data['house']))
            $this->house = trim($data['house']);
        if(isset($data['apartment']) && trim($data['apartment']))
            $this->apartment = trim($data['apartment']);

        if(isset($data['deliveryDate']) && trim($data['deliveryDate']))
            $this->deliveryDate = trim($data['deliveryDate']);

        if(isset($data['status']) && trim($data['status']))
            $this->status = trim($data['status']);

        if(isset($data['comments']) && trim($data['comments']))
            $this->comments = trim($data['comments']);

        if(isset($data['fileIDCardA']) && trim($data['fileIDCardA']))
            $this->fileIDCardA = trim($data['fileIDCardA']);

        if(isset($data['fileIDCardB']) && trim($data['fileIDCardB']))
            $this->fileIDCardB = trim($data['fileIDCardB']);
    }

    public function validateData()
    {
        $errors = null;

        if(!$this->firstName || $this->firstName == null)
            $errors[] = 'Необходимо указать Имя клиента!';

        if(!$this->lastName || $this->lastName == null)
            $errors[] = 'Необходимо указать Фамилию клиента!';
            
        if(!$this->middleName || $this->middleName == null)
            $errors[] = 'Необходимо указать Отчество клиента!';

        if(!$this->iin || $this->iin == null)
            $errors[] = 'Необходимо указать ИИН клиента!';

        if(!$this->phone || $this->phone == null)
            $errors[] = 'Необходимо указать Телефон клиента!';

        if(!$this->requestId || $this->requestId == null)
            $errors[] = 'Необходимо указать Идентификатор заявки!';

        if(!$this->productId || $this->productId == null)
            $errors[] = 'Необходимо указать Продукт!';    

        if(!$this->branchId || $this->branchId == null)
            $errors[] = 'Необходимо указать Филиал!';

        if(!$this->eventId || $this->eventId == null)
            $errors[] = 'Необходимо указать event_id!';

        if(!$this->city || $this->city == null)
            $errors[] = 'Необходимо указать Город!';

        if(!$this->county || $this->county == null)
            $errors[] = 'Необходимо указать Район!';

        if(!$this->street || $this->street == null)
            $errors[] = 'Необходимо указать Улицу!';

        if(!$this->house || $this->house == null)
            $errors[] = 'Необходимо указать Дом!';

        if(!$this->apartment || $this->apartment == null)
            $errors[] = 'Необходимо указать Квартиру!';


        if(!$this->deliveryDate || $this->deliveryDate == null)
            $errors[] = 'Необходимо указать Дату доставки!';

        return $errors;
    }

    public function submitData()
    {
        $deliveryOrder = new self();

        if($this->id)
        {
            $deliveryOrder = self::find($this->id);
        }
        

        $deliveryOrder->firstName = $this->firstName;
        $deliveryOrder->lastName = $this->lastName;
        $deliveryOrder->middleName = $this->middleName;
        $deliveryOrder->iin = $this->iin;
        $deliveryOrder->phone = $this->phone;
        $deliveryOrder->requestId = $this->requestId;
        $deliveryOrder->productId = $this->productId;
        $deliveryOrder->branchId = $this->branchId;
        $deliveryOrder->eventId = $this->eventId;
        $deliveryOrder->city = $this->city;
        $deliveryOrder->county = $this->county;
        $deliveryOrder->street = $this->street;
        $deliveryOrder->house = $this->house;
        $deliveryOrder->apartment = $this->apartment;
        $deliveryOrder->deliveryDate = $this->deliveryDate;

        if(isset($this->comments))
            $deliveryOrder->comments = $this->comments;

        $deliveryOrder->status = Status::DOSSIER_TAKEN;

        $deliveryOrder->save();

//        if(isset($this->fileIDCardA))
//        {
//            $deliveryOrder->addMediaFromRequest('fileIDCardA')->withCustomProperties(['type' => 'idCardA'])->toMediaLibrary('orderClientDocs');
//        }
//
//        if(isset($this->fileIDCardB))
//        {
//            $deliveryOrder->addMediaFromRequest('fileIDCardB')->withCustomProperties(['type' => 'idCardB'])->toMediaLibrary('orderClientDocs');
//        }

        return $deliveryOrder;
    }
}

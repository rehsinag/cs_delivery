<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryCompany extends Model
{
    protected $table = 'deliveryCompanies';

    public function scopeActual($query)
    {
        return $query->whereIn('status', [Status::ACTIVE, Status::INACTIVE]);
    }

    public static function getCollection($params=null)
    {
        $ret = self::select('deliveryCompanies.*');

        if(isset($params['actual']) && $params['actual'])
            $ret->actual();

        return $ret;
    }

    public function setDataFromArray($data)
    {
        if(isset($data['id']) && trim($data['id']))
            $this->id = trim($data['id']);

        if(isset($data['code']) && trim($data['code']))
            $this->code = trim($data['code']);

        if(isset($data['displayName']) && trim($data['displayName']))
            $this->displayName = trim($data['displayName']);

        if(isset($data['description']) && trim($data['description']))
            $this->description = trim($data['description']);

        if(isset($data['address']) && trim($data['address']))
            $this->address = trim($data['address']);

        if(isset($data['contacts']) && trim($data['contacts']))
            $this->contacts = trim($data['contacts']);

        if(isset($data['status']) && trim($data['status']))
            $this->status = trim($data['status']);
    }

    public function validateData()
    {
        $errors = null;

        if(!$this->code || $this->code == null)
            $errors[] = 'Необходимо указать код курьерской компании';

        if(!$this->displayName || $this->displayName == null)
            $errors[] = 'Необходимо указать наименование курьерской компании';

        if(!$this->description || $this->description == null)
            $errors[] = 'Необходимо указать описание курьерской компании';

        if(!$this->address || $this->address == null)
            $errors[] = 'Необходимо указать адрес курьерской компании';

        if(!$this->contacts || $this->contacts == null)
            $errors[] = 'Необходимо указать контакт курьерской компании';

        return $errors;
    }

    public function submitData()
    {
        $deliveryCompany = new self();

        if($this->id)
            $deliveryCompany = self::find($this->id);

        $deliveryCompany->code              = $this->code;
        $deliveryCompany->displayName       = $this->displayName;
        $deliveryCompany->description       = $this->description;
        $deliveryCompany->address           = $this->address;
        $deliveryCompany->contacts          = $this->contacts;
        $deliveryCompany->status            = $this->status;

        $deliveryCompany->save();

        return $deliveryCompany;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryUser extends Model
{
    protected $table = 'deliveryUsers';

    public function scopeActual($query)
    {
        return $query->whereIn('status', [Status::ACTIVE, Status::INACTIVE]);
    }

    public static function getCollection($params=null)
    {
        $ret = self::select('deliveryUsers.*');

        if(isset($params['actual']) && $params['actual'])
            $ret->actual();

        return $ret;
    }

    public function setDataFromArray($data)
    {
        if(isset($data['id']) && trim($data['id']))
            $this->id = trim($data['id']);

        if(isset($data['companyId']) && trim($data['companyId']))
            $this->companyId = trim($data['companyId']);

        if(isset($data['branchId']) && trim($data['branchId']))
            $this->branchId = trim($data['branchId']);

        if(isset($data['login']) && trim($data['login']))
            $this->login = trim($data['login']);

        if(isset($data['password']) && trim($data['password']))
            $this->password = trim($data['password']);

        if(isset($data['email']) && trim($data['email']))
            $this->email = trim($data['email']);

        if(isset($data['firstName']) && trim($data['firstName']))
            $this->firstName = trim($data['firstName']);

        if(isset($data['lastName']) && trim($data['lastName']))
            $this->lastName = trim($data['lastName']);

        if(isset($data['middleName']) && trim($data['middleName']))
            $this->middleName = trim($data['middleName']);

        if(isset($data['description']) && trim($data['description']))
            $this->description = trim($data['description']);

        if(isset($data['role']) && trim($data['role']))
            $this->role = trim($data['role']);

        if(isset($data['loginAttemptsCount']) && trim($data['loginAttemptsCount']))
            $this->loginAttemptsCount = trim($data['loginAttemptsCount']);

        if(isset($data['status']) && trim($data['status']) )
            $this->status = trim($data['status']);
    }

    public function validateData()
    {
        $errors = null;

        if(!$this->login || $this->login == null)
            $errors[] = 'Необходимо указать логин курьера';

        if(!$this->password || $this->password == null)
            $errors[] = 'Необходимо указать пароль курьера';

        if(!$this->email || $this->email == null)
            $errors[] = 'Необходимо указать email курьера';

        if(!$this->firstName || $this->firstName == null)
            $errors[] = 'Необходимо указать имя курьера';

        if(!$this->lastName || $this->lastName == null)
            $errors[] = 'Необходимо указать фамилию курьера';

        if(!$this->middleName || $this->middleName == null)
            $errors[] = 'Необходимо указать отчество курьера';

        if(!$this->description || $this->description == null)
            $errors[] = 'Необходимо указать описание курьера';

        if(!$this->loginAttemptsCount || $this->loginAttemptsCount == null)
            $errors[] = 'Необходимо указать количество попыток входа курьера';

        return $errors;
    }

    public function submitData()
    {
        $deliveryUser = new self();

        if($this->id)
            $deliveryUser = self::find($this->id);

        $deliveryUser->companyId            = $this->companyId;
        $deliveryUser->branchId             = $this->branchId;
        $deliveryUser->login                = $this->login;
        $deliveryUser->password             = bcrypt($this->password);
        $deliveryUser->email                = $this->email;
        $deliveryUser->firstName            = $this->firstName;
        $deliveryUser->lastName             = $this->lastName;
        $deliveryUser->middleName           = $this->middleName;
        $deliveryUser->description          = $this->description;
        $deliveryUser->role                 = $this->role;
        $deliveryUser->loginAttemptsCount   = $this->loginAttemptsCount;
        $deliveryUser->status               = $this->status ;

        $deliveryUser->save();

        return $deliveryUser;
    }

    public function init()
    {
        $this->deliveryCompany          = DeliveryCompany::find($this->companyId);
        $this->branch                   = Branch::find($this->branchId);
    }
}

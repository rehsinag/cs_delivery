<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CityCatalog extends Model
{
    protected $table = 'citiesCatalog';

    public function scopeActual($query)
    {
        return $query->whereIn('status', [Status::ACTIVE, Status::INACTIVE]);
    }

    public static function getCollection($params=null)
    {
        $ret = self::select('citiesCatalog.*');

        if(isset($params['actual']) && $params['actual'])
            $ret->actual();

        if(isset($params['idsIn']) && $params['idsIn'])
        {
            if(gettype($params['idsIn']) == 'string')  //  полюбому конвертим в массив
                $params['idsIn'] = explode(',',trim($params['idsIn']));

            if(count($params['idsIn']))
            {
                if(count($params['idsIn']) == 1)
                    $ret->where('id', $params['idsIn'][0]);
                else
                    $ret->whereIn('id', $params['idsIn']);
            }
        }

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

        if(isset($data['status']) && trim($data['status']))
            $this->status = trim($data['status']);
    }

    public function validateData()
    {
        $errors = null;

        if(!$this->code || $this->code == null)
            $errors[] = 'Необходимо указать Код филиала!';

        if(!$this->displayName || $this->displayName == null)
            $errors[] = 'Необходимо указать Отображаемое название филиала!';

        return $errors;
    }

    public function submitData()
    {
        $city = new self();

        if($this->id)
        {
            $city = self::find($this->id);
        }


        $city->code           = $this->code;
        $city->displayName    = $this->displayName;
        $city->status         = $this->status;

        $city->save();

        return $city;
    }
}

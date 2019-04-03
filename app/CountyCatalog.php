<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountyCatalog extends Model
{
    protected $table = 'countiesCatalog';

    public function scopeActual($query)
    {
        return $query->whereIn('status', [Status::ACTIVE, Status::INACTIVE]);
    }

    public static function getCollection($params=null)
    {
        $ret = self::select('countiesCatalog.*');

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
            $errors[] = 'Необходимо указать Код района!';

        if(!$this->displayName || $this->displayName == null)
            $errors[] = 'Необходимо указать Отображаемое название района!';

        return $errors;
    }

    public function submitData()
    {
        $county = new self();

        if($this->id)
        {
            $county = self::find($this->id);
        }


        $county->code           = $this->code;
        $county->displayName    = $this->displayName;
        $county->status         = $this->status;

        $county->save();

        return $county;
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BranchCatalog extends Model
{
    protected $table = 'branchesCatalog';

    public function scopeActual($query)
    {
        return $query->whereIn('status', [Status::ACTIVE, Status::INACTIVE]);
    }

    public static function getCollection($params=null)
    {
        $ret = self::select('branchesCatalog.*');

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
        $branch = new self();

        if($this->id)
        {
            $branch = self::find($this->id);
        }


        $branch->code           = $this->code;
        $branch->displayName    = $this->displayName;
        $branch->status         = $this->status;

        $branch->save();

        return $branch;
    }
}

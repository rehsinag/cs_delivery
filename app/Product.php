<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    public function scopeActual($query)
    {
        return $query->whereIn('status', [Status::ACTIVE, Status::INACTIVE]);
    }

    public static function getCollection($params=null)
    {
        $ret = self::select('products.*');

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

        if(isset($data['status']) && trim($data['status']))
            $this->status = trim($data['status']);
    }

    public function validateData()
    {
        $errors = null;

        if(!$this->code || $this->code == null)
            $errors[] = 'Необходимо указать код продукта';

        if(!$this->displayName || $this->displayName == null)
            $errors[] = 'Необходимо указать наименование продукта';

        if(!$this->description || $this->description == null)
            $errors[] = 'Необходимо указать описание продукта';

        return $errors;
    }

    public function submitData()
    {
        $product = new self();

        if($this->id)
            $product = self::find($this->id);

        $product->code          = $this->code;
        $product->displayName   = $this->displayName;
        $product->description   = $this->description;
        $product->status        = $this->status;

        $product->save();

        return $product;
    }
}

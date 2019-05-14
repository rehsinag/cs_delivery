<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryUserComment extends Model
{
    protected $table = 'deliveryUsersComments';

    public static function getCollection($params=null)
    {
        $ret = self::select('deliveryUsersComments.*');

        if(isset($params['requestIdIn']) && count($params['requestIdIn']))
        {
            if(gettype($params['requestIdIn']) == 'string')
                $params['requestIdIn'] = explode(',',trim($params['requestIdIn']));

            if(count($params['requestIdIn']) == 1)
                $ret->where('requestId', $params['requestIdIn'][0]);
            else
                $ret->whereIn('requestId', $params['requestIdIn']);
        }

        if(isset($params['orderBy']) &&  trim($params['orderBy']) )
        {
            if(isset($params['desc']))
                $ret->orderBy($params['orderBy'], 'desc');
            else $ret->orderBy($params['orderBy']);
        }

        return $ret;
    }

    public function initDeliveryUser()
    {
        $this->deliveryUser = DeliveryUser::find($this->deliveryUserId);
    }
}

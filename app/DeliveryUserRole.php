<?php

namespace App;

class DeliveryUserRole
{
    const COURIER       = 1;
    const SUPERVISOR    = 2;

    private static $arr = [
        self::COURIER => [
            'code' => self::COURIER,
            'title'=>'Курьер',
        ],
        self::SUPERVISOR => [
            'code' => self::SUPERVISOR,
            'title'=>'Супервайзер курьера',
        ],
    ];

    public static function code($code = null)
    {
        $tmp = null;
        if($code && isset(self::$arr[$code]))
        {
            $tmp = new self();
            $tmp->code = $code;
            $tmp->title = self::$arr[$code]['title'];
        }

        return $tmp;
    }

    public static function all()
    {
        $ret = [];
        foreach(self::$arr as $key=>$val)
            $ret[$key] = self::code($key);

        return $ret;
    }
}

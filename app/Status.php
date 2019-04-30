<?php

namespace App;

class Status
{
    const ACTIVE            = 1;
    const INACTIVE          = 2;
    const DELETED           = 99;
    const DELIVERED         = 10;
    const REJECT_PRODUCT    = 11;
    const REJECT_DELIVERY   = 12;

    private static $arr = [
        self::ACTIVE => [
            'code' => self::ACTIVE,
            'title'=>'Активный',
        ],
        self::INACTIVE => [
            'code' => self::INACTIVE,
            'title'=>'Неактивный',
        ],
        self::DELETED => [
            'code' => self::DELETED,
            'title'=>'Удаленный',
        ],
        self::DELIVERED => [
            'code' => self::DELIVERED,
            'title'=>'Доставлен',
        ],
        self::REJECT_PRODUCT => [
            'code' => self::REJECT_PRODUCT,
            'title'=>'Отказ от продукта',
        ],
        self::REJECT_DELIVERY => [
            'code' => self::REJECT_DELIVERY,
            'title'=>'Отказ от доставки',
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

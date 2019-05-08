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
    const PROCESS           = 13;
    const DOSSIER_TAKEN     = 30;
    const REAPPLICATION     = 50;

    private static $arr = [
        self::ACTIVE => [
            'code' => self::ACTIVE,
            'title'=>'Активный',
            'slug' => 'ACTIVE',
        ],
        self::INACTIVE => [
            'code' => self::INACTIVE,
            'title'=>'Неактивный',
            'slug' => 'INACTIVE',
        ],
        self::DELETED => [
            'code' => self::DELETED,
            'title'=>'Удаленный',
            'slug' => 'DELETED',
        ],
        self::DELIVERED => [
            'code' => self::DELIVERED,
            'title'=>'Доставлен',
            'slug' => 'DELIVERED',
        ],
        self::REJECT_PRODUCT => [
            'code' => self::REJECT_PRODUCT,
            'title'=>'Отказ от продукта',
            'slug' => 'REJECT_PRODUCT',
        ],
        self::REJECT_DELIVERY => [
            'code' => self::REJECT_DELIVERY,
            'title'=>'Отказ от доставки',
            'slug' => 'REJECT_DELIVERY',
        ],
        self::PROCESS => [
            'code' => self::PROCESS,
            'title'=>'В процессе доставки',
            'slug' => 'PROCESS',
        ],
        self::DOSSIER_TAKEN => [
            'code' => self::DOSSIER_TAKEN,
            'title'=>'Досье принято',
            'slug' => 'DOSSIER_TAKEN',
        ],
        self::REAPPLICATION => [
            'code' => self::REAPPLICATION,
            'title'=>'Повторная заявка',
            'slug' => 'REAPPLICATION',
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
            $tmp->slug = self::$arr[$code]['slug'];
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

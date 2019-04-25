<?php

namespace App;

class Status
{
    const ACTIVE    = 1;
    const INACTIVE  = 2;
    const DELETED   = 99;
    const COMPLETED = 10;

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
        self::COMPLETED => [
            'code' => self::COMPLETED,
            'title'=>'Завершен',
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

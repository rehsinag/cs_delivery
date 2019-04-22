<?php

namespace App;

class DeliveryOrderStatus
{
    const RECEIVED = 10;
    const VERIFIED = 20;

    private static $arr = [
        self::RECEIVED => [
            'code' => self::RECEIVED,
            'title'=>'Получена и записана в SpringDoc',
        ],
        self::VERIFIED => [
            'code' => self::VERIFIED,
            'title'=>'Проверена специалистами SpringDoc',
        ],
    ];
}

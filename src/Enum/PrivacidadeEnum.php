<?php

namespace App\Enum;

abstract class PrivacidadeEnum
{
    public const PUBLICO = 'Público';
    public const AMIGOS = 'Amigos';

    public static function getPrivacidade()
    {
        return [
            self::PUBLICO => 'Público',
            self::AMIGOS => 'Amigos'
        ];
    }
}

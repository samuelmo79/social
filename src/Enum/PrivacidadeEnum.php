<?php

namespace App\Enum;

abstract class PrivacidadeEnum
{
    public const PUBLICO = 'Publico';
    public const AMIGOS = 'Amigos';
    public const PRIVADO = 'Privado';

    public static function getPrivacidade()
    {
        return [
            self::PUBLICO => 'Publico',
            self::AMIGOS => 'Amigos',
            self::PRIVADO => 'Privado'
        ];
    }
}

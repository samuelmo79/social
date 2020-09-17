<?php

namespace App\Enum;

abstract class SexoEnum
{
    public const SELECIONE = '';
    public const MASCULINO = 'Masculino';
    public const FEMININO = 'Feminino';
    public const OUTROS = 'Outros';

    public static function getSexo()
    {
        return [
            self::SELECIONE => 'Selecione',
            self::MASCULINO => 'Masculino',
            self::FEMININO => 'Feminino',
            self::OUTROS => 'Outros'
        ];
    }
}

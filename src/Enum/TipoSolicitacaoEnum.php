<?php


namespace App\Enum;


abstract class TipoSolicitacaoEnum
{
    public const AMIZADE = 'Amizade';


    public static function getTipoSolicitacaoEnum()
    {
        return [
            self::AMIZADE => 'Amizade',
        ];
    }

}
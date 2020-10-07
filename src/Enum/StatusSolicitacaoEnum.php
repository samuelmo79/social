<?php


namespace App\Enum;


abstract class StatusSolicitacaoEnum
{
    public const PENDENTE = 1;
    public const ACEITO = 2;
    public const REJEITADO = 3;

    public static function getStatusSolicitacao()
    {
        return [
            self::PENDENTE => 'Pendente',
            self::ACEITO => 'Aceito',
            self::REJEITADO => 'Rejeitado'
        ];
    }

}
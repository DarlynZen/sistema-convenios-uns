<?php

namespace App\Enums;

final class TipoDocumentoConvenio //forma para versiones de php < 8.1
{
    public const RESOLUCION = 'RESOLUCION';
    public const CONVENIO = 'CONVENIO';

    public static function values(): array
    {
        return [
                self::RESOLUCION => 'Resolución',
                self::CONVENIO => 'Convenio',
        ];
    }
}

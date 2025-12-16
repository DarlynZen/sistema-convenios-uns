<?php

namespace App\Enums;

enum EstadoConvenio: int
{
    case ACTIVO = 1;
    case VENCIDO = 2;
    case EN_REVISION = 3;

    public function label(): string
    {
        return match ($this) {
            self::ACTIVO => 'Activo',
            self::VENCIDO => 'Vencido',
            self::EN_REVISION => 'En Revisión',
        };
    }
}

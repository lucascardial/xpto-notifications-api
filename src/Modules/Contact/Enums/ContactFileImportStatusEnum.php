<?php

namespace Modules\Contact\Enums;

enum ContactFileImportStatusEnum: int
{
    case PROCESSING = 1;
    case COMPLETED = 2;
    case FAILED = 3;

    public function getLabel(): string
    {
        return match ($this) {
            self::PROCESSING => 'Processando',
            self::COMPLETED => 'Finalizado',
            self::FAILED => 'Erro',
        };
    }
}

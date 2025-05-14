<?php

namespace App\Enums;

enum ActiveStatus: string
{
    case YES = 'YES';
    case NO = 'NO';

    public function getActiveStatus(): string
    {
        return match ($this) {
            self::YES => 'Yes',
            self::NO => 'No',
        };
    }
}

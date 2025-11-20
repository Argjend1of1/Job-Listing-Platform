<?php

namespace App\Enums;

/**
 * Example Enum usage
 */
enum ServerStatus: string
{
    case Pending = 'pending';
    case Active = 'active';
    case Suspended = 'suspended';
    case Disabled = 'disabled';

    /**
     * Label cases for better UI
     */
    public function label(): string
    {
        return match ($this) {
            self::Active => 'Active Server',
            self::Pending => 'Pending Approval',
            self::Suspended => 'Suspended Server',
            self::Disabled => 'Disabled Server'
        };
    }
}

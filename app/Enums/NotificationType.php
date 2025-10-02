<?php
namespace App\Enums;

enum NotificationType: string
{
    case INFO = 'Info';
    case ALERT = 'Alert';
    case SYSTEM = 'System';
}

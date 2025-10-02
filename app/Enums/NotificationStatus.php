<?php
namespace App\Enums;

enum NotificationStatus: string
{
    case SENT = 'Sent';
    case VIEWED = 'Viewed';
    case READ = 'Read';
}

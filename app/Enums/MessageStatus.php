<?php
namespace App\Enums;

enum MessageStatus: string
{
    case SENT = 'Sent';
    case RECEIVED = 'Received';
    case READ = 'Read';
}

<?php

namespace App\NotificationWriters;

use App\NotificationWriters\Interfaces\NotificationWritable;
use App\NotificationWriters\Interfaces\Notifier;

class Terminal implements Notifier
{
    public function notify(NotificationWritable $message) : void
    {
        echo $message->toNotificationMessage();
    }
}
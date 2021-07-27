<?php

namespace App\NotificationWriters\Decorators;

use App\NotificationWriters\Interfaces\NotificationWritable;
use App\NotificationWriters\Interfaces\Notifier;

class OnlyNotifyWhenInvalidResult implements Notifier
{
    private Notifier $decorated;

    public function __construct(Notifier $decorates) {
        $this->decorated = $decorates;
    }

    public function notify(NotificationWritable $message): void
    {
        if($message->shouldNotify()) {
            $this->decorated->notify($message);
        }
    }
}
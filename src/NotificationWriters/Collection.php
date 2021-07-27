<?php

namespace App\NotificationWriters;

use App\NotificationWriters\Interfaces\NotificationWritable;
use App\NotificationWriters\Interfaces\Notifier;

class Collection implements Notifier
{
    /**
     * @var array<Notifier>
     */
    private array $notifiers;

    /**
     * @param array<Notifier> $notifiers
     */
    public function __construct(array $notifiers)
    {
        $this->notifiers = $notifiers;
    }

    public function notify(NotificationWritable $message): void
    {
        foreach($this->notifiers as $notifier) {
            $notifier->notify($message);
        }
    }
}
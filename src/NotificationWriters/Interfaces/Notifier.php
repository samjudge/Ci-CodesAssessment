<?php

namespace App\NotificationWriters\Interfaces;

interface Notifier
{
    public function notify(NotificationWritable $message) : void;
}
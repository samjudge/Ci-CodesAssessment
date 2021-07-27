<?php

namespace App\NotificationWriters\Interfaces;

interface NotificationWritable
{
    public function toNotificationMessage() : string;
    public function shouldNotify() : bool;
}
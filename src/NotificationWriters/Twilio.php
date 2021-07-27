<?php

namespace App\NotificationWriters;

use App\NotificationWriters\Interfaces\NotificationWritable;
use App\NotificationWriters\Interfaces\Notifier;
use Twilio\Rest\Client as SMSClient;

class Twilio implements Notifier
{
    private array $config;
    private SMSClient $smsClient;

    const CONFIG_FIELDS_FROM = 'from';
    const CONFIG_FIELDS_TO = 'to';

    public function __construct(array $config, SMSClient $smsClient)
    {
        $this->config = $config;
        $this->smsClient = $smsClient;
    }

    public function notify(NotificationWritable $message) : void
    {
        $this->smsClient->messages->create(
            $this->config[self::CONFIG_FIELDS_TO],
            [
                'from' => $this->config[self::CONFIG_FIELDS_FROM],
                'body' => $message->toNotificationMessage()
            ]
        );
    }
}
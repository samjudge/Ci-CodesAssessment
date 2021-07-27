<?php

namespace App\NotificationWriters;

use App\NotificationWriters\Interfaces\NotificationWritable;
use App\NotificationWriters\Interfaces\Notifier;
use Swift_SmtpTransport as SwiftSmtp;
use Swift_Mailer as SwiftMailer;
use Swift_Message as SwiftMessage;

class SwiftMail implements Notifier
{
    private array $config;
    private SwiftMailer $mailer;

    const CONFIG_FIELDS_SUBJECT = 'subject';
    const CONFIG_FIELDS_FROM = 'from';
    const CONFIG_FIELDS_TO = 'to';
    const CONFIG_FIELDS_HOST = 'to';
    const CONFIG_FIELDS_PORT = 'to';

    public function __construct(array $config)
    {
        $this->config = $config;
        $this->mailer = new SwiftMailer(new SwiftSmtp(
            $this->config[self::CONFIG_FIELDS_HOST],
            $this->config[self::CONFIG_FIELDS_PORT]
        ));
    }

    public function notify(NotificationWritable $message) : void
    {
        $this->mailer->send(
            (new SwiftMessage($this->config[self::CONFIG_FIELDS_SUBJECT]))
                ->setFrom($this->config[self::CONFIG_FIELDS_FROM])
                ->setTo($this->config[self::CONFIG_FIELDS_TO])
                ->setBody($message->toNotificationMessage())
        );
    }
}
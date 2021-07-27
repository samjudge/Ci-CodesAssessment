<?php

namespace App\NotificationWriters\Models;

use App\NotificationWriters\Interfaces\NotificationWritable;
use App\TitleStatusPairs\Models\Pair;
use App\TitleStatusPairs\Models\ValidationResult;

class TitleStatusPairNotification implements NotificationWritable // The interface here is applied since it's an easy way
                                                                  // of creating multiple models that can be consumed by
                                                                  // the notification writers without having to change
                                                                  // anything. Doing this allows us to easily create
                                                                  // new code when we want different messages without
                                                                  // having to actually modify existing code.
{
    private string $forUrl;
    private Pair $expected;
    private Pair $actual;
    private ValidationResult $result;

    public function __construct(
        string $forUrl,
        Pair $expected,
        Pair $actual,
        ValidationResult $result
    )
    {
        $this->forUrl = $forUrl;
        $this->expected = $expected;
        $this->actual = $actual;
        $this->result = $result;
    }

    public function toNotificationMessage(): string
    {
        $outputMessage = "Sent request to `" . $this->forUrl . "`\nAnd found the following ->\n";
        $outputMessage .= "Status code : `" . $this->actual->getStatus() . "`\n";
        $outputMessage .= "Title : `" . $this->actual->getTitle() . "`\n";
        if(!$this->result->isStatusValid()) {
            $expectedStatusCode = $this->expected->getStatus();
            $actualStatusCode = $this->actual->getStatus();
            $outputMessage .= "\nInvalid status code ->\n  Expected : `$expectedStatusCode`\n  Found : `$actualStatusCode`\n";
        }
        if(!$this->result->isTitleValid()) {
            $expectedTitle = $this->expected->getTitle();
            $actualTitle = $this->actual->getTitle();
            $outputMessage .= "\nInvalid title ->\n  Expected : `$expectedTitle`\n  Found : `$actualTitle`\n";
        }
        return $outputMessage;
    }

    public function shouldNotify(): bool
    {
        return !$this->result->isStatusValid() || !$this->result->isTitleValid();
    }
}
<?php

namespace App\TitleStatusPairs\Models;

class ValidationResult
{
    private bool $isTitleValid;
    private bool $isStatusValid;

    public function __construct(bool $isTitleValid, bool $isStatusValid)
    {
        $this->isTitleValid = $isTitleValid;
        $this->isStatusValid = $isStatusValid;
    }

    public function isTitleValid(): bool
    {
        return $this->isTitleValid;
    }

    public function isStatusValid(): bool
    {
        return $this->isStatusValid;
    }
}
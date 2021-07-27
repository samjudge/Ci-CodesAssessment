<?php

namespace App\TitleStatusPairs\Models;

class Pair
{
    private ?string $title;
    private ?string $status;

    public function __construct(?string $title, ?string $status)
    {
        $this->title = $title;
        $this->status = $status;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }
}
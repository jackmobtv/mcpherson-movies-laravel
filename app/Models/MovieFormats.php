<?php

namespace App\Models;

class MovieFormats extends JSONClass
{
    private int $format_id;
    private string $format_name;
    private string $format_description;

    public function __construct(){}

    public function getFormatId(): int
    {
        return $this->format_id;
    }

    public function setFormatId(int $format_id): void
    {
        $this->format_id = $format_id;
    }

    public function getFormatName(): string
    {
        return $this->format_name;
    }

    public function setFormatName(string $format_name): void
    {
        $this->format_name = $format_name;
    }

    public function getFormatDescription(): string
    {
        return $this->format_description;
    }

    public function setFormatDescription(string $format_description): void
    {
        $this->format_description = $format_description;
    }
}

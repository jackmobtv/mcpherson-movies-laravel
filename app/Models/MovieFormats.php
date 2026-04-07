<?php

namespace App\Models;

use JsonSerializable;

class MovieFormats implements JsonSerializable
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

    public function serialize(): string
    {
        $serializedData = [
            'format_id' => $this->format_id,
            'format_name' => $this->format_name,
            'format_description' => $this->format_description
        ];

        return json_encode($serializedData);
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public static function SerializeArray(array $formats): array
    {
        $serializedFormats = [];
        foreach ($formats as $format) {
            $serializedFormats[] = $format->jsonSerialize();
        }
        return $serializedFormats;
    }
}

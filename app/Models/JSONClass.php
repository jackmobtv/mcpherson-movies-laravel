<?php

namespace App\Models;

use JsonSerializable;
use ReflectionObject;

abstract class JSONClass implements JsonSerializable
{
    public function jsonSerialize(): array
    {
        $reflection = new ReflectionObject($this);
        $props = $reflection->getProperties();

        $result = [];
        foreach ($props as $prop) {
            $prop->setAccessible(true);
            $result[$prop->getName()] = $prop->getValue($this);
        }
        return $result;
    }

    public static function SerializeArray(array $items): array
    {
        $serializedItems = [];
        foreach ($items as $item) {
            $serializedItems[] = $item->jsonSerialize();
        }
        return $serializedItems;
    }
}

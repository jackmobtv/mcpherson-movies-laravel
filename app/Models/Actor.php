<?php

namespace App\Models;

use AllowDynamicProperties;
use JsonSerializable;

#[AllowDynamicProperties]
class Actor extends JSONClass
{
    private int $actor_id;
    private string $actor_name;

    public function __construct(){}

    public function getActorId(): int
    {
        return $this->actor_id;
    }

    public function setActorId(int $actor_id): void
    {
        $this->actor_id = $actor_id;
    }

    public function getActorName(): string
    {
        return $this->actor_name;
    }

    public function setActorName(string $actor_name): void
    {
        $this->actor_name = $actor_name;
    }

    public function serialize(): string
    {
        $serializedData = [
            'actor_id' => $this->actor_id,
            'actor_name' => $this->actor_name
        ];

        return json_encode($serializedData);
    }
}

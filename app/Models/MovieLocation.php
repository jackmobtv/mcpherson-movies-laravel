<?php

namespace App\Models;

use JsonSerializable;

class MovieLocation implements JsonSerializable
{
    private int $location_id;
    private string $location_name;
    private string $location_description;

    public function __construct(){}

    /**
     * @return mixed
     */
    public function getLocationId()
    {
        return $this->location_id;
    }

    /**
     * @param mixed $location_id
     */
    public function setLocationId($location_id): void
    {
        $this->location_id = $location_id;
    }

    /**
     * @return mixed
     */
    public function getLocationName()
    {
        return $this->location_name;
    }

    /**
     * @param mixed $location_name
     */
    public function setLocationName($location_name): void
    {
        $this->location_name = $location_name;
    }

    /**
     * @return mixed
     */
    public function getLocationDescription()
    {
        return $this->location_description;
    }

    /**
     * @param mixed $location_description
     */
    public function setLocationDescription($location_description): void
    {
        $this->location_description = $location_description;
    }

    public function serialize(): string
    {
        $serializedData = [
            'location_id' => $this->location_id,
            'location_name' => $this->location_name,
            'location_description' => $this->location_description
        ];

        return json_encode($serializedData);
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }

    public static function SerializeArray(array $locations): array
    {
        $serializedLocations = [];
        foreach ($locations as $location) {
            $serializedLocations[] = $location->jsonSerialize();
        }
        return $serializedLocations;
    }
}

<?php

namespace App\Models;

class MovieLocation extends JSONClass
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
}

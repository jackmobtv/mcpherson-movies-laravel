<?php

namespace App\Models;

use AllowDynamicProperties;
use JsonSerializable;

#[AllowDynamicProperties]
class Movie extends JSONClass implements JsonSerializable
{
    private int $movie_id;
    private string $title;
    private string $genre;
    private ?string $sub_genre = null;
    private ?int $release_year = null;
    private ?int $location_id = null;
    private ?int $format_id = null;
    private ?string $location_name = null;
    private ?string $format_name = null;

    public function __construct(){}

    public function getMovieId(): int
    {
        return $this->movie_id;
    }

    public function setMovieId(int $movie_id): void
    {
        $this->movie_id = $movie_id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getGenre(): string
    {
        return $this->genre;
    }

    public function setGenre(string $genre): void
    {
        $this->genre = $genre;
    }

    public function getSubGenre(): ?string
    {
        return $this->sub_genre;
    }

    public function setSubGenre(?string $sub_genre): void
    {
        $this->sub_genre = $sub_genre;
    }

    public function getReleaseYear(): ?int
    {
        return $this->release_year;
    }

    public function setReleaseYear(?int $release_year): void
    {
        $this->release_year = $release_year;
    }

    public function getLocationId(): int
    {
        return $this->location_id;
    }

    public function setLocationId(int $location_id): void
    {
        $this->location_id = $location_id;
    }

    public function getFormatId(): int
    {
        return $this->format_id;
    }

    public function setFormatId(int $format_id): void
    {
        $this->format_id = $format_id;
    }

    public function getLocationName(): string
    {
        return $this->location_name;
    }

    public function setLocationName(string $location_name): void
    {
        $this->location_name = $location_name;
    }

    public function getFormatName(): string
    {
        return $this->format_name;
    }

    public function setFormatName(string $format_name): void
    {
        $this->format_name = $format_name;
    }

    public function serialize(): string
    {
        $serializedData = [
            'movie_id' => $this->movie_id,
            'title' => $this->title,
            'genre' => $this->genre,
            'sub_genre' => $this->sub_genre,
            'release_year' => $this->release_year,
            'location_id' => $this->location_id,
            'format_id' => $this->format_id,
            'location_name' => $this->location_name,
            'format_name' => $this->format_name
        ];

        return json_encode($serializedData);
    }
}

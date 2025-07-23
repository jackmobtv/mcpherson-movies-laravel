<?php

namespace App\Models;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class Movie {
    private string $movie_id;
    private string $title;
    private string $genre;
    private ?string $sub_genre;
    private ?int $release_year;
    private int $location_id;
    private int $format_id;
    private string $location_name;
    private string $format_name;

    public function __construct(){}

    public function getMovieId(): string
    {
        return $this->movie_id;
    }

    public function setMovieId(string $movie_id): void
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
}

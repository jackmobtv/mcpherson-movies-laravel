<?php

namespace App\Models;

use AllowDynamicProperties;

#[AllowDynamicProperties]
class Movie {
    public string $movie_id;
    public string $title;
    public string $genre;
    public ?string $sub_genre;
    public ?int $release_year;
    public int $location_id;
    public int $format_id;
    public string $location_name;
    public string $format_name;

    public function __construct(){}
}

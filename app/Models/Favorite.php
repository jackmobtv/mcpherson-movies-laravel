<?php

namespace App\Models;

class Favorite extends JSONClass
{
    private int $user_id;
    private int $movie_id;

    public function __construct(){}

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): void
    {
        $this->user_id = $user_id;
    }

    public function getMovieId(): int
    {
        return $this->movie_id;
    }

    public function setMovieId(int $movie_id): void
    {
        $this->movie_id = $movie_id;
    }
}

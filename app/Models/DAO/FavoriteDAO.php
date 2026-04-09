<?php

namespace App\Models\DAO;

use App\Models\Movie;
use App\Models\shared\MySQLConnect;

class FavoriteDAO
{
    public static function GetFavoriteMovies(int $user_id) : array
    {
        $movies = [];

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_favorite_movies(%s)", $user_id);

        foreach ($result as $row) {
            $movie = new Movie();

            $movie->setMovieId($row["movie_id"]);
            $movie->setTitle($row["title"]);
            $movie->setGenre($row["genre"]);
            $movie->setSubGenre(($row["sub_genre"] == null) ? "" : $row["sub_genre"]);
            $movie->setReleaseYear(($row["release_year"] == null) ? 0 : $row["release_year"]);
            $movie->setLocationName($row["location_name"]);
            $movie->setFormatName($row["format_name"]);

            $movies[] = $movie;
        }

        $conn->disconnect();

        return $movies;
    }
}

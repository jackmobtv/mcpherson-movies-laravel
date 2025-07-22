<?php

namespace App\Models\DAO;

use App\Models\Movie;
use App\Models\shared\MySQLConnect;
use Exception;

require_once app_path()."/Models/Movie.php";
require_once app_path()."/Models/shared/MySQLConnect.php";

class MovieDAO
{
    public static function GetAllMovies(): array
    {
        $movies = [];

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_all_movies(%s,%s)", 0, 0);

        foreach ($result as $row) {
            $movie = new Movie();

            $movie->movie_id = $row["movie_id"];
            $movie->title = $row["title"];
            $movie->genre = $row["genre"];
            $movie->sub_genre = ($row["sub_genre"] == null) ? "" : $row["sub_genre"];
            $movie->release_year = ($row["release_year"] == null) ? 0 : $row["release_year"];
            $movie->location_name = $row["location_name"];
            $movie->format_name = $row["format_name"];

            $movies[] = $movie;
        }

        $conn->disconnect();

        return $movies;
    }

    public static function GetMovieById(int $id): ?Movie
    {
        $movie = new Movie();

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_movie_by_id(%s)", $id);

        try {
            $movie->movie_id = $result[0]["movie_id"];
            $movie->title = $result[0]["title"];
            $movie->genre = $result[0]["genre"];
            $movie->sub_genre = ($result[0]["sub_genre"] == null) ? "" : $result[0]["sub_genre"];
            $movie->release_year = ($result[0]["release_year"] == null) ? 0 : $result[0]["release_year"];
            $movie->location_name = $result[0]["location_name"];
            $movie->format_name = $result[0]["format_name"];
        } catch (Exception) {
            return null;
        } finally {
            $conn->disconnect();
        }

        return $movie;
    }

    public static function IsLastID(int $id): bool
    {
        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_last_movie_id()");

        try {
            return $id == $result[0]["movie_id"];
        } catch (Exception) {
            return false;
        } finally {
            $conn->disconnect();
        }
    }

    public static function GetLastID(): int
    {
        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_last_movie_id()");

        try {
            return $result[0]["movie_id"] + 1;
        } catch (Exception) {
            return 0;
        } finally {
            $conn->disconnect();
        }
    }

    public static function AddMovie(Movie $movie): bool
    {
        $conn = MySQLConnect::GetConnection();

        try {
            $conn->insert('movies', [
                "movie_id" => self::GetLastID(),
                "title" => $movie->title,
                "genre" => $movie->genre,
                "sub_genre" => $movie->sub_genre,
                "release_year" => $movie->release_year,
                "location_id" => $movie->location_id,
                "format_id" => $movie->format_id
            ]);

            return $conn->affected_rows > 0;
        } catch (Exception $ex) {
            dd($ex);
        } finally {
            $conn->disconnect();
        }
    }

    public static function GetRandomMovie(): ?Movie
    {
        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_random_movie()");

        $movie = new Movie();

        try {
            $movie->movie_id = $result[0]["movie_id"];
            $movie->title = $result[0]["title"];
            $movie->genre = $result[0]["genre"];
            $movie->sub_genre = $result[0]["sub_genre"];
            $movie->release_year = $result[0]["release_year"];
            $movie->location_name = $result[0]["location_name"];
            $movie->format_name = $result[0]["format_name"];

            if($movie->genre == null){
                $movie->genre = "";
            }
            if($movie->sub_genre == null){
                $movie->sub_genre = "";
            }

            return $movie;

        } catch (Exception) {
            return null;
        } finally {
            $conn->disconnect();
        }
    }
}

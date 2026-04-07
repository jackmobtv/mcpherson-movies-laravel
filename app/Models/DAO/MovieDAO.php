<?php

namespace App\Models\DAO;

use App\Models\Movie;
use App\Models\MovieLocation;
use App\Models\shared\MySQLConnect;
use DB;
use Exception;
use App\Models\MovieFormats;

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

    public static function GetMovieById(int $id): ?Movie
    {
        $movie = new Movie();

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_movie_by_id(%s)", $id);


        try {
            $movie->setMovieId($result[0]["movie_id"]);
            $movie->setTitle($result[0]["title"]);
            $movie->setGenre($result[0]["genre"]);
            $movie->setSubGenre(($result[0]["sub_genre"] == null) ? "" : $result[0]["sub_genre"]);
            $movie->setReleaseYear(($result[0]["release_year"] == null) ? 0 : $result[0]["release_year"]);
            $movie->setLocationName($result[0]["location_name"]);
            $movie->setFormatName($result[0]["format_name"]);
        } catch (Exception) {
            return null;
        } finally {
            $conn->disconnect();
        }

        return $movie;
    }

    public static function GetMovieTableById(int $id): ?Movie
    {
        $movie = new Movie();

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_movie_table_by_id(%s)", $id);


        try {
            $movie->setMovieId($result[0]["movie_id"]);
            $movie->setTitle($result[0]["title"]);
            $movie->setGenre($result[0]["genre"]);
            $movie->setSubGenre(($result[0]["sub_genre"] == null) ? "" : $result[0]["sub_genre"]);
            $movie->setReleaseYear(($result[0]["release_year"] == null) ? 0 : $result[0]["release_year"]);
            $movie->setLocationId($result[0]["location_id"]);
            $movie->setFormatId($result[0]["format_id"]);
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

    public static function GetRandomMovie(): ?Movie
    {
        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_random_movie()");

        $movie = new Movie();

        try {
            $movie->setMovieId($result[0]["movie_id"]);
            $movie->setTitle($result[0]["title"]);
            $movie->setGenre($result[0]["genre"]);
            $movie->setSubGenre($result[0]["sub_genre"]);
            $movie->setReleaseYear($result[0]["release_year"]);
            $movie->setLocationName($result[0]["location_name"]);
            $movie->setFormatName($result[0]["format_name"]);

            if($movie->getGenre() == null){
                $movie->setGenre("");
            }
            if($movie->getSubGenre() == null){
                $movie->setSubGenre("");
            }

            return $movie;

        } catch (Exception) {
            return null;
        } finally {
            $conn->disconnect();
        }
    }

    public static function GetMoviesByActorId($actorId): array
    {
        $movies = [];

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_movies_by_actor_id(%s,%s,%s)", $actorId, 0, 0);

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

    public static function GetAllFormats(): array
    {
        $formats = [];

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_all_formats()");

        foreach ($result as $row) {
            $format = new MovieFormats();

            $format->setFormatId($row["format_id"]);
            $format->setFormatName($row["format_name"]);
            $format->setFormatDescription($row["format_description"]);

            $formats[] = $format;
        }

        $conn->disconnect();

        return $formats;
    }

    public static function GetAllLocations(): array
    {
        $locations = [];

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_all_locations()");

        foreach ($result as $row) {
            $location = new MovieLocation();

            $location->setLocationId($row["location_id"]);
            $location->setLocationName($row["location_name"]);
            $location->setLocationDescription($row["location_description"]);

            $locations[] = $location;
        }

        $conn->disconnect();

        return $locations;
    }

    public static function UpdateMovie(Movie $movie): bool
    {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_update_movie(%s,%s,%s,%s,%s,%s,%s)",
            $movie->getMovieId(), $movie->getTitle(), $movie->getGenre(), $movie->getSubGenre(), $movie->getReleaseYear(), $movie->getLocationId(), $movie->getFormatId());

        $conn->disconnect();

        return true;
    }

    public static function DeleteMovie(int $movieId): bool
    {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_delete_movie(%s,@out_var)", $movieId);

        $conn->disconnect();

        return true;
    }

    public static function AddMovie(Movie $movie): bool
    {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_insert_movie(%s,%s,%s,%s,%s,%s,%s,%s,%s)",
            $movie->getMovieId(),$movie->getTitle(),$movie->getGenre(),$movie->getSubGenre(),$movie->getReleaseYear(),$movie->getLocationId(),$movie->getFormatId(),1,0);

        $conn->disconnect();

        return true;
    }
}

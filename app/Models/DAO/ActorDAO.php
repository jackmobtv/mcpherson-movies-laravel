<?php

namespace App\Models\DAO;

use App\Models\Actor;
use App\Models\Movie;
use App\Models\shared\MySQLConnect;
use Exception;

require_once app_path()."/Models/Actor.php";
require_once app_path()."/Models/shared/MySQLConnect.php";

class ActorDAO
{
    public static function GetAllActors(): array
    {
        $actors = [];

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_all_actors(%s,%s)", 0, 0);

        foreach ($result as $row) {
            $actor = new Actor();

            $actor->setActorId($row["actor_id"]);
            $actor->setActorName($row["actor_name"]);

            $actors[] = $actor;
        }

        $conn->disconnect();

        return $actors;
    }

    public static function GetActorsByMovieId(int $movieId): array
    {
        $actors = [];

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_actors_by_movie_id(%s,%s,%s)", $movieId, 0, 0);

        foreach ($result as $row) {
            $actor = new Actor();

            $actor->setActorId($row["actor_id"]);
            $actor->setActorName($row["actor_name"]);

            $actors[] = $actor;
        }

        $conn->disconnect();

        return $actors;
    }

    public static function GetActorById(int $actorId): ?Actor
    {
        $actor = new Actor();

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_actor_by_id(%s)", $actorId);

        try {
            $actor->setActorId($result[0]["actor_id"]);
            $actor->setActorName($result[0]["actor_name"]);
        } catch (Exception) {
            return null;
        } finally {
            $conn->disconnect();
        }

        return $actor;
    }

    public static function UpdateActor(int $id, string $name): bool
    {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_update_actor(%s, %s)", $id, $name);

        $conn->disconnect();

        return $conn->affected_rows > 0;
    }

    public static function AddActor(int$movie_id, string $actor_name): bool
    {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_insert_actor(%s, %s)", $movie_id, $actor_name);

        $conn->disconnect();

        return true;
    }

    public static function DeleteActor(int $actorId): bool
    {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_delete_actor(%s)", $actorId);

        $conn->disconnect();

        return true;
    }

    public static function DeleteMovieActor(int $movieId, int $actorId): bool
    {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_delete_movie_actor(%s, %s)", $movieId, $actorId);

        $conn->disconnect();

        return true;
    }
}

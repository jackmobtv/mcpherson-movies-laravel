<?php

namespace App\Models\shared;

use MeekroDB;
use PDO;

class MySQLConnect
{
    public static function GetConnection(): MeekroDB {
        $dsn = "mysql:host=".env("DB_HOST").";dbname=".env('DB_DATABASE');
        $user = env("DB_USERNAME");
        $password = env("DB_PASSWORD");

        return new MeekroDB($dsn, $user, $password);
    }

    public static function GetMb3Connection(): MeekroDB {
        $dsn = "mysql:host=".env("DB_HOST").";dbname=".env('DB_DATABASE');
        $user = env("DB_USERNAME");
        $password = env("DB_PASSWORD");
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8mb3' COLLATE 'utf8mb3_general_ci'",
        ];

        return new MeekroDB($dsn, $user, $password, $options);
    }
}

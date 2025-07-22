<?php

namespace App\Models\shared;

use MeekroDB;

class MySQLConnect
{
    public static function GetConnection(): MeekroDB {
        $dsn = "mysql:host=".env("DB_HOST").";dbname=".env('DB_DATABASE');
        $user = env("DB_USERNAME");
        $password = env("DB_PASSWORD");

        return new MeekroDB($dsn, $user, $password);
    }
}

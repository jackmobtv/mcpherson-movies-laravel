<?php

namespace App\Models\shared;

class Validators
{
    public static function isValidEmail(string $email) : bool{
        $regex = "^[a-zA-Z0-9_+&*-]+(?:\\.[a-zA-Z0-9_+&*-]+)*@(?:[a-zA-Z0-9-]+\\.)+[a-zA-Z]{2,}$^";
        return preg_match($regex, $email) == 1;
    }

    public static function isValidPhone(string $phone) : bool{
        $regex = "^\\D?(\\d{3})\\D?\\D?(\\d{3})\\D?(\\d{4})$^";
        return preg_match($regex, $phone) == 1;
    }

    public static function isStrongPassword(string $password) : bool{
        return (strlen($password) >= 7 && strlen($password) <= 20);
    }
}

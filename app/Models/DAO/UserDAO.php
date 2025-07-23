<?php

namespace App\Models\DAO;

use App\Models\shared\MySQLConnect;

class UserDAO
{
    public static function addUser($email, $password, $dob) : bool {
        $conn = MySQLConnect::GetConnection();

        try {
            $conn->query("CALL sp_new_user(%s,%s,%s)", $email, $password, $dob);

            return $conn->affected_rows > 0;
        } catch (Exception $ex) {
            return false;
        } finally {
            $conn->disconnect();
        }
    }
}

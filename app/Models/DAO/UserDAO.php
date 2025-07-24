<?php

namespace App\Models\DAO;

use App\Models\shared\MySQLConnect;
use App\Models\User;
use DateTime;
use Exception;

class UserDAO
{
    public static function addUser($email, $password, $dob) : bool {
        $hashedPassword = hash('sha256', $password);
        $conn = MySQLConnect::GetConnection();

        try {
            $conn->query("CALL sp_new_user(%s,%s,%s)", $email, $hashedPassword, $dob);

            return $conn->affected_rows > 0;
        } catch (Exception) {
            return false;
        } finally {
            $conn->disconnect();
        }
    }

    public static function auth($email, $password) : ?User {
        $hashedPassword = hash('sha256', $password);
        $conn = MySQLConnect::GetConnection();

        try {
            $result = $conn->query("CALL sp_authenticate_user(%s,%s)", $email, $hashedPassword);

            if($result != null){
                $user = new User();

                $user->setUserId($result[0]['user_id']);
                $user->setFirstName($result[0]['first_name']);
                $user->setLastName($result[0]['last_name']);
                $user->setPhone($result[0]['phone']);
                $user->setEmail($email);
                $user->setLanguage($result[0]['language']);
                $user->setStatus($result[0]['status']);
                $user->setPrivileges($result[0]['role_name']);
                $user->setCreatedAt(new DateTime($result[0]['created_at']));
                $user->setTimezone($result[0]['timezone']);
                $user->setDateofbirth(new DateTime($result[0]['dateofbirth']));
                $user->setPronouns($result[0]['pronouns']);
                $user->setDescription($result[0]['description']);

                return $user;
            } else {
                return null;
            }
        } catch (Exception $ex) {
            dd($ex->getMessage());
            return null;
        }
    }
}

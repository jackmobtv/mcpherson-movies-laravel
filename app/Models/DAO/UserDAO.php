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
                $user->setPhone($result[0]['phone'] == null ? null : $result[0]['phone']);
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
            return null;
        }
    }

    public static function upgrade(int $userId) : bool {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_upgrade_user(%s)", $userId);

        $conn->disconnect();

        return true;
    }

    public static function getAll() : array
    {
        $users = [];

        $conn = MySQLConnect::GetConnection();

        $result = $conn->query("CALL sp_get_all_users(0,0)");

        foreach($result as $row){
            $user = new User();

            $user->setUserId($row['user_id']);
            $user->setFirstName($row['first_name']);
            $user->setLastName($row['last_name']);
            $user->setPhone($row['phone'] == null ? null : $result[0]['phone']);
            $user->setEmail($row['email']);
            $user->setLanguage($row['language']);
            $user->setStatus($row['status']);
            $user->setPrivileges($row['role_name']);
            $user->setCreatedAt(new DateTime($row['created_at']));
            $user->setTimezone($row['timezone']);
            $user->setDateofbirth(new DateTime($row['dateofbirth']));
            $user->setPronouns($row['pronouns']);
            $user->setDescription($row['description']);

            $users[] = $user;
        }

        $conn->disconnect();

        return $users;
    }

    public static function get($id) : ?User {
        $conn = MySQLConnect::GetConnection();

        try {
            $result = $conn->query("CALL sp_get_user_by_id(%s)", $id);

            if($result != null){
                $user = new User();

                $user->setUserId($result[0]['user_id']);
                $user->setFirstName($result[0]['first_name']);
                $user->setLastName($result[0]['last_name']);
                $user->setPhone($result[0]['phone'] == null ? null : $result[0]['phone']);
                $user->setEmail($result[0]['email']);
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
            return null;
        }
    }

    public static function getByEmail($email) : ?User {
        $conn = MySQLConnect::GetConnection();

        try {
            $result = $conn->query("CALL sp_get_user_by_email(%s)", $email);

            if($result != null){
                $user = new User();

                $user->setUserId($result[0]['user_id']);
                $user->setFirstName($result[0]['first_name']);
                $user->setLastName($result[0]['last_name']);
                $user->setPhone($result[0]['phone'] == null ? null : $result[0]['phone']);
                $user->setEmail($result[0]['email']);
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
            return null;
        }
    }

    public static function deactivate(int $userId) : bool {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_deactivate_user(%s)", $userId);

        $conn->disconnect();

        return true;
    }

    public static function activate(int $userId) : bool {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_activate_user(%s)", $userId);

        $conn->disconnect();

        return true;
    }

    public static function update(User $user) : bool {
        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_update_user_profile(%s,%s,%s,%s,%s,%s,%s,%s,%s)", $user->getUserId(),$user->getFirstName(),$user->getLastName(),
            $user->getEmail(), $user->getPhone(),$user->getLanguage(),$user->getTimezone(),$user->getPronouns(),$user->getDescription());

        $conn->disconnect();

        return true;
    }

    public static function delete(string $email, string $password) : bool {
        $hashedPassword = hash('sha256', $password);

        $conn = MySQLConnect::GetConnection();

        $conn->query("CALL sp_delete_user(%s,%s)", $email, $hashedPassword);

        $conn->disconnect();

        return true;
    }
}

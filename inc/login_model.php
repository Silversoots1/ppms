<?php
class Login {

    function getUser(string $username, string $password)
    {
        $query = sprintf('SELECT * FROM users WHERE username = "%s"', $username);
        $database = new Database;

        return $database->readFromDatabase($query);
    }

    function isUsernameWrong(bool|array $result): bool
    {
        if (!$result) {
            return true;
        } else {
            return false;
        }
    }

    function isPasswordWrong(string $password, string $hashed_password): bool
    {
        if(!password_verify($password, $hashed_password))
        {
            return true;
        } else {
            return false;
        }
    }
    public function isLogedIn(): void
    {
        if(!isset($_SESSION['user_id']))
        {
            header("Location: ../index.php");
            die;
        }
    }
}
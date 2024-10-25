<?php
include 'header.php';

    class SaveUserInfo
    {
        private function checkUserInput(): bool
        {
                return isset($_POST["user_first_name"]) && 
                isset($_POST["user_last_name"]) && 
                isset($_POST["username"]) && 
                isset($_POST["password"]) && 
                isset($_POST["user_date_of_birth"]) &&
                $this->checkDate($_POST["user_date_of_birth"]) &&
                isset($_POST["user_gender"]);
        }

        private function checkDate($date): bool
        {
            $explode_date = explode('-', $date);
            if(count($explode_date) === 3)
            {
                return checkdate($explode_date[1], $explode_date[2], $explode_date[0]);
            } else {
                return false;
            }

        }

        private function saveToDatabase(): array 
        {
            require_once ('database.php');

            $query = sprintf('
                insert into users(username, password, first_name, last_name, date_of_birth, gender, address)
                VALUES("%s", "%s", "%s", "%s", "%s", "%s", "%s");', 
                htmlspecialchars($_POST["username"]),
                password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT),
                htmlspecialchars($_POST["user_first_name"]),
                htmlspecialchars($_POST["user_last_name"]),
                $_POST["user_date_of_birth"],
                htmlspecialchars($_POST["user_gender"]),
                htmlspecialchars($_POST["user_address"])
            );
            $database = new Database;
            $database->writeToDatabase($query);

            return [
                'username'=> $_POST["username"], 
                'user_first_name'=> $_POST["user_first_name"], 
                'user_last_name'=> $_POST["user_last_name"], 
                'user_date_of_birth'=> $_POST["user_date_of_birth"], 
                'user_gender'=> $_POST["user_gender"], 
                'user_address'=> $_POST["user_address"]
            ];
        }

        public function saveAndCheck(): void
        {
            require_once ('change_user_info.php');
            
            if($this->checkUserInput())
            {
                $saved_values = $this->saveToDatabase();
                $_SESSION['user_info'] = $saved_values;

                header("Location: change_user_info.php?ssuccess=true");
                die;
            } else {
                header("Location: change_user_info.php?ssuccess=false");
                die;
            }

        }
    }
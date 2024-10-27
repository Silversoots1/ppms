<?php
    class SaveUserInfo
    {
        private function checkUserInput(): bool
        {
                return isset($_POST["first_name"]) && 
                isset($_POST["last_name"]) && 
                isset($_POST["username"]) && 
                isset($_POST["password"]) && 
                isset($_POST["date_of_birth"]) &&
                $this->checkDate($_POST["date_of_birth"]) &&
                isset($_POST["gender"]);
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
                INSERT INTO users(username, password, first_name, last_name, date_of_birth, gender, address)
                VALUES("%s", "%s", "%s", "%s", "%s", "%s", "%s");', 
                htmlspecialchars($_POST["username"]),
                password_hash(htmlspecialchars($_POST["password"]), PASSWORD_BCRYPT),
                htmlspecialchars($_POST["first_name"]),
                htmlspecialchars($_POST["last_name"]),
                $_POST["date_of_birth"],
                htmlspecialchars($_POST["gender"]),
                htmlspecialchars($_POST["user_address"])
            );

            $_SESSION['username'] = htmlspecialchars($_POST['username']);

            $database = new Database;
            $database->writeToDatabase($query);

            return [
                'username'=> $_POST["username"], 
                'first_name'=> $_POST["first_name"], 
                'last_name'=> $_POST["last_name"], 
                'date_of_birth'=> $_POST["date_of_birth"], 
                'gender'=> $_POST["gender"], 
                'user_address'=> $_POST["user_address"]
            ];
        }

        public function saveAndCheck(): bool
        { 
            if($this->checkUserInput())
            {
                $saved_values = $this->saveToDatabase();
                $_SESSION['user_info'] = $saved_values;
                return true;
            } else {
                return false;
            }

        }
    }
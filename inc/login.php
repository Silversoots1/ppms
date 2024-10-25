<?php
require_once ('ErrorManagement.php');

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $username = $_POST["username"];
    $password = $_POST["password"];
    // var_dump(password_hash('1234', PASSWORD_BCRYPT));
    try {
        require_once ('database.php');
        require_once ('login_model.php');

        $login_class = new Login;
        $database = new Database;


        $errors = [];

        if(empty($username) || empty($password)){
            $errors['empty_input'] = 'Fill in all fields!';
        }

        $result = $login_class->getUser($username, $password);

        if($login_class->isUsernameWrong($result)){
            $errors['login_incorrect'] = 'Incorrect login! u';
        }

        if(!$login_class->isUsernameWrong($result, $username)  &&  $login_class->isPasswordWrong($password, $result['password'])){
            $errors['login_incorrect'] = 'Incorrect login! p';
        }

        require_once ('../config_session.php');

        if($errors)
        {
            $_SESSION['errors_login'] =  $errors;
            header("Location: ../index.php");
            die;
        }

        $_SESSION['user_id'] = $result['user_id'];
        $_SESSION['user_id'] = htmlspecialchars($result['username']);
        $_SESSION['last_regeneration'] = time();

        header("Location: ../index.php?login=success");
        $database->terminatePDO();
        die;


    } catch (PDOException $e) {
        $error_logging = new ErrorManagement;
        $error_logging->logErrorToFile($e , 'loggin');
        header("Location: ../index.php");                                           
        die;
    }
}
else
{
    header("Location: ../index.php");
    die;
}
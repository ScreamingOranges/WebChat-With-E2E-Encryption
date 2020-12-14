<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);

$email = $password = $confPassword ="";

if(isset($_POST['join']))
{
    session_start();
    require("../db/users.php");
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confPassword = $_POST["confPassword"];
    if($password == $confPassword)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
        {
            echo "Email is not valid! Please <a href='../registration.php'>Try again</a>";
            exit();
        }
        if (strlen($password) > 20 || strlen($password) < 5)
        {
            echo "Password must be between 5 and 20 characters long! Please <a href='../registration.php'>Try again</a>";
            exit();
        }

        $objUser = new users;
        $objUser->setEmail($_POST['email']);
        $userData = $objUser->getUserByEmail();
        $objUser->setName($_POST['uname']);
        $objUser->setPass($_POST['password']);
        $objUser->setLoginStatus(1);
        $objUser->setLastLogin(date('Y-m-d h:i:s'));

        if(is_array($userData) && count($userData) > 0)
        {
            echo '<h2>This email is already registered.</h2><a href="../index.php">Login please.</a>';
            exit();
        }
        else
        {
            if($objUser->save())
            {
                $lastId = $objUser->dbConn->lastInsertId();
                $objUser->setId($lastId);
                $_SESSION['user'][$lastId] = [
                    'id' => $objUser->getId(),
                    'name' => $objUser->getName(),
                    'email'=> $objUser->getEmail(),
                    'login_status'=>$objUser->getLoginStatus(),
                    'last_login'=> $objUser->getLastLogin()
                ];
                header("location: ../chatroom.php");
            }
            else
            {
                echo "Failure to register new user!";
            }
        }
    }
    else
    {
        echo "MIS-MATCH PASS, Try again... <a href='../registration.php'>Registration</a>";
        exit();
    }

}
else
{
    header("location: ../registration.php");
}

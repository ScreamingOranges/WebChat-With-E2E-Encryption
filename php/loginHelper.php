<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);

if(isset($_POST['join']))
{
    session_start();

    require("../db/users.php");
    require("../db/publickeys.php");

    $objUser = new users;
    $objUser->setEmail($_POST['email']);
    $objUser->setLoginStatus(1);
    $objUser->setLastLogin(date('Y-m-d h:i:s'));
    $pass = $_POST['password'];
    $userData = $objUser->getUserByEmail();
    $publicKey = trim($_POST['publicKey']);

    if(is_array($userData) && count($userData) > 0)
    {
        $storedPass = $userData['password'];
        if(!password_verify($pass, $storedPass))
        {
            echo '<h2>Incorrect credentials.</h2><a href="../index.php">Try again or register.</a>';
            exit();
        }
        $objUser->setId($userData['id']);
        if($objUser->updateLoginStatus())
        {
            $objKey = new publickeys;
            $objKey->setUserId($userData['id']);
            $objKey->setKey($publicKey);
            $objKey->setCreatedOn(date("Y-m-d h:i:s"));

            if(empty($objKey->existsPublicKeys()))
            {
                if($objKey->savePublicKey())
                {
                    $_SESSION['user'][$userData['id']] = $userData;
                    header("location: ../chatroom.php");
                }
            }
            else
            {
                if($objKey->updatePublicKey())
                {
                    $_SESSION['user'][$userData['id']] = $userData;
                    header("location: ../chatroom.php");
                }
            }
        }
        else
        {
            echo "Failed to login.";
        }
    }
    else
    {
        echo '<h2>Incorrect credentials.</h2><a href="../index.php">Try again or register.</a>';
        exit();
    }
}
else
{
    header("location: ../index.php");
}
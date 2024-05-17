<?php
require_once 'form.php';
require_once 'controller.php';
require_once 'utility.php';

session_start();

// if user already logged in, redirect to home page
if (isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $password = "";

    $username = fix_string($_POST['username']);
    if (isset($_POST['password']))
        $password = fix_string($_POST['password']);

    $fail = validate_username($username);
    $fail .= validate_password($password);


    // If no errors, store user into database
    if ($fail === '') {
        // Store to DB code...
        $user = login($username, $password);

        if (isset($_POST['remember_me'])){
            setcookie('username',$_POST['username'], time() + (86400),"/"); // save cookie 1 day
        }

        if (is_string($user)) {
            $fail .= $user;
            //displayLoginForm($fail);
            displayForm($fail);
            exit;
        }

        // Store user to Session
        storeSession($user);

        // Redirect to home page
        header('Location: index.php');

        exit;
    }

    // If there are errors, display the signup form again with error messages.
    //displayLoginForm($fail);
    displayForm($fail);
}



function validate_username($field)
{
    if ($field === "") return "No Username was entered <br>";
    else if (strlen($field) < 5)
        return "Username must be at least 5 characters <br>";
    else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
        return "Only letters, numbers, - and _ in username <br>";
    return "";
}


function validate_password($field)
{
    if ($field === "") return "No Password was entered <br>";
    else if (strlen($field) < 6)
        return "Password must be at least 6 characters <br>";
    else if (!preg_match("/[a-z]/", $field) || !preg_match("/[A-Z]/", $field) || !preg_match("/[0-9]/", $field))
        return "Password requires 1 each of a-z, A-Z, and 0-9 <br>";
    return "";
}

?>
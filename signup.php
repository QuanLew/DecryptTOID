<?php // signup.php
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
    if (isset($_POST['username']))
        $username = fix_string($_POST['username']);
    if (isset($_POST['password']))
        $password = fix_string($_POST['password']);
    if (isset($_POST['email']))
        $email = fix_string($_POST['email']);

    $fail .= validate_username($username);
    $fail .= validate_password($password);
    $fail .= validate_email($email);

    // If no errors, store user into database
    if ($fail === '') {
        // Store to DB code...
        $userId = createUser($username, $email, $password);

        if (is_string($userId)) {
            //echo "fail sign!\n";
            $fail .= $userId;
            displayForm($fail);
            exit;
        }

        // Get user by Id
        $user = getUserById($userId);

        // Store user to Session
        storeSession($user);

        // Redirect to home page
        header('Location: index.php');

        exit;
    }

    // If there are errors, display the signup form again with error messages.
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

function validate_email($field)
{
    if ($field === "") return "No Email was entered <br>";
    else if (!((strpos($field, ".") > 0 && (strpos($field, "@") > 0)) || preg_match("/[^a-zA-Z0-9.@_-]/", $field)))
        return "Invalid email format";
}
<?php

function storeInfoCipher($info)
{
    session_start();

    ini_set('session.gc_maxlifetime', 60 * 60 * 24); // 1 day expiry

    //var_export(ini_get('session.gc_maxlifetime'));

    try {
        // Store cipher information to SESSION
        $_SESSION['info'] = $info;
        //echo "saved\n";
        return;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function storeResultCipher($result){
    session_start();

    ini_set('session.gc_maxlifetime', 60 * 60 * 24); // 1 day expiry

    //var_export(ini_get('session.gc_maxlifetime'));

    try {
        // Store cipher information to SESSION
        $_SESSION['result'] = $result;
        // echo "saved\n";
        return;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function storeSession($user)
{
    session_start();

    ini_set('session.gc_maxlifetime', 60 * 60 * 24); // 1 day expiry

    var_export(ini_get('session.gc_maxlifetime'));

    try {
        // Store user information to SESSION
        $_SESSION['id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];

        return;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}

function fix_string($string)
{
    $string = stripslashes($string);
    return htmlentities($string);
}
?>
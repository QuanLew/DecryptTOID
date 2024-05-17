<?php
// save data to sql

require_once 'connection.php';

function hashPassword($rawPassword)
{
    // Add 2 salts to the hashed password to prevent brute force attack
    $salt1 = 'qm&h*';
    $salt2 = 'pg!@';
    $token = hash('ripemd128', "$salt1$rawPassword$salt2");
    return $token;
}

// Function to create user database table
function createUserTable()
{   
    $conn = getConnection();

    // Create table to store info of user
    $query = "CREATE TABLE IF NOT EXISTS users (
        id INT NOT NULL AUTO_INCREMENT,
        username VARCHAR(30) NOT NULL,
        email VARCHAR(25) NOT NULL,
        password VARCHAR(256) NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY(username)
    )";
    
    $result = $conn->query($query);
    $conn->close();

    if (!$result) die($conn->error);
}

// Function to create file database table
function createFileTable()
{
    $conn = getConnection();
    $conn->set_charset('utf8mb4');

    // Create table to store file content
    $query = "CREATE TABLE IF NOT EXISTS ciphers (
        id_cipher INT NOT NULL AUTO_INCREMENT,
        cipher_name VARCHAR(30) NOT NULL,
        encrypt_text TEXT,
        decrypt_text TEXT,
        timerecord VARCHAR(255) NOT NULL,
        username VARCHAR(30) NOT NULL,
        PRIMARY KEY (id_cipher),
        FOREIGN KEY (username) REFERENCES users(username),
        UNIQUE KEY(timerecord)
    )";

    $result = $conn->query($query);
    $conn->close();

    if (!$result) die($conn->error);
}

function login($username, $password)
{
    try {
        $conn = getConnection();

        $hashPw = hashPassword($password);
        $stmt = $conn->prepare("SELECT * FROM users WHERE username=? AND password=?");
        $stmt->bind_param("ss", $username, $hashPw);

        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            while ($row = $result->fetch_assoc()) {
                return $row;
            }
        }
        $stmt->close();
        $conn->close();

        return 'Invalid Credentials';
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        $stmt->close();
        $conn->close();
    }
}

function createUser($username, $email, $password)
{
    if (usernameExists($username)) return "Username already exists!";
    if (emailExists($email)) return "Email already exists!";

    try {
        $conn = getConnection();

        $hashPw = hashPassword($password);

        // Insert new user if no duplicate user found.
        $stmt = $conn->prepare("INSERT INTO users (id, username, email, password) VALUES (NULL, ?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashPw);
        $stmt->execute();

        $userId = $conn->insert_id;
        $stmt->close();
        $conn->close();

        return $userId;
    } catch (Exception $e) {
        $stmt->close();
        $conn->close();
        echo "Error: " . $e->getMessage();
    }
}

function createCipher($username, $cipher_name ,$encrypt_content, $decrypt_content, $time_record)
{
    try {
        $conn = getConnection();

        // Insert new ciphers
        $stmt = $conn->prepare("INSERT INTO ciphers (id_cipher, cipher_name, encrypt_text, decrypt_text, timerecord, username) VALUES (NULL, ?, ?, ?, ?, ( SELECT username FROM users WHERE id = '" . $_SESSION['id'] . "' ))");
        $stmt->bind_param("ssss", $cipher_name, $encrypt_content, $decrypt_content, $time_record);
        $stmt->execute();

        $cipherId = $conn->insert_id;
        $stmt->close();
        $conn->close();

        return $cipherId;
    } catch (Exception $e) {
        $stmt->close();
        $conn->close();
        echo "Error: " . $e->getMessage();
    }
}

function usernameExists($username)
{
    try {
        $conn = getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();

        $result = $stmt->get_result()->num_rows > 0;

        $stmt->close();
        $conn->close();

        return ($result);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        $stmt->close();
        $conn->close();
    }
}

function emailExists($email)
{
    try {
        $conn = getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result()->num_rows > 0;

        $stmt->close();
        $conn->close();

        return ($result);
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        $stmt->close();
        $conn->close();
    }
}

function getUserById($userId)
{
    try {
        $conn = getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $stmt->close();
        $conn->close();

        return $user;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        $stmt->close();
        $conn->close();
    }
}

function getAllRecordCipher($username)
{
    try {
        $conn = getConnection();

        $stmt = $conn->prepare("SELECT * FROM ciphers WHERE username = ? ORDER BY id_cipher");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        //$cipher = $result->fetch_assoc();

        $cipher = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->close();
        $conn->close();

        return $cipher;
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
        $stmt->close();
        $conn->close();
    }
}

?>
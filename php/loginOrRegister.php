<?php
session_start();
require("dbConnection.php");
require("userDAO.php");

// GET request if the user is trying to log in
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!empty($_GET["login"]) && !empty($_GET["password"])) {
        $username = $_GET["login"];
        $password = $_GET["password"];
    
        $pdo = createConnection();
    
        // If the password corresponds to the given username's password
        if (passwordValid($pdo, $username, $password)) {
            $user = getUserByUsername($pdo, $username);
            // Create a session for the user
            $_SESSION["username"] = $username;
            $_SESSION["pfp"] = $user["pfp"];
            // Head to the main page
            header("Location: ../chat.php");
            exit();
        } 
    } else if (!empty($_GET["logout"])) {
        session_unset();
    }
    // Else, head back to the login with an error popup
    header("Location: ../index.php?passlogin=false");
    exit();
// POST request if the user is trying to create an account
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (empty($_SESSION["login"] || empty($_SESSION["password"]) || empty($_SESSION["password-verify"]))) {
        // Head back to the register page
        header("Location: ../register.html");
        exit();
    }

    $username = $_POST["login"];
    $password = $_POST["password"];
    $passwordverify = $_POST["password-verify"];

    $pdo = createConnection();

    // Check if the username is already taken
    $usernameTaken = usernameTaken($pdo, $username);
   
    if (!$usernameTaken) {
        // if the first and second passwords are different OR
        if (($password !== $passwordverify) ||
            // the login or the password contains a space character OR
            (preg_match('/[ ]/', $login) || preg_match('/[ ]/', $password)) ||
            // the length of the password is lesser than 8 OR
            strlen($password) < 8 ||
            // the password does not contain a special character OR
            !preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password) ||
            // the password does not contain a capital letter OR
            !preg_match('/[A-Z]/', $password) ||
            // the password does not contain a number THEN
            !preg_match('/[0-9]/', $password)) {
                
                // Head back to the register page
                header("Location: ../register.html");
                exit();
        } else {
            // else, add a new user with the given username and password
            addUser($pdo, $username, $password);
            header("Location: ../index.php?created=true");
            exit();
        }
    } else {
        // Head back to the register page
        header("Location: ../register.html");
        exit();
    }
} else {
    // Head back to the login page
    header("Location: ../index.php");
    exit();
}
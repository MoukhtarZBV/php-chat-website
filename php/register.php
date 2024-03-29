<?php
session_start();
require("dbConnection.php");
require("userDAO.php");
require("loggedUsers.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (empty($_POST["login"]) ||
        empty($_POST["password"]) ||
        empty($_POST["password-verify"])) {
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
        // if both passwords are different OR
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
    }
} else {
    // Head back to the register page
    header("Location: ../register.html");
    exit();
}
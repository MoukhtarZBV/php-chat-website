<?php
session_start();
if (empty($_SESSION)) {
    exit();
}

require "dbConnection.php";
require "messageDAO.php";
require "userDAO.php";

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // If the message content and the username of the sender are set
    if (!empty($_GET["message"]) &&
        !empty($_SESSION["username"])) {

            $message = $_GET["message"];
            $username = $_SESSION["username"];

            $pdo = createConnection();
            updateLastSeen($pdo, $_SESSION["username"]);

            // Add a new message for the specified user
            echo addMessage($pdo, $message, $username);
    } else {
        echo false;
    }
}
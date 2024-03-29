<?php
require "dbConnection.php";
require "userDAO.php";

$pdo = createConnection();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    // If the username is set
    if (!empty($_GET["username"])) {
        // Returns TRUE if the username is taken, FALSE else
        echo usernameTaken($pdo, $_GET["username"]);
    } 
}
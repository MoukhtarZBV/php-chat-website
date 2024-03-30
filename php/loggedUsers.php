<?php
session_start();
if (empty($_SESSION)) {
    exit();
}

require "userDAO.php";
require "dbConnection.php";

$pdo = createConnection();

// Fetching all logged users
$loggedUsers = allLoggedUsers($pdo);

// For each logged user, build a div containing hes informations
foreach ($loggedUsers as $loggedUser) {
    echo    '<div class="logged-user">
                <img class="logged-user-pfp" src="images/pfp/' . $loggedUser["pfp"] . '">
                <span class="logged-user-username">' . $loggedUser["username"] . '</span>
            </div>';
}
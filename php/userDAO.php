<?php

/**
 * Returns TRUE if the given username is taken, FALSE else
 *
 * @param  PDO $pdo         PDO database connection
 * @param  string $username User's username
 * @return bool
 */
function usernameTaken(PDO $pdo, string $username) : bool {
    $stmt = $pdo->prepare("SELECT username FROM userJS WHERE username = ?");
    if (!$stmt || !$stmt->execute([$username])) {
        return false;
    }

    if ($stmt->fetch()) {
        return true;
    }
    return false;
}

/**
 * Checks if the hash of the password entered by the user matches the hashed password stored in the database for the specified username.
 *
 * @param  PDO $pdo         PDO database connection
 * @param  string $username User's username
 * @param  string $password User's password
 * @return bool
 */
function passwordValid(PDO $pdo, string $username, string $password) : bool {
    $stmt = $pdo->prepare("SELECT username, password FROM userJS WHERE username = ?");
    if ($stmt && $stmt->execute([$username]) && 
        $user = $stmt->fetch(PDO::FETCH_ASSOC)) {    
        if ($user["password"] && (password_verify($password, $user["password"]))) {
            return true;
        }
    }
    return false;
}

/**
 * Adds an user to the database
 *
 * @param  PDO $pdo         PDO database connection
 * @param  string $username User's username
 * @param  string $password User's password
 */
function addUser(PDO $pdo, string $username, string $password) : bool {
    $stmt = $pdo->prepare("INSERT INTO userJS (username, password, pfp) VALUES (?, ?, ?)");

    $pfpPath = "random-profile-picture (" . rand(1, 55) . ").png"; 
    $password = password_hash($password, PASSWORD_DEFAULT);
    if (!$stmt || !$stmt->execute([$username, $password, $pfpPath])) {
        return false;
    }
    return true;
}

/**
 * Returns the user with the given username from the database 
 *
 * @param PDO $pdo          PDO database connection
 * @param string $username  User's username
 * @return array | bool     FALSE if the query failed, an array (potentialy empty) else
 */
function getUserByUsername(PDO $pdo, string $username) : array | bool {
    $stmt = $pdo->prepare("SELECT * FROM userJS WHERE username = ?");

    if (!$stmt || !$stmt->execute([$username])) {
        return false;
    }
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

/**
 * Updates the given user's "last seen" column
 *
 * @param PDO $pdo          PDO database connection
 * @param string $username  User's username
 * @return boolean          FALSE if the update failed, TRUE else 
 */
function updateLastSeen(PDO $pdo, string $username) : bool {
    $stmt = $pdo->prepare("UPDATE userJS SET lastseen = ? WHERE username = ?");
    if (!$stmt || !$stmt->execute([date("Y-m-d H:i:s"), $username])) {
        return false;
    }
    return $stmt->rowCount() > 0;
}

/**
 * Retrieves all logged users, based on their "last seen" column
 *
 * @param PDO $pdo          PDO database connection
 * @return bool | array     FALSE if the query failed, an array containing every (or none) logged users else
 */
function allLoggedUsers(PDO $pdo) : bool | array {
    $stmt = $pdo->prepare("SELECT * FROM userJS WHERE lastSeen > ?");
    if (!$stmt || !$stmt->execute([date("Y-m-d H:i:s", strtotime("-2 seconds"))])) {
        return false;
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

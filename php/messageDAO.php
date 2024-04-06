<?php

/**
 * Retrieves the last 10 messages from the database
 *
 * @param PDO $pdo          PDO database connection
 * @return bool | array     FALSE if the query failed, array with the last 10 messages else
 */
function get10LastMessages(PDO $pdo) : array | bool {
    $stmt = $pdo->prepare("SELECT chatjs.*, UNIX_TIMESTAMP(CONVERT_TZ(FROM_UNIXTIME(horaire), 'UTC', 'Europe/Paris')) as horaire FROM chatjs ORDER BY horaire DESC LIMIT 10");

    if (!$stmt || !$stmt->execute()) {
        return false;
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/**
 * Adds a message to the database
 *
 * @param PDO $pdo          PDO database connection 
 * @param string $message   Message content to add
 * @param string $username  Message sender's username
 * @return boolean          TRUE if the message was successfully added, FALSE else
 */
function addMessage(PDO $pdo, string $message, string $username) : bool {
    $arguments = ['contenu' => $message, 'userPseudo' => $username, 'horaire' => time()];
    $stmt = $pdo->prepare("INSERT INTO chatjs(contenu, userPseudo, horaire) VALUES (:contenu, :userPseudo, :horaire)");
    return $stmt && $stmt->execute($arguments);
}
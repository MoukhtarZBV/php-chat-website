<?php

function get10LastMessages(PDO $pdo) : array | bool {
    $stmt = $pdo->prepare("SELECT * FROM chatJS ORDER BY horaire DESC LIMIT 10");

    if (!$stmt || !$stmt->execute()) {
        echo "redirect";
        return false;
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

/*
$messages = get10LastMessages();
foreach ($messages as $message) {
    echo 
}*/
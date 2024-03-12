<?php

function enregister(PDO $pdo, string $message, $pseudo) {
    if (!$message || $pseudo) {
        return;
    }

    $arguments = ['contenu' => $message, 'userPseudo' => $pseudo, 'horaire' => time()];

    $stmt = $pdo->prepare("INSERT INTO chatJS(contenu, userPseudo, horaire) VALUES(:contenu, :userPseudo, :horaire)");
    if (!$stmt || !$stmt->execute($arguments))
        echo "redirect";
}

require 'dbConnection.php';

$message = $_POST['message'];
$pseudo = $_POST['pseudo'];

enregistrer($pdo, $message, $pseudo);
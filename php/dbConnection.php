<?php
function createConnection() : PDO {
    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=mysql-medical-office-ressources.alwaysdata.net;dbname=medical-office-ressources_chat;charset=utf8', '350739', '$iutinfo');
    } catch (Exception $e) {
        echo("Failed to load database");
        exit(1);
    }
    return $pdo;
}
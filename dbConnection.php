<?php
function createConnection() : PDO {
    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=minichat;charset=utf8', 'root', '');
        //$pdo = new PDO('mysql:host=mysql-medical-office-ressources.alwaysdata.net;dbname=medical-office-ressources_chat;charset=utf8', '350739', '$iutinfo');
    } catch (Exception $e) {
        echo("Failed to connect to database");
        exit(1);
    }
    return $pdo;
}
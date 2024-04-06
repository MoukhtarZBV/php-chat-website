<?php
function createConnection() : PDO {
    $pdo = null;
    try {
        $pdo = new PDO('mysql:host=mysql-mz-works.alwaysdata.net;dbname=mz-works_minichat;charset=utf8', 'mz-works', '$iutinfo');
    } catch (Exception $e) {
        echo("Failed to connect to database");
        exit(1);
    }
    return $pdo;
}
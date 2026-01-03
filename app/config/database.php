<?php

$host = "mysql";
$port = 3306;
$dbname = "crud_app";
$user = "cruduser";
$pass = "password123";

try {
    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8",
        $user,
        $pass
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion DB : " . $e->getMessage());
}

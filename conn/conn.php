<?php
function getConnection()
{
    $host = "localhost";
    $db_name = "inova";
    $user = "root";
    $password = "root";
    try {
        $conn = new PDO("mysql:host=$host;dbname=$db_name", $user, $password);
        return $conn;
    } catch (PDOException $e) {
        return 'Ocorreu o seguinte erro: ' . $e->getMessage();
    }
}

$conn = getConnection();
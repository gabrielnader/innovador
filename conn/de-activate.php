<?php
require_once 'conn.php';

$id = $_POST['id'];
$action = isset($_POST['desativar']) ?  0 : 1;

$sql = "UPDATE `pacientes` SET `active`= " . $action . " WHERE `id`= $id";

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $conn->query($sql);

    echo 'Paciente alterado com sucesso!';
    if($action == 1){
        header("Location: ../pacientes.php");
    }else{
        header("Location: ../inativos.php");
    }
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

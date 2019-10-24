<?php
require_once 'conn.php';
include '../components/functions.php';

$cpf = (isset($_POST['cpf'])) ? $_POST['cpf'] : null;
$cpf = unmask($cpf);
$name = (isset($_POST['name'])) ? $_POST['name'] : null;
$birth = (isset($_POST['birth'])) ? $_POST['birth'] : null;
$mail = (isset($_POST['mail'])) ? $_POST['mail'] : null;
$address = (isset($_POST['address'])) ? $_POST['address'] : null;
$region = (isset($_POST['region'])) ? $_POST['region'] : null;
$complement = (isset($_POST['complement'])) ? $_POST['complement'] : null;
$city = (isset($_POST['city'])) ? $_POST['city'] : null;
$state = (isset($_POST['state'])) ? $_POST['state'] : null;
$zip = (isset($_POST['zip'])) ? $_POST['zip'] : null;
$zip = unmask($zip);
$phone1 = (isset($_POST['phone1'])) ? $_POST['phone1'] : null;
$phone1 = unmask($phone1);
$phone2 = (isset($_POST['phone2'])) ? $_POST['phone2'] : null;
$phone2 = unmask($phone2);
$obs = (isset($_POST['obs'])) ? $_POST['obs'] : null;
$indication = (isset($_POST['indication'])) ? $_POST['indication'] : null;
$respMail = (isset($_POST['resp-mail'])) ? $_POST['resp-mail'] : null;
$respPhone = (isset($_POST['resp-phone'])) ? $_POST['resp-phone'] : null;
$respPhone = unmask($respPhone);
$respName = (isset($_POST['resp-name'])) ? $_POST['resp-name'] : null;
$resp = (isset($_POST['resp'])) ? 1 : 0;
$active = 1;

$doctors = (isset($_POST['doctors'])) ? $_POST['doctors'] : null;

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare('INSERT INTO pacientes (cpf, name, birth, email, address, region, complement, city, state, zip, phone_primary, phone_secondary, observations, indication, resp_email, resp_phone, resp_name, resp_primary, active) VALUES(:cpf, :name, :birth, :email, :address, :region, :complement, :city, :state, :zip, :phone_primary, :phone_secondary, :observations, :indication, :resp_email, :resp_phone, :resp_name, :resp_primary, :active)');
    $stmt->execute(array(
        ':cpf' => $cpf,
        ':name' => $name,
        ':birth' => $birth,
        ':email' => $mail,
        ':address' => $address,
        ':region' => $region,
        ':complement' => $complement,
        ':city' => $city,
        ':state' => $state,
        ':zip' => $zip,
        ':phone_primary' => $phone1,
        ':phone_secondary' => $phone2,
        ':observations' => $obs,
        ':indication' => $indication,
        ':resp_email' => $respMail,
        ':resp_phone' => $respPhone,
        ':resp_name' => $respName,
        ':resp_primary' => $resp,
        ':active' => $active,
    ));

    $paciente_id = $conn->lastInsertId();

    foreach ($doctors as $value) {
        $stmt = $conn->prepare('INSERT INTO relacao (medico_id, paciente_id) VALUES (:medico_id, :paciente_id)');
        $stmt->execute(array(
          ':medico_id' => $value,
          ':paciente_id' => $paciente_id
        ));
    }

    header('Location: ../index.php');
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

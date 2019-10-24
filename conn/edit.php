<?php
require_once 'conn.php';
include '../components/functions.php';

$id = $_POST['id'];
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
$active = $_POST['active'];

$relations = $_POST['rel_id'];
$doctors = $_POST['doctors'];
$docs_before = $_POST['alldocs'];

$docs_new_arr = [];
foreach ($doctors as $doc) {
    array_push($docs_new_arr, $doc);
}
$docs_new = implode(',', $docs_new_arr);
$docs_before_arr = explode(',', $docs_before);

try {
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $conn->prepare('UPDATE pacientes SET cpf = :cpf, name = :name, birth = :birth, email = :email, address = :address, region = :region, complement = :complement, city = :city, state = :state, zip = :zip, phone_primary = :phone_primary, phone_secondary = :phone_secondary, observations = :observations, doctor = :doctor, indication = :indication, resp_email = :resp_email, resp_phone = :resp_phone, resp_name = :resp_name, resp_primary = :resp_primary WHERE id = :id');
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
        ':id' => $id,
    ));

    $paciente_id = $id;

    if ($docs_before_arr == $docs_new_arr) {
        echo 'Nada a mudar aqui';
    } else {
        if (array_diff($docs_before_arr, $docs_new_arr)) {
            foreach (array_diff($docs_before_arr, $docs_new_arr) as $insert_doc) {
                $inner_join_sql = 'SELECT r.id "Relacao"
                FROM relacao r
                INNER JOIN pacientes p ON r.paciente_id = p.id
                INNER JOIN medicos m ON r.medico_id = m.id
                WHERE p.id = ' . $id . ' AND m.id = ' . $insert_doc;
                $inner_join_action = $conn->query($inner_join_sql);
                $inner_array;
                while ($row = $inner_join_action->fetch()) {
                    $inner_array = $row;
                }
                $stmt = $conn->prepare('DELETE FROM relacao WHERE id = :id');
                $stmt->execute(array(
                    ':id' => $inner_array[Relacao],
                ));
            }
        }
        if (array_diff($docs_new_arr, $docs_before_arr)) {
            foreach (array_diff($docs_new_arr, $docs_before_arr) as $insert_doc) {
                $stmt = $conn->prepare('INSERT INTO relacao (medico_id, paciente_id) VALUES (:medico_id, :paciente_id)');
                $stmt->execute(array(
                    ':medico_id' => $insert_doc,
                    ':paciente_id' => $paciente_id,
                ));
            }
        }
    }

    if ($active == 1) {
        header("Location: ../pacientes.php");
    } else {
        header("Location: ../inativos.php");
    }
    die();
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}

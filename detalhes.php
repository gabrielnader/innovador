<?php
include 'components/header.php';
require_once 'conn/conn.php';

$id = $_POST['id'];

// SELECT DOCS
$sql = "SELECT * FROM medicos ORDER BY name";
$result = $conn->query($sql);
$rows = $result->fetchAll();

// SELECT PACIENTES
$consulta = $conn->query("SELECT * FROM pacientes WHERE id=" . $id . ";");
$paciente = $consulta->fetch(PDO::FETCH_ASSOC);

// INNER JOIN RELACAO
$sql_doc = 'select p.id "Paciente", m.id "Medico", r.id "Relacao"
            from relacao r
            INNER JOIN pacientes p ON r.paciente_id = p.id
            INNER JOIN medicos m ON r.medico_id = m.id
            WHERE p.id = ' . $id;
$result_doc = $conn->query($sql_doc);
$doctors = $result_doc->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="container">
    <form action="conn/edit.php" method="post" onsubmit="return validateDocs();">
        <input type="text" name="name" value="<?=$paciente[name]?>" require>
        <input type="date" name="birth" value="<?=$paciente[birth]?>" require>
        <input type="text" name="cpf" data-mask="000.000.000-00" value="<?=$paciente[cpf]?>" require>
        <input type="mail" name="mail" value="<?=$paciente[email]?>">
        <input type="text" class="celphones" name="phone1" value="<?=$paciente[phone_primary]?>" require>
        <input type="text" class="celphones" name="phone2" value="<?=$paciente[phone_secondary]?>">
        <input type="text" name="address" value="<?=$paciente[address]?>" require>
        <input type="text" name="complement" value="<?=$paciente[complement]?>">
        <input type="text" name="region" value="<?=$paciente[region]?>" require>
        <input type="text" name="city" value="<?=$paciente[city]?>" require>
        <select name="state" required>
            <option value="AC" <?=$paciente[state] == "AC" ? "selected" : null;?>>Acre</option>
            <option value="AL" <?=$paciente[state] == "AL" ? "selected" : null;?>>Alagoas</option>
            <option value="AP" <?=$paciente[state] == "AP" ? "selected" : null;?>>Amapá</option>
            <option value="AM" <?=$paciente[state] == "AM" ? "selected" : null;?>>Amazonas</option>
            <option value="BA" <?=$paciente[state] == "BA" ? "selected" : null;?>>Bahia</option>
            <option value="CE" <?=$paciente[state] == "CE" ? "selected" : null;?>>Ceará</option>
            <option value="DF" <?=$paciente[state] == "DF" ? "selected" : null;?>>Distrito Federal</option>
            <option value="ES" <?=$paciente[state] == "ES" ? "selected" : null;?>>Espírito Santo</option>
            <option value="GO" <?=$paciente[state] == "GO" ? "selected" : null;?>>Goiás</option>
            <option value="MA" <?=$paciente[state] == "MA" ? "selected" : null;?>>Maranhão</option>
            <option value="MT" <?=$paciente[state] == "MT" ? "selected" : null;?>>Mato Grosso</option>
            <option value="MS" <?=$paciente[state] == "MS" ? "selected" : null;?>>Mato Grosso do Sul</option>
            <option value="MG" <?=$paciente[state] == "MG" ? "selected" : null;?>>Minas Gerais</option>
            <option value="PA" <?=$paciente[state] == "PA" ? "selected" : null;?>>Pará</option>
            <option value="PB" <?=$paciente[state] == "PB" ? "selected" : null;?>>Paraíba</option>
            <option value="PR" <?=$paciente[state] == "PR" ? "selected" : null;?>>Paraná</option>
            <option value="PE" <?=$paciente[state] == "PE" ? "selected" : null;?>>Pernambuco</option>
            <option value="PI" <?=$paciente[state] == "PI" ? "selected" : null;?>>Piauí</option>
            <option value="RJ" <?=$paciente[state] == "RJ" ? "selected" : null;?>>Rio de Janeiro</option>
            <option value="RN" <?=$paciente[state] == "RN" ? "selected" : null;?>>Rio Grande do Norte</option>
            <option value="RS" <?=$paciente[state] == "RS" ? "selected" : null;?>>Rio Grande do Sul</option>
            <option value="RO" <?=$paciente[state] == "RO" ? "selected" : null;?>>Rondônia</option>
            <option value="RR" <?=$paciente[state] == "RR" ? "selected" : null;?>>Roraima</option>
            <option value="SC" <?=$paciente[state] == "SC" ? "selected" : null;?>>Santa Catarina</option>
            <option value="SP" <?=$paciente[state] == "SP" ? "selected" : null;?>>São Paulo</option>
            <option value="SE" <?=$paciente[state] == "SE" ? "selected" : null;?>>Sergipe</option>
            <option value="TO" <?=$paciente[state] == "TO" ? "selected" : null;?>>Tocantins</option>
        </select>
        <div class="doctors">
            <hr>
            <?php
                $doc_div;
                foreach($rows as $value){
                    foreach ($doctors as $doctor) {
                        if ($doctor[Medico] == $value[id]) {
                            $doc_div = 
                                '
                                    <hr>
                                    <div class="doctor">
                                        <label for="' . $value[id] . '">' . $value[name] . '</label>
                                        <input type="checkbox" name="doctors[]" value="' . $value[id] . '" id="' . $value[id] . '" checked>
                                        <input type="hidden" name="rel_id[]" value="' . $doctor[Relacao] . '">
                                    </div>
                                ';
                                break;
                        } else{
                            $doc_div =
                                '
                                    <hr>
                                    <div class="doctor">
                                        <label for="' . $value[id] . '">' . $value[name] . '</label>
                                        <input type="checkbox" name="doctors[]" value="' . $value[id] . '" id="' . $value[id] . '">
                                    </div>
                                ';
                        }
                    }
                    echo $doc_div;
                }
            ?>
            <hr>
        </div>
        <input type="hidden" name="alldocs" id="alldocs" value="">
        <input type="text" name="zip" data-mask="00000-000" value="<?=$paciente[zip]?>">
        <input type="text" name="indication" value="<?=$paciente[indication]?>">
        <input type="text" name="resp-name" value="<?=$paciente[resp_name]?>">
        <input type="text" class="celphones" name="resp-phone" value="<?=$paciente[resp_phone]?>">
        <input type="mail" name="resp-mail" value="<?=$paciente[resp_email]?>">
        <input type="checkbox" name="resp" <?=$paciente[resp_primary] ? 'checked' : null;?>>
        <textarea name="obs" id="" cols="30" rows="10"><?=$paciente[observations]?></textarea>
        <input type="hidden" name="id" value="<?=$paciente[id]?>">
        <input type="hidden" name="active" value="<?=$paciente[active]?>">
        <input type="submit" value="Salvar">
    </form>
    <form action="conn/de-activate.php" method="post">
        <input type="hidden" name="id" value="<?=$paciente[id]?>">
        <input type="submit" name="<?=$paciente[active] == 1 ? 'desativar' : 'ativar'?>" value="<?=$paciente[active] == 1 ? 'Desativar' : 'Ativar'?>">
    </form>
</div>

<script src="js/index.js"></script>
<?php
include 'components/footer.php';

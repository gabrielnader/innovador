<?php
require_once 'conn/conn.php';
include 'components/header.php';
$sql = "SELECT * FROM medicos";
$result = $conn->query($sql);
$rows = $result->fetchAll();

?>
<div class="container">
    <form action="conn/insert.php" method="post" onsubmit="return validateDocs();">
        <input type="text" name="name" placeholder="NOME" required>
        <input type="date" name="birth" placeholder="DATA" required>
        <input type="text" name="cpf" placeholder="CPF" data-mask="000.000.000-00" required>
        <input type="mail" name="mail" placeholder="E-MAIL">
        <input type="text" class="celphones" name="phone1" placeholder="TELEFONE" required>
        <input type="text" class="celphones" name="phone2" placeholder="CELULAR">
        <input type="text" name="address" placeholder="ENDEREÇO" required>
        <input type="text" name="complement" placeholder="COMPLEMENTO">
        <input type="text" name="region" placeholder="BAIRRO" required>
        <input type="text" name="city" placeholder="CIDADE" required>
        <select name="state" required>
            <option value="AC">Acre</option>
            <option value="AL">Alagoas</option>
            <option value="AP">Amapá</option>
            <option value="AM">Amazonas</option>
            <option value="BA">Bahia</option>
            <option value="CE">Ceará</option>
            <option value="DF">Distrito Federal</option>
            <option value="ES">Espírito Santo</option>
            <option value="GO">Goiás</option>
            <option value="MA">Maranhão</option>
            <option value="MT">Mato Grosso</option>
            <option value="MS">Mato Grosso do Sul</option>
            <option value="MG">Minas Gerais</option>
            <option value="PA">Pará</option>
            <option value="PB">Paraíba</option>
            <option value="PR">Paraná</option>
            <option value="PE">Pernambuco</option>
            <option value="PI">Piauí</option>
            <option value="RJ">Rio de Janeiro</option>
            <option value="RN">Rio Grande do Norte</option>
            <option value="RS">Rio Grande do Sul</option>
            <option value="RO">Rondônia</option>
            <option value="RR">Roraima</option>
            <option value="SC">Santa Catarina</option>
            <option value="SP" selected>São Paulo</option>
            <option value="SE">Sergipe</option>
            <option value="TO">Tocantins</option>
        </select>
        <input type="text" name="zip" data-mask="00000-000" placeholder="CEP">
        <input type="text" name="indication" placeholder="INDICAÇÃO">
        <div class="doctors">
            <hr>
            <?php
                foreach ($rows as $value) {
                    echo "
                        <div class='doctor'>
                            <label for='$value[id]'>$value[name]</label>
                            <input type='checkbox' name='doctors[]' value='$value[id]' id='$value[id]'>
                        </div>
                        <hr>";
                }
            ?>
        </div>
        <input type="text" name="resp-name" placeholder="NOME RESPONSÁVEL">
        <input type="text" class="celphones" name="resp-phone" placeholder="FONE RESPONSÁVEL">
        <input type="mail" name="resp-mail" placeholder="E-MAIL RESPONSÁVEL">
        <label for="resp">Contato com responsável?</label>
        <input type="checkbox" name="resp" id="resp" placeholder="">
        <textarea name="obs" id="" cols="30" rows="10"></textarea>
        <input type="submit" value="Cadastrar">
    </form>
</div>

<script src="js/index.js"></script>
<?php
include 'components/footer.php';

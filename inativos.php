<?php
require_once 'conn/conn.php';
include 'components/header.php';

$sql = "SELECT * FROM pacientes ORDER BY name";
$result = $conn->query($sql);
$rows = $result->fetchAll();
?>
<div class="container">
    <table>
        <thead>
            <tr>
                <th>NOME</th>
                <th>TELEFONE</th>
                <th>RESPONSÁVEL</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody>
            <?php
foreach ($rows as $value) {
    if ($value[active] == 0) {
        ?>
                    <tr>
                        <td><?=$value[name]?></td>
                        <?php
if ($value[resp_primary]) {
            ?>
                                <td class="celphones"><?=$value[resp_phone]?></td>
                                <td><?=$value[resp_name]?></td>
                            <?php
} else {
            ?>
                                <td class="celphones"><?=$value[phone_primary]?></td>
                                <td>-</td>
                            <?php
}
        ?>
                        <td>
                            <form action="detalhes.php" method="post">
                                <input type="hidden" name="id" value="<?=$value[id]?>">
                                <input type="submit" value="Detalhes">
                            </form>
                            <form action="conn/de-activate.php" method="post">
                                <input type="hidden" name="id" value="<?=$value[id]?>">
                                <input type="submit" name="ativar" value="Ativar">
                            </form>
                        </td>
                    </tr>
                    <?php
}}
;
?>
        </tbody>
    </table>
</div>

<?php
include 'components/footer.php';
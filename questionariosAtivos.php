<html>
<head>
    <title>Questionários ativos</title>
    <link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8">
    <head>
<body>
<?php
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
$my_id = $_SESSION['user_id'];
$questionarios = get_all_questionarios($pdo);

?>
<div class='container'>
    <h1>Questionários ativos:</h1>
    <?php
    $qtd = 0;
    foreach ($questionarios as $questionario) {
        if ($questionario['UserCriacao'] != $my_id) {
            $qtd = 1;
        }
    }
    if ($qtd == 1) {
    ?>
    <table style="margin-top: 15px" border="1" id="myTable">
        <tr>
            <td align="middle" width="250" style="font-weight: bold">Nome Questionário</td>
            <td align="middle" width="150" style="font-weight: bold">Modo Jogo</td>
        </tr>
        <?php
        foreach ($questionarios as $questionario) {
            $modo = "";
            if ($questionario['Acesso'] == "publico") {
                if ($questionario["Modo"] == "questionario") {
                    $modo = "Questionário";
                } else if ($questionario["Modo"] == "classico") {
                    $modo = "Clássico";
                } else if ($questionario["Modo"] == "contra_relogio") {
                    $modo = "Contra Relógio";
                } else {
                    $modo = "Morte Súbita";
                }
                ?>
                <tr>
                    <td align="middle" width="250"><?php echo $questionario["Titulo"] ?></td>
                    <td align="middle" width="150"><?php echo $modo ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    </br></br>
    <?php
    }
    ?>
</div>
</body>
</html>
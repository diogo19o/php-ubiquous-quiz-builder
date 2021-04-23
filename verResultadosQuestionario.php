<html>
<title>BackOffice</title>
<link rel='stylesheet' href='style.css'/>
<meta charset=utf-8">
<script language="JavaScript" type="text/javascript">
    function checkDelete() {
        return confirm('Tem a certeza que quer apagar esta pergunta?');
    }
</script>
<?php
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
$message = "";
?>
<div class='container'>
    <?php
    $my_id = $_SESSION['user_id'];
    $questionarioID = $_GET['questionario'];
    $resultados = get_resultados_by_questionario($pdo, $questionarioID);
    $users = get_all_users($pdo);
    $questionarios = get_seus_questionarios($pdo,$my_id);
    $nomeQuestionario="";
    foreach ($questionarios as $questionario) {
        if ($questionario["QuestionarioID"]==$questionarioID){
            $nomeQuestionario=$questionario["Titulo"];
            break;
        }
    }
    ?>
    <h1>Resultados do Questionário:  <?php echo $nomeQuestionario ?> </h1>
    <?php
    if (sizeof($resultados)>0){
    ?>
    <table style="margin-top: 15px" border="1" id="myTable">
        <tr>
            <td align="middle" width="150" style="font-weight: bold">Nome Utilizador</td>
            <td align="middle" width="175" style="font-weight: bold">Respostas Certas</td>
            <td align="middle" width="175" style="font-weight: bold">Respostas Erradas</td>
            <td align="middle" width="150" style="font-weight: bold">Pontuacao</td>
            <td align="middle" width="150" style="font-weight: bold">Data</td>
        </tr>
        <?php
        foreach ($resultados as $resultado) {
            if ($resultado["QuestionarioID"] == $questionarioID) {
                foreach ($users as $user) {
                    if ($user['id'] == $resultado['UtilizadorID']) {
                        $nome = $user['nome'];
                    }
                }
                $qtd_certas = $resultado['RespostasCertas'];
                $qtd_erradas = $resultado['RespostasErradas'];
                $data = $resultado['DataDePreenchimento'];
                $score = $resultado['Score'];
                ?>
                <tr>
                    <td align="middle" width="150"><?php echo $nome ?></td>
                    <td align="middle" width="175"><?php echo $qtd_certas ?></td>
                    <td align="middle" width="175"><?php echo $qtd_erradas ?></td>
                    <td align="middle" width="150"><?php echo $score ?></td>
                    <td align="middle" width="150"><?php echo $data ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    <?php
    }
    echo "</br><br><a href='verResultadosUser.php' class='box'>Voltar</a>"
    ?>
</div>
</body>
</html>
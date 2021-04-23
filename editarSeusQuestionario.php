<html>
<title>BackOffice</title>
<link rel='stylesheet' href='style.css'/>
<meta charset=utf-8">
<?php
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
    <h3>Qual o questionário que pretende editar:</h3>
    <?php
    $my_id = $_SESSION['user_id'];
    $questionarios = get_seus_questionarios($pdo,$my_id);
    foreach ($questionarios as $questionario) {
        $questionario_id = $questionario["QuestionarioID"];
        $questionario_titulo = $questionario["Titulo"];
        $resultados = get_resultados_by_questionario($pdo,$questionario_id);
        $qtd = sizeof($resultados);
        if ($qtd == 0) {
            echo "<a href='editarSeusQuestionarioEscolha.php?questionario=$questionario_id' class='boxBom1' style='display:block' >$questionario_titulo - O questionário não tem resultados</a>";
        }
        else
        {
            echo "<a href='editarSeusQuestionarioEscolha.php?questionario=$questionario_id' class='boxBom1' style='display:block ' >$questionario_titulo - O questionário tem $qtd resultados</a>";
        }
    }
    ?>
    </br>
    <a href='opcoesSeusQuestionarios.php' class='box'>Voltar</a>
</div>
</body>
</html>
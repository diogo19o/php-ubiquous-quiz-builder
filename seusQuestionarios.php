<html>
<head>
    <meta charset=utf-8">
    <title>Seus Questionários</title>
    <link rel='stylesheet' href='style.css'/>
    <head>
<body>
<?php
include 'functions.php';
include 'header.php';
$my_id = $_SESSION['user_id'];

$pdo = create_database_connection();

?>
<div class='container'>
    <h3>O que deseja consultar nos seus questionarios</h3>
    <?php
    $questionarios = get_seus_questionarios($pdo, $my_id);
        foreach ($questionarios as $questionario)
        {
            $questionario_id = $questionario["QuestionarioID"];
            $questionario_titulo = $questionario["Titulo"];
            echo "<a href='verSeuQuestionario.php?questionario=$questionario_id' class='boxBom1' style='display:block'>$questionario_titulo</a>";
        }
    ?>
    </br>
    <a href='opcoesSeusQuestionarios.php' class='box'>Voltar</a>
</div>
</body>
</html>
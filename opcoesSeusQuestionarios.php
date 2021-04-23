<html>
<head>
    <title>Seus Questionarios</title>
    <link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8">
    <head>
<body>
<?php
include 'functions.php';
include 'header.php';
$my_id = $_SESSION['user_id'];

$pdo = create_database_connection();

?>
<div class='container'>
    <?php
    $questionarios = get_seus_questionarios($pdo, $my_id);
    $exite = false;
    if (sizeof($questionarios) > 0) {
        ?><h1>O que deseja consultar nos seus questionarios</h1><?php
        foreach ($questionarios as $questionario)
        {
            $resultados = get_resultados_by_questionario($pdo,$questionario['QuestionarioID']);
            if(sizeof($resultados)>0)
            {
                $exite = true;
            }
        }
        ?>
        <a href='editarSeusQuestionario.php' class='boxBom' style='display:block'>Editar Questionarios</a>
        <a href='seusQuestionarios.php' class='boxBom' style='display:block'>Verificar Questionarios</a>
        <a href='apagarQuestionario.php' class='boxApagar'style='display:block'>Apagar Questionarios</a>
        <?php
        if($exite==true) {
            ?>
            <a href='verResultadosUser.php' class='boxBom' style='display:block'>Verificar Resultados</a>
            <?php
        }
        /*foreach ($questionarios as $questionario) {
            $questionario_id = $questionario["QuestionarioID"];
            $questionario_titulo = $questionario["Titulo"];
            echo "<a href='verSeuQuestionario.php?questionario=$questionario_id' class='box' style='display:block'>$questionario_titulo</a>";
        }*/
    } else {
        echo "<h1>Nao existe qualquer questionario criado por si </h1>";
    }
    echo "</br><a href='questionariosAtivos.php' class='box'>Voltar</a>"
    ?>
</div>
</body>
</html>
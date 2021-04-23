<html>
<head>
    <meta charset=utf-8">
    <title>Perguntas</title>
    <link rel='stylesheet' href='style.css'/>
    <head>
<body>
<?php
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
    <?php
    $my_id = $_SESSION['user_id'];
    $questionarioID = $_GET['questionario'];
    $questionarios = get_seus_questionarios($pdo,$my_id);
    $perguntas = get_perguntas_by_questionario($pdo,$questionarioID);
    $users = get_all_users($pdo);
    foreach ($questionarios as $questionario) {
        if ($questionarioID == $questionario['QuestionarioID']) {
            $questionarioTexto = $questionario['Titulo'];
        }
    }
    echo "<h3>Perguntas do questionario : '$questionarioTexto'</h3>";
    foreach ($perguntas as $pergunta) {
            $pergunta_id = $pergunta["PerguntaID"];
            $pergunta_texto = $pergunta["Texto"];
            echo "<a href='verSuasPergunta.php?pergunta=$pergunta_id' class='boxBom3' style='display:block'>$pergunta_texto</a>";
    }
    ?>
    </br>
    <?php
    echo "<a href='seusQuestionarios.php' class='box' >Voltar</a>";
    ?>

</div>
</body>
</html>
</html>
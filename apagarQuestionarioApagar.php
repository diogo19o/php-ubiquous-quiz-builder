<html>
<head>
    <title>Apagar Perfil</title>
    <link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8">
    <head>
<body>
<?php
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
    <?php
    $questionarioID = $_GET['questionario'];
    $perguntas = get_perguntas_by_questionario($pdo, $questionarioID);
    $respostas = get_all_respostas($pdo);
    foreach ($perguntas as $pergunta) {

        $statement2 = $pdo->prepare("DELETE FROM pergunta WHERE QuestionarioID=:id");
        $statement2->bindParam(':id', $questionarioID);
        $statement2->execute();
        foreach ($respostas as $resposta) {
            if ($resposta['PerguntaID'] = $pergunta['PerguntaID']) {
                $statement3 = $pdo->prepare("DELETE FROM resposta WHERE PerguntaID=:id");
                $statement3->bindParam(':id', $pergunta['PerguntaID']);
                $statement3->execute();

            }
        }

    }
    $statement = $pdo->prepare("DELETE FROM questionario WHERE QuestionarioID=:id");
    $statement->bindParam(':id', $questionarioID);
    $statement->execute();
    header('location: apagarQuestionario.php');
    ?>
</div>
</body>
</html>
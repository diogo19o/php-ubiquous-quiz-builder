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
    $perguntas = get_all_perguntas($pdo);
    $respostas = get_all_respostas($pdo);
    $questionarioID = $_GET['questionario'];
    $perguntaID = $_GET['pergunta'];

    /*$QuestionarioID=$_GET['questionario'];
    $statement=$pdo->prepare("DELETE FROM questionario WHERE QuestionarioID=:id");
        $statement->bindParam(':id',$QuestionarioID);
        $statement->execute();*/
    foreach ($perguntas as $pergunta) {
        if ($pergunta['PerguntaID'] == $perguntaID) {
            $statement2 = $pdo->prepare("DELETE FROM pergunta WHERE PerguntaID=:id");
            $statement2->bindParam(':id', $perguntaID);
            $statement2->execute();
            foreach ($respostas as $resposta) {
                if ($resposta['PerguntaID'] = $pergunta['PerguntaID']) {
                    $statement3 = $pdo->prepare("DELETE FROM resposta WHERE PerguntaID=:id");
                    $statement3->bindParam(':id', $pergunta['PerguntaID']);
                    $statement3->execute();

                }
            }
        }
    }
    header("location: editarSuaPergunta.php?questionario=" . $questionarioID . "");
    ?>
</div>
</body>
</html>
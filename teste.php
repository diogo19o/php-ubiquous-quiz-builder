<?php
include 'functions.php';
$pdo = create_database_connection();

$action = $_GET["action"];
 if ($action == "questionarios") {
    $questionarios = get_all_questionarios($pdo);
    echo(json_encode(array('questionarios' => $questionarios)));
} else if ($action == "perguntas") {
    $perguntas = get_all_perguntas($pdo);
    echo(json_encode(array('perguntas' => $perguntas)));
} else if ($action == "respostas") {
    $respostas = get_all_respostas($pdo);
    echo(json_encode(array('respostas' => $respostas)));
} else if ($action == "resultados") {
    $resultados = get_all_resultados($pdo);
    echo(json_encode(array('resultados' => $resultados)));
} else if ($action == "utilizadores") {
    $users = get_all_users($pdo);
    echo(json_encode(array('utilizadores' => $users)));
} 
 else if ($action == "rankings")
{
     $statement = $pdo->prepare("SELECT DISTINCT * FROM resultados  ORDER by Score DESC");
     $statement->execute();
     $rankings = $statement->fetchAll();
     echo(json_encode(array('rankings' => $rankings)));
 }
 else if ($action == "questionario")
 {
    $QuestionarioID = $_GET['QuestionarioID'];
    $statement = $pdo->prepare("SELECT * FROM pergunta WHERE QuestionarioID=:QuestionarioID");
    $statement->bindParam(':QuestionarioID', $QuestionarioID);
    $statement->execute();
    $perguntasDoQuestionario = $statement->fetchAll();
    echo(json_encode(array('perguntasDoQuestionario' => $perguntasDoQuestionario)));
}
 else if ($action == "pergunta")
{
    $PerguntaID = $_GET['PerguntaID'];
    $statement = $pdo->prepare("SELECT * FROM resposta WHERE PerguntaID=:PerguntaID");
    $statement->bindParam(':PerguntaID', $PerguntaID);
    $statement->execute();
    $respostasDaPergunta = $statement->fetchAll();
    echo(json_encode(array('respostasDaPergunta' => $respostasDaPergunta)));
}
 else if ($action == "resultado") {
    $resultados = get_all_resultados($pdo);
    $users = get_all_users($pdo);
    $corretas = $_POST['certas'];
    $erradas = $_POST['erradas'];
    $modo = $_POST['modo'];
    $score = $_POST['score'];
    $questionarioID = $_POST['questionarioID'];
    $nomeUtilizador = $_POST['nomeUtilizador'];
    foreach ($users as $user) {
        if ($user['nome'] == $nomeUtilizador) {
            $userID = $user['id'];
        }
    }
    $id = sizeof($resultados) + 1;
    $respondidas = $corretas + $erradas + 1;
    $data = date("Y-m-d");
    print("Sucesso");
    $statement = $pdo->prepare("INSERT INTO resultados VALUES(:resultadoID,:certas,:erradas,:score,:respondidas,:utilizadorID,:questionarioID,:modo,:data)");
    $statement->bindParam(':resultadoID', $id);
    $statement->bindParam(':certas', $corretas);
    $statement->bindParam(':erradas', $erradas);
    $statement->bindParam(':score', $score);
    $statement->bindParam(':respondidas', $respondidas);
    $statement->bindParam(':utilizadorID', $userID);
    $statement->bindParam(':questionarioID', $questionarioID);
    $statement->bindParam(':modo', $modo);
    $statement->bindParam(':data', $data);
    $statement->execute();
}
<html>
<head>
    <title>Inserir novo Perfil</title>
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
    $message = "";
    $questionarioID = $_GET['questionario'];
    $qtd_pergunta = sizeof(get_perguntas_by_questionario($pdo, $questionarioID)) + 1;
    $qtd_perguntas = sizeof(get_all_perguntas($pdo));
    $qtd_respostas = sizeof(get_all_respostas($pdo));
    $my_id = $_SESSION['user_id'];
    if (isset($_POST['submit'])) {
        $resposta1 = $_POST['resposta1texto'];
        $resposta2 = $_POST['resposta2texto'];
        $resposta3 = $_POST['resposta3texto'];
        $resposta4 = $_POST['resposta4texto'];
        $texto = $_POST['texto'];
        $valida = true;
        if (!empty($_POST['radio']) && !empty($texto) && !empty($resposta1) && !empty($resposta2) && !empty($resposta3) && !empty($resposta1)) {
            $perguntas = get_perguntas_by_questionario($pdo, $questionarioID);
            foreach ($perguntas as $pergunta) {
                if ($pergunta['Texto'] == $texto) {
                    $valida = false;
                }
            }
            if ($valida == true) {
                if ($resposta1 != $resposta2 && $resposta1 != $resposta3 && $resposta1 != $resposta4 && $resposta2 != $resposta3 && $resposta2 != $resposta4 && $resposta3 != $resposta4) {

                    $id_pergunta = $qtd_perguntas + 1;
                    $resposta = 1;
                    $statement = $pdo->prepare("INSERT INTO pergunta VALUES(:id,:texto,:resposta,:questionarioID)");
                    $statement->bindParam(':id', $id_pergunta);
                    $statement->bindParam(':texto', $texto);
                    $statement->bindParam(':resposta', $resposta);
                    $statement->bindParam(':questionarioID', $questionarioID);
                    $statement->execute();


                    for ($i = 1; $i <= 4; $i++) {
                        $id_resposta = $qtd_respostas += 1;
                        $ajuda = $_POST['resposta' . $i . 'texto'];
                        if ($_POST['radio'] == 'resposta' . $i) {
                            $correta = 1;
                        } else {
                            $correta = 0;

                        }
                        $statement = $pdo->prepare("INSERT INTO resposta VALUES(:id,:texto,:correta,:PerguntaID)");
                        $statement->bindParam(':id', $id_resposta);
                        $statement->bindParam(':texto', $ajuda);
                        $statement->bindParam(':correta', $correta);
                        $statement->bindParam(':PerguntaID', $id_pergunta);
                        $statement->execute();
                    }
                    $qtd_pergunta++;
                } else {
                    $message = "As respostas têm de ser todas diferentes";
                }
            } else {
                $message = "O titulo da pergunta nao é válido";
            }
        } else {
            $message = "Por favor preencha todos os campos";
        }
    }
    if (isset($_POST['acabar'])) {
        if ($qtd_pergunta > 2) {
            header("location: editarSeusQuestionarioEscolha.php?questionario=" . $questionarioID . "");
        } else {
            $message = "Tem que ter no mínimo 2 perguntas";
        }
    }
    if ($message != "") {
        echo "<div class='box'>$message</div>";
    }

    ?>
    <html>
    <body>

    <form action="" method="post">
        <?php
        echo "<h3>Insira as suas perguntas e as respetivas respostas :</h3>";
        echo "<h3>Pergunta $qtd_pergunta:</h3>";
        ?>
        <input type="text" name="texto">
        <br/>
        <?php
        echo "<h3>Respostas :</h3>";
        ?>
        <div>
            <input type="radio" id="resposta1" name="radio" value="resposta1">
            <input type='text' name='resposta1texto' autocomplete="off"/>
            <br>
            <input type="radio" id="resposta2" name="radio" value="resposta2">
            <input type='text' name='resposta2texto' autocomplete="off"/>
            <br>
            <input type="radio" id="resposta3" name="radio" value="resposta3">
            <input type='text' name='resposta3texto' autocomplete="off"/>
            <br>
            <input type="radio" id="resposta4" name="radio" value="resposta4">
            <input type='text' name='resposta4texto' autocomplete="off"/>
            <br>
        </div>
        <input type='submit' name='submit' value='Inserir'> <input type='submit' name='acabar' value='Finalizar'>
    </form>

    </body>
    </html>

    <?php
    echo "<a href='editarSeusQuestionarioEscolha.php?questionario=$questionarioID' class='box' >Voltar</a>";
    ?>
</div>
</body>
</html>
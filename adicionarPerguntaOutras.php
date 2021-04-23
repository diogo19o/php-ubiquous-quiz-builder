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
    if (isset($_POST['submit'])) {
        if ((!empty($_POST['texto']))) {
            $QuestionarioID = $_GET['questionario'];
            $PerguntaID = $_GET['pergunta'];
            $id = 0;
            $correta = 0;
            $qtdRespostas = 0;
            $statement = $pdo->prepare("INSERT INTO resposta VALUES(:id,:texto,:correta,:PerguntaID)");
            $statement->bindParam(':id', $id);
            $statement->bindParam(':texto', $_POST['texto']);
            $statement->bindParam(':correta', $correta);
            $statement->bindParam(':PerguntaID', $PerguntaID);
            $statement->execute();

            $respostas = get_all_respostas($pdo);
            foreach ($respostas as $resposta) {
                if ($resposta['PerguntaID'] == $PerguntaID) {
                    $qtdRespostas++;
                    /*$respostaTexto=$resposta['Texto'];
                    if($resposta['Correta']==1){
                        $correta="correta";
                    }else{
                        $correta="errada";
                    }
                    echo "<h3>Resposta: $respostaTexto -> $correta</h3>";*/
                }
            }
            if ($qtdRespostas != 4) {
                ?>
                <html>
                <body>

                <form action="" method="post">
                    Introduza uma resposta errada à pergunta1:<br/>
                    <input type="text" name="texto">
                    <br/><br/>
                    <input type='submit' name='submit' value='Inserir'>
                </form>

                </body>
                </html>
                <?php
            }
            else
            {
                echo "<a href='editarQuestionarioEscolha.php?questionario=$QuestionarioID' class='box' style='display:block' >$message Voltar ao Menu do Questionário</a>";
            }
        } else {
            $message = "Por favor preencha todos os campos";
            ?>
            <html>
            <body>

            <form action="" method="post">
                Introduza uma resposta errada à pergunta1:<br/>
                <input type="text" name="texto">
                <br/><br/>
                <input type='submit' name='submit' value='Inserir'>
            </form>

            </body>
            </html>

            <?php
        }
    } else {
        ?>
        <html>
        <body>

        <form action="" method="post">
            Introduza uma resposta errada à pergunta 2:<br/>
            <input type="text" name="texto">
            <br/><br/>
            <input type='submit' name='submit' value='Inserir'>
        </form>

        </body>
        </html>

        <?php
    }
    if ($message != '') {
        echo "<div class='box'>$message</div>";
    }
    ?>
</div>
</body>
</html>
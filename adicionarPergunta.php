<!DOCTYPE html>
<html>
<head>
    <title>Inserir nova pergunta</title>
    <link rel='stylesheet' href='style.css'/>
    <meta charset=utf-8>
<head>
<body>
    <?php
    include 'functions.php';
    include 'header.php';
    $pdo = create_database_connection();
    ?>
    <div class='container'>
        <?php
        $qtd = 3;
        $message = "";
        $questionarioID = $_GET['questionario'];
        $qtd_pergunta = sizeof(get_perguntas_by_questionario($pdo, $questionarioID)) + 1;
        $qtd_perguntas = sizeof(get_all_perguntas($pdo));
        $qtd_respostas = sizeof(get_all_respostas($pdo));
        $qtd_imagens = sizeof(get_all_imagens($pdo));
        $my_id = $_SESSION['user_id'];
        if (isset($_POST['submit'])) {
            $resposta11 = $_POST['resposta1texto'];
            $resposta22 = $_POST['resposta2texto'];
            $resposta33 = $_POST['resposta3texto'];
            $campos = array($resposta11, $resposta22, $resposta33);
            if ($_POST['resposta4texto'] != null) {
                $resposta44 = $_POST['resposta4texto'];
                $campos = array($resposta11, $resposta22, $resposta33, $resposta44);
                $qtd = 4;
            }
            if ($_POST['resposta5texto'] != null) {
                $resposta55 = $_POST['resposta5texto'];
                $campos = array($resposta11, $resposta22, $resposta33, $resposta44, $resposta55);
                $qtd = 5;
            }
            if ($_POST['resposta6texto'] != null) {
                $resposta66 = $_POST['resposta6texto'];
                $campos = array($resposta11, $resposta22, $resposta33, $resposta44, $resposta55, $resposta66);
                $qtd = 6;
            }
            $texto = $_POST['texto'];
            $valida = true;
            if (!empty($_POST['radio']) && !empty($texto) && !empty($resposta11) && !empty($resposta22) && !empty($resposta33)) {
                $perguntas = get_perguntas_by_questionario($pdo, $questionarioID);
                foreach ($perguntas as $pergunta) {
                    if ($pergunta['Texto'] == $texto) {
                        $valida = false;
                    }
                }
                if ($valida) {
                    for ($i = 0; $i < sizeof($campos); $i++) {
                        for ($j = 1; $j < sizeof($campos); $j++) {
                            if ($campos[$i] == $campos[$j] && $i != $j) {
                                $valida = false;
                            }
                        }
                    }
                    if ($valida) {
                        $id_pergunta = $qtd_perguntas + 1; 
                        $resposta = 1;
                        if ($_FILES['imagem']['size'] == 0 && $_FILES['imagem']['error'] == 4) {
                            $statement = $pdo->prepare("INSERT INTO `pergunta` (`PerguntaID`,`Texto`,`Resposta`,`QuestionarioID`) VALUES (?,?,?,?)");
                            $statement->execute([$id_pergunta,$_POST['texto'],$resposta, $questionarioID]);
                            echo "guardou pergunta 1";
                        }else{
                            try {
                                $stmt = $pdo->prepare("INSERT INTO `imagens` (`QuestionarioID`,`PerguntaID`,`FileName`, `FileData`) VALUES (?,?,?,?)");
                                $stmt->execute([$questionarioID,$id_pergunta,$_FILES["imagem"]["name"], file_get_contents($_FILES['imagem']['tmp_name'])]);
                                echo "OK";
                            } catch (Exception $ex) { echo $ex->getMessage(); }
                            try {
                                $statement = $pdo->prepare("INSERT INTO `pergunta` (`PerguntaID`,`Texto`,`Resposta`,`QuestionarioID`,`NomeImagem`) VALUES (?,?,?,?,?)");
                                $statement->execute([$id_pergunta,$_POST['texto'],$resposta, $questionarioID,$_FILES["imagem"]["name"]]);
                                echo "guardou pergunta 2";
                            } catch (Exception $ex) { echo $ex->getMessage(); }
                        }

                        for ($i = 1; $i <= $qtd; $i++) {
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
                $message = "Tem que have no mínimo 3 respostas por pergunta";
            }
        }
        if (isset($_POST['acabar'])) {
            if ($qtd_pergunta > 2) {
                header('location: questionariosAtivos.php');
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
            <form action="" method="post" enctype="multipart/form-data">
                <?php
                echo "<h3>Insira as suas perguntas e as respetivas respostas : </h3>";
                echo "<h3>Pergunta $qtd_pergunta:</h3>";
                ?>
                <input type="text" name="texto" autocomplete="off" size="100">
                <?php
                echo "<h3>Insira as respetivas respostas(mínimo 3 respostas): </h3>";
                ?>
                <table border="1">
                    <tr>
                        <td align="middle" width="392">Resposta Texto</td>
                        <td align="middle" width="150">Resposta Certa</td>
                    </tr>
                </table>
                <input type='text' name='resposta1texto' autocomplete="off" class="boxPerguntas" style="margin-right: 70px"/>
                <input type="radio" id="resposta1" name="radio" value="resposta1">
                <br>
                <input type='text' name='resposta2texto' autocomplete="off" class="boxPerguntas" style="margin-right: 70px"/>
                <input type="radio" id="resposta2" name="radio" value="resposta2">
                <br>
                <input type='text' name='resposta3texto' autocomplete="off" class="boxPerguntas" style="margin-right: 70px"/>
                <input type="radio" id="resposta3" name="radio" value="resposta3">
                <br>
                <input type='text' name='resposta4texto' autocomplete="off" class="boxPerguntas" style="margin-right: 70px"/>
                <input type="radio" id="resposta4" name="radio" value="resposta4">
                <br>
                <input type='text' name='resposta5texto' autocomplete="off" class="boxPerguntas" style="margin-right: 70px"/>
                <input type="radio" id="resposta5" name="radio" value="resposta5">
                <br>
                <input type='text' name='resposta6texto' autocomplete="off" class="boxPerguntas" style="margin-right: 70px"/>
                <input type="radio" id="resposta6" name="radio" value="resposta6">
                <br>
                <input type="file" name="imagem" accept=".png,.jpg,.jpeg"/>
            <input type='submit' name='submit' style="background: #3366ff" value='Inserir'> <input type='submit' name='acabar' style="background: #3366ff" value='Finalizar'> <?php
                echo "<a href='editarSeusQuestionarioEscolha.php?questionario=$questionarioID' class='box' >Voltar</a>";
                ?>
            </form>
        </body>
        </html>
    </div>
</body>
</html>
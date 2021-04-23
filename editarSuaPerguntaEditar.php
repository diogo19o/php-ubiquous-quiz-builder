<html>
<title>BackOffice</title>
<link rel='stylesheet' href='style.css'/>
<meta charset=utf-8">
<script language="JavaScript" type="text/javascript">
    function checkDelete() {
        return confirm('Tem a certeza que quer apagar esta pergunta?');
    }
</script>
<?php
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
$message = "";
?>
<div class='container'>
    <?php
    $count = 1;
    $count2 = 1;
    $questionarioID = $_GET['questionario'];
    $perguntaID = $_GET['pergunta'];
    $perguntas = get_perguntas_by_questionario($pdo, $questionarioID);
    $respostas = get_respostas_by_pergunta($pdo, $perguntaID);
    $numeroPerguntas = 0;
    foreach ($perguntas as $pergunta) {
        if ($pergunta['PerguntaID'] == $perguntaID) {
            $pergunta_texto = $pergunta['Texto'];
        }
    }
    if (isset($_POST['textoPergunta'])) {
        $id = $perguntaID;
        $statement = $pdo->prepare("UPDATE pergunta set texto=:texto where PerguntaID=:id");
        $statement->bindParam(':texto', $_POST['texto']);
        $statement->bindParam(':id', $id);
        $statement->execute();
        $pergunta_texto = $_POST['texto'];
        $message = "Nome pergunta updated";
    }

    ?>
    <form action="" method="post">
        Nome da Pergunta:<br/>
        <input type="text" name="texto" value="<?php echo "$pergunta_texto"; ?>" autocomplete="off" size="100">
        <br/><br/>
        <input type='submit' name='textoPergunta' value='Editar Nome da Pergunta'>
        <div>
            <?php
            foreach ($respostas as $resposta) {
                echo "<h3>Resposta $count:</h3>";
                $resposta_texto = $resposta['Texto'];
                if ($resposta['Correta'] == 1) {
                    ?><input type="radio" id="resposta<?php echo "$count"; ?>" name="radio"
                             value="resposta<?php echo "$count"; ?>" checked="checked" size="70"><?php
                } else {
                    ?><input type="radio" id="resposta<?php echo "$count"; ?>" name="radio" size="70"
                             value="resposta<?php echo "$count"; ?>"><?php
                }
                $respostaID = $resposta['RespostaID'];
                ?>
                <input type='text' name='resposta<?php echo "$count"; ?>texto' value="<?php echo "$resposta_texto"; ?>"
                       size="70"
                       autocomplete="off"/>
                <br>
                <?php
                $count += 1;
            }
            if (isset($_POST['submit'])) {
                $resposta1 = $_POST['resposta1texto'];
                $resposta2 = $_POST['resposta2texto'];
                $resposta3 = $_POST['resposta3texto'];
                if($count==4){
                    if (!empty($resposta1) && !empty($resposta2) && !empty($resposta3)) {
                        if ($resposta1 != $resposta2 && $resposta1 != $resposta3
                            && $resposta2 != $resposta3) {
                            foreach ($respostas as $resposta) {
                                $id_resposta = $resposta['RespostaID'];
                                $ajuda = $_POST['resposta' . $count2 . 'texto'];
                                if ($_POST['radio'] == 'resposta' . $count2) {
                                    $correta = 1;
                                } else {
                                    $correta = 0;

                                }
                                $statement = $pdo->prepare(" UPDATE resposta set texto=:texto, Correta=:correta where RespostaID=:idResposta");
                                $statement->bindParam(':idResposta', $id_resposta);
                                $statement->bindParam(':texto', $ajuda);
                                $statement->bindParam(':correta', $correta);
                                $statement->execute();
                                $count2++;
                                $message = "Respostas foram editadas";
                            }
                        } else {
                            $message = "Não podem existir respostas iguais";
                        }
                    } else {
                        $message = "Os campos nao podem estar vazios";
                    }
                }
                elseif ($count == 5) {
                    $resposta4 = $_POST['resposta4texto'];
                    if (!empty($resposta1) && !empty($resposta2) && !empty($resposta3) && !empty($resposta4)) {
                        if ($resposta1 != $resposta2 && $resposta1 != $resposta3 && $resposta1 != $resposta4
                            && $resposta2 != $resposta3 && $resposta2!=$resposta4
                            && $resposta3 != $resposta4) {
                            foreach ($respostas as $resposta) {
                                $id_resposta = $resposta['RespostaID'];
                                $ajuda = $_POST['resposta' . $count2 . 'texto'];
                                if ($_POST['radio'] == 'resposta' . $count2) {
                                    $correta = 1;
                                } else {
                                    $correta = 0;

                                }
                                $statement = $pdo->prepare(" UPDATE resposta set texto=:texto, Correta=:correta where RespostaID=:idResposta");
                                $statement->bindParam(':idResposta', $id_resposta);
                                $statement->bindParam(':texto', $ajuda);
                                $statement->bindParam(':correta', $correta);
                                $statement->execute();
                                $count2++;
                                $message = "Respostas foram editadas";
                            }
                        } else {
                            $message = "Não podem existir respostas iguais";
                        }
                    } else {
                        $message = "Os campos nao podem estar vazios";
                    }
                } elseif ($count == 6) {
                    $resposta4 = $_POST['resposta4texto'];
                    $resposta5 = $_POST['resposta5texto'];
                    if (!empty($resposta1) && !empty($resposta2) && !empty($resposta3) && !empty($resposta4) && !empty($resposta5)) {
                        if ($resposta1 != $resposta2 && $resposta1 != $resposta3 && $resposta1 != $resposta4 && $resposta1 != $resposta5
                            && $resposta2 != $resposta3 && $resposta2 != $resposta4 && $resposta2 != $resposta5
                            && $resposta3 != $resposta4 && $resposta3 != $resposta5
                            && $resposta4 != $resposta5) {
                            foreach ($respostas as $resposta) {
                                $id_resposta = $resposta['RespostaID'];
                                $ajuda = $_POST['resposta' . $count2 . 'texto'];
                                if ($_POST['radio'] == 'resposta' . $count2) {
                                    $correta = 1;
                                } else {
                                    $correta = 0;

                                }
                                $statement = $pdo->prepare(" UPDATE resposta set texto=:texto, Correta=:correta where RespostaID=:idResposta");
                                $statement->bindParam(':idResposta', $id_resposta);
                                $statement->bindParam(':texto', $ajuda);
                                $statement->bindParam(':correta', $correta);
                                $statement->execute();
                                $count2++;
                                $message = "Respostas foram editadas";
                            }
                        } else {
                            $message = "Não podem existir respostas iguais";
                        }
                    } else {
                        $message = "Os campos nao podem estar vazios";
                    }
                } elseif ($count == 7) {
                    $resposta4 = $_POST['resposta4texto'];
                    $resposta5 = $_POST['resposta5texto'];
                    $resposta6 = $_POST['resposta6texto'];
                    if (!empty($resposta1) && !empty($resposta2) && !empty($resposta3) && !empty($resposta4) && !empty($resposta5) && !empty($resposta6)) {
                        if ($resposta1 != $resposta2 && $resposta1 != $resposta3 && $resposta1 != $resposta4 && $resposta1 != $resposta5 && $resposta1 != $resposta6
                            && $resposta2 != $resposta3 && $resposta2 != $resposta4 && $resposta2 != $resposta5 && $resposta2 != $resposta6
                            && $resposta3 != $resposta4 && $resposta3 != $resposta5 && $resposta3 != $resposta6
                            && $resposta4 != $resposta5 && $resposta4 != $resposta6
                            && $resposta5 != $resposta6) {
                            foreach ($respostas as $resposta) {
                                $id_resposta = $resposta['RespostaID'];
                                $ajuda = $_POST['resposta' . $count2 . 'texto'];
                                if ($_POST['radio'] == 'resposta' . $count2) {
                                    $correta = 1;
                                } else {
                                    $correta = 0;

                                }
                                $statement = $pdo->prepare(" UPDATE resposta set texto=:texto, Correta=:correta where RespostaID=:idResposta");
                                $statement->bindParam(':idResposta', $id_resposta);
                                $statement->bindParam(':texto', $ajuda);
                                $statement->bindParam(':correta', $correta);
                                $statement->execute();
                                $count2++;
                                $message = "Respostas foram editadas";
                            }
                        } else {
                            $message = "Não podem existir respostas iguais";
                        }
                    } else {
                        $message = "Os campos nao podem estar vazios";
                    }
                }
                header('location: editarSuaPerguntaEditar.php?questionario=' . $questionarioID . '&pergunta=' . $perguntaID);

            }
            ?>
            <br><br>
            <input type='submit' name='submit' value='Editar Respostas'>
            <?php
            echo "<a href='editarSuaPergunta.php?questionario=$questionarioID' class='box'>Voltar</a>"
            ?>
        </div>
        <?php
        if ($message != "") {
            echo "<div class='box'>$message</div>";
        }
        ?>
    </form>
</div>
</body>
</html>
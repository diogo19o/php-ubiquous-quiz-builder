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
?>
<div class='container'>
    <?php

    $questionarioID = $_GET['questionario'];
    $questionarios = get_all_questionarios($pdo);
    $perguntas = get_perguntas_by_questionario($pdo, $questionarioID);
    $numeroPerguntas = 0;
    foreach ($questionarios as $questionario) {
        if ($questionario['QuestionarioID'] == $questionarioID) {
            $questionario_titulo = $questionario['Titulo'];
            $questionario_acesso = $questionario['Acesso'];
        }
    }
    foreach ($perguntas as $pergunta) {
        $pergunta_texto = $pergunta['Texto'];
        $perguntaID = $pergunta['PerguntaID'];
        echo "<h3>$pergunta_texto</h3><a href='editarSuaPerguntaEditar.php?questionario=$questionarioID&pergunta=$perguntaID' class='boxBom1' style=''>Editar</a>  <a href='editarPerguntaApagar.php?questionario=$questionarioID&pergunta=$perguntaID' style='background: red' class='box'"; ?>onclick="return checkDelete()"<?php echo ">Apagar</a>";
    }
    echo "</br></br></br></br><a href='editarSeusQuestionarioEscolha.php?questionario=$questionarioID' class='box' >Voltar</a>";
    ?>
</div>
</body>
</html>
<html>
<title>BackOffice</title>
<link rel='stylesheet' href='style.css'/>
<meta charset=utf-8">
<?php
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
    <?php
    $questionarioID = $_GET['questionario'];
    $my_id = $_SESSION['user_id'];
    $questionarios = get_seus_questionarios($pdo,$my_id);
    $perguntas = get_perguntas_by_questionario($pdo,$questionarioID);
    $numeroPerguntas = 0;
    foreach ($questionarios as $questionario) {
        if($questionario["QuestionarioID"]==$questionarioID){
            $questionario_titulo = $questionario['Titulo'];
            $questionario_acesso = $questionario['Acesso'];
            break;
        }
    }

    echo "<h1>Editar $questionario_titulo:</h1>";
    echo "<h2>O questionário está no estado: $questionario_acesso</h2>";
    if($questionario_acesso == "publico") {
        echo "<a href='mudarAcessoMudar.php?questionario=$questionarioID&acesso=privado' class='boxBom2' style='display:block' >Passar para privado</a>";
    }
    else {
        echo "<a href='mudarAcessoMudar.php?questionario=$questionarioID&acesso=publico' class='boxBom2' style='display:block' >Passar para publico</a>";
    }
    echo "</br><a href='editarSeusQuestionarioEscolha.php?questionario=$questionarioID' class='box'>Voltar</a>"

    ?>
</div>
</body>
</html>
<html>
<title>BackOffice</title>
<meta charset=utf-8">
<link rel='stylesheet' href='style.css'/>
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
    <h1>Resultados dos Seus Questionarios:</h1>
    <?php
    $my_id = $_SESSION['user_id'];
    $questionarios = get_seus_questionarios($pdo, $my_id);
    foreach ($questionarios as $questionario)
    {
        $id = $questionario['QuestionarioID'];
        $resultados = get_resultados_by_questionario($pdo,$id);
        $titulo = $questionario['Titulo'];
        $qtd = sizeof($resultados);
        echo "<a href='verResultadosQuestionario.php?questionario=$id' class='boxBom1' style='display:block'>Nome: $titulo tem $qtd resultados</a>";
    }
    echo "</br><a href='opcoesSeusQuestionarios.php' class='box'>Voltar</a>"
    ?>
</div>
</body>
</html>
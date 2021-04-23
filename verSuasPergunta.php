<html>
<head>
    <meta charset=utf-8">
    <title>Respostas</title>
    <link rel='stylesheet' href='style.css'/>
    <head>
<body>
<?php
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
$my_id = $_SESSION['user_id'];
?>
<div class='container'>
    <?php
    $perguntaID = $_GET['pergunta'];
    $questionarios = get_seus_questionarios($pdo, $my_id);
    $perguntas = get_all_perguntas($pdo);
    $respostas = get_respostas_by_pergunta($pdo, $perguntaID);
    foreach ($perguntas as $pergunta) {
        if ($perguntaID == $pergunta['PerguntaID']) {
            $perguntaTexto = $pergunta['Texto'];
            $questionarioID = $pergunta['QuestionarioID'];
            foreach ($questionarios as $questionario) {
                {
                    if ($questionario['QuestionarioID'] == $questionarioID) {
                        $questionarioTexto = $questionario['Titulo'];
                    }
                }
            }
        }
    }
    echo "<h3>Respostas da pergunta: '$perguntaTexto' do questionario: '$questionarioTexto'</h3>";
    ?>
    <table style="margin-top: 15px" border="1" id="myTable">
        <tr>
            <td align="middle" width="200" style="font-weight: bold">Resposta Texto</td>
            <td align="middle" width="150" style="font-weight: bold">Resposta Certa</td>
        </tr>
        <?php
        foreach ($respostas as $resposta) {
            $resposta_certa="";
            if($resposta["Correta"]=="1"){
                $resposta_certa="X";
            }
            ?>
            <tr>
                <td align="middle" width="200"><?php echo $resposta["Texto"] ?></td>
                <td align="middle" width="150"><?php echo $resposta_certa?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    </br>
    <?php
    echo "<a href='verSeuQuestionario.php?questionario=$questionarioID' class='box' >Voltar</a>";
    ?>
</div>
</body>
</html>
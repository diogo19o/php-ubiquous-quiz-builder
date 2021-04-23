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

    $questionarioID=$_GET['questionario'];
    $questionario_acesso=$_GET['acesso'];
    $questionarios=get_all_questionarios($pdo);
    foreach($questionarios as $questionario){
        if($questionario['QuestionarioID']==$questionarioID){
            $questionario_titulo=$questionario["Titulo"];
            $questionario_descricao=$questionario['Descricao'];
            $questionario_data=$questionario['DataDeCriacao'];
            $statement=$pdo->prepare("UPDATE questionario set Titulo=:Titulo, Descricao=:Descricao, DataDeCriacao=:DataDeCriacao, Acesso=:Acesso where QuestionarioID=:QuestionarioID");
            $statement->bindParam(':QuestionarioID',$questionarioID);
            $statement->bindParam(':Titulo',$questionario_titulo);
            $statement->bindParam(':Descricao',$questionario_descricao);
            $statement->bindParam(':DataDeCriacao',$questionario_data);
            $statement->bindParam(':Acesso',$questionario_acesso);
            $statement->execute();
            header("location: editarSeusQuestionarioEscolha.php?questionario=".$questionarioID."");
        }
    }
    ?>
</div>
</body>
</html>
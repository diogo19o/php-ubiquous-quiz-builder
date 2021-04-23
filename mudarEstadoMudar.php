<html>

<title>BackOffice</title>
<link rel='stylesheet' href='style.css'/>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<h3>Qual o questionário que pretende editar:</h3>
	<?php

		$questionarioID=$_GET['questionario'];
		$questionario_estado=$_GET['estado'];
		$questionarios=get_all_questionarios($pdo);
		foreach($questionarios as $questionario){
			if($questionario['QuestionarioID']==$questionarioID){
				$questionario_titulo=$questionario["Titulo"];
				$questionario_descricao=$questionario['Descricao'];
				$questionario_data=$questionario['DataDeCriacao'];
				$statement=$pdo->prepare("UPDATE questionario set Titulo=:Titulo, Descricao=:Descricao, DataDeCriacao=:DataDeCriacao, Estado=:Estado where QuestionarioID=:QuestionarioID");
					$statement->bindParam(':QuestionarioID',$questionarioID);
					$statement->bindParam(':Titulo',$questionario_titulo);
					$statement->bindParam(':Descricao',$questionario_descricao);
					$statement->bindParam(':DataDeCriacao',$questionario_data);
					$statement->bindParam(':Estado',$questionario_estado);
					$statement->execute();
                header("location: editarSeusQuestionarioEscolha.php?questionario=".$questionarioID."");
			}
		}
		?>
</div>
</body>
</html>
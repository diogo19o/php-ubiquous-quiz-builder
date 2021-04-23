<html>
<title>BackOffice</title>
<link rel='stylesheet' href='style.css'/>
<?php 
include 'functions.php';
include 'header.php';
$pdo = create_database_connection();
?>
<div class='container'>
	<?php

	$QuestionarioID=$_GET['questionario'];
		$questionarios=get_all_questionarios($pdo);
		$perguntas=get_all_perguntas($pdo);
		$temPergunta=0;
		
		foreach($questionarios as $questionario){
			if($questionario['QuestionarioID']==$QuestionarioID){
				$questionario_titulo=$questionario['Titulo'];
			}
		}

		echo "<h3>Editar $questionario_titulo:</h3>";

		echo "<a href='adicionarPergunta.php.php?questionario=$QuestionarioID' class='box' style='display:block' >Adicionar perguntas</a>";

		foreach ($perguntas as $pergunta) {
			if($pergunta['QuestionarioID']==$QuestionarioID){
				$temPergunta=1;
			}
		}
		if($temPergunta==1){
			echo "<a href='editarPergunta.php?questionario=$QuestionarioID' class='box' style='display:block' >Editar perguntas</a>";
		}

		//echo "<a href='editarPergunta.php?questionario=$QuestionarioID' class='box' style='display:block' >Editar perguntas</a>";
		echo "<a href='mudarEstado.php?questionario=$QuestionarioID' class='box' style='display:block' >Mudar Estado do questionário</a>";
		echo "</br><a href='editarQuestionario.php' class='box'>Voltar</a>"
		?>
</div>
</body>
</html>
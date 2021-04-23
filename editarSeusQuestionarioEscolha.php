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
		$questionarios=get_all_questionarios($pdo);
		$perguntas=get_all_perguntas($pdo);
		$temPergunta=0;
		
		foreach($questionarios as $questionario){
			if($questionario['QuestionarioID']==$questionarioID){
				$questionario_titulo=$questionario['Titulo'];
			}
		}

		echo "<h3>Editar $questionario_titulo:</h3>";

		echo "<a href='adicionarPergunta.php?questionario=$questionarioID' class='boxBom' style='display:block' >Adicionar perguntas</a>";

		foreach ($perguntas as $pergunta) {
			if($pergunta['QuestionarioID']==$questionarioID){
				$temPergunta=1;
			}
		}
		if($temPergunta==1){
			echo "<a href='editarSuaPergunta.php?questionario=$questionarioID' class='boxBom' style='display:block' >Editar perguntas</a>";
		}

        echo "<a href='mudarSeuAcesso.php?questionario=$questionarioID' class='boxBom2' style='display:block' >Mudar acesso do questionario</a>";
        echo "</br><a href='editarSeusQuestionario.php' class='box'>Voltar</a>"
		?>
</div>
</body>
</html>
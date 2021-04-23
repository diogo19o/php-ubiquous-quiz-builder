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
		$perguntas= get_all_perguntas($pdo);
		$numeroPerguntas=0;
		foreach($questionarios as $questionario){
			if($questionario['QuestionarioID']==$QuestionarioID){
				$questionario_titulo=$questionario['Titulo'];
				$questionario_estado=$questionario['Estado'];
			}
		}

		echo "<h3>Editar $questionario_titulo:</h3>";
		echo "<h3>O questionário está no estado: $questionario_estado";
		if($questionario_estado=="ativo"){
			echo "<a href='mudarEstadoMudar.php?questionario=$QuestionarioID&estado=inativo' class='box' style='display:block' >Passar para inativo</a>";
		}else if($questionario_estado=="inativo"){
			foreach ($perguntas  as $pergunta) {
				if($QuestionarioID==$pergunta['QuestionarioID']){
					$numeroPerguntas+=1;
				}
			}
			if($numeroPerguntas>=2){
				echo "<a href='mudarEstadoMudar.php?questionario=$QuestionarioID&estado=ativo' class='box' style='display:block' >Passar para ativo</a>";
			}else{
				echo "<h3>O questionário não pode passar para o estado ativo pois não contem 4 perguntas";
			}
		}else if($questionario_estado=="rascunho"){
			foreach ($perguntas  as $pergunta) {
				if($QuestionarioID==$pergunta['QuestionarioID']){
					$numeroPerguntas+=1;
				}
			}
			if($numeroPerguntas>=2){
				echo "<a href='mudarEstadoMudar.php?questionario=$QuestionarioID&estado=ativo' class='box' style='display:block' >Passar para ativo</a>";
				echo "<a href='mudarEstadoMudar.php?questionario=$QuestionarioID&estado=inativo' class='box' style='display:block' >Passar para inativo</a>";
			}else{
				echo "<a href='mudarEstadoMudar.php?questionario=$QuestionarioID&estado=inativo' class='box' style='display:block' >Passar para inativo</a>";
			}
		}

		echo "</br></br><a href='editarQuestionarioEscolha.php?questionario=$QuestionarioID' class='box' >Voltar</a>";

		/*echo "<a href='adicionarPergunta.php?questionario=$QuestionarioID' class='box' style='display:block' >Adicionar pergunta</a>";
		echo "<a href='editarPergunta.php?questionario=$QuestionarioID' class='box' style='display:block' >Editar perguntas</a>";
		echo "<a href='mudarEstado.php?questionario=$QuestionarioID' class='box' style='display:block' >Mudar Estado do questionário</a>";*/
		?>
</div>
</body>
</html>